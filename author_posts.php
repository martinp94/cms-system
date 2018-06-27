
<?php require_once "includes/db.php"; ?>
<!-- Header -->

<?php include "includes/header.php"; ?>
    
    <!-- Navigation -->

    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

                if(isset($_GET['author']))
                {
                    $author = $_GET['author'];
                }

                if(empty($author))
                    header("Location: index.php");

                $query = "SELECT * FROM posts WHERE post_author = {$author}";
                $result = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($result))
                {
                    $the_post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_author'];
                    $post_date = $row['post_date'];
                    $post_content = $row['post_content'];
                    $post_image = $row['post_image'];
                ?>


                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author='<?php echo $post_author; ?>'"><?php echo $post_author; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                

                <hr>

                <?php
                }
                ?>

                <!-- Blog Comments -->


                <?php 
                    if(isset($_POST['create_comment'])) 
                    {

                        $comment_author = $_POST['comment_author'];
                        $comment_email = $_POST['comment_email'];
                        $comment_content = trim($_POST['comment_content']);

                        $error_message = "";

                        if(empty($comment_author))
                            $error_message .= 'author, ';
                        if(empty($comment_email))
                            $error_message .= 'email, ';
                        if(strlen($comment_content) <= 13)
                            $error_message .= 'content ';

                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) 
                        {
                            
                            $values = array(
                            $the_post_id,
                            $comment_author,
                            $comment_email,
                            $comment_content,
                            'Unapproved'
                            );

                            $values = implode("','", $values);

                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES('{$values}', NOW());";

                            mysqli_query($connection, $query) or die(mysqli_error($connection));

                            $query = "SELECT COUNT(comment_id) as 'comments_count' FROM comments where comment_post_id = {$the_post_id}";
                            $comments_count = mysqli_query($connection, $query) or die(mysqli_error($connection));
                            $result = mysqli_fetch_assoc($comments_count);
                            $comments_count = $result['comments_count'];

                            $query = "UPDATE posts SET post_comment_count = {$comments_count} WHERE post_id = {$the_post_id}";
                            mysqli_query($connection, $query) or die(mysqli_error($connection));
                            
                            header("Location: post.php?p_id={$the_post_id}");
                        }
                        else 
                        {
                            
                            echo "<script> alert('Fields missing: " . $error_message . "'); </script>";
                        } 
                    }
                ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="POST" role="form">

                        <div class="form-group">
                            <label for="comment_author">Author</label>
                            <input type="text" name="comment_author" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="comment_email">Email</label>
                            <input type="email" name="comment_email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="comment_content">Your comment</label>
                            <textarea id="editor" name="comment_content" class="form-control"></textarea>
                        </div>

                        <button name="create_comment" type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>


                <!-- Posted Comments -->

                <hr>
                <?php

                $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} AND comment_status = 'Approved' ORDER BY comment_id DESC";
                $comments = mysqli_query($connection, $query);
                while($row = mysqli_fetch_assoc($comments))
                {


                ?>

                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $row['comment_author']; ?>
                            <small><?php echo $row['comment_date']; ?></small>
                        </h4>
                       <p><?php echo $row['comment_content']; ?></p>
                    </div>
                </div>

                <?php } ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        <hr>

        

<?php include "includes/footer.php"; ?>
