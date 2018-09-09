
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

                $post_id;

                if(isset($_GET['p_id']))
                {
                    $post_id = $_GET['p_id'];
                }

                if(empty($post_id))
                    header("Location: index.php");

                $update_post_views_count_query = "UPDATE posts SET post_views_count = post_views_count + 1
                                                  WHERE post_id = {$post_id}";
                mysqli_query($connection, $update_post_views_count_query);

                $query = "SELECT * FROM posts WHERE post_id = {$post_id}";
                $result = mysqli_query($connection, $query);

                while($row = mysqli_fetch_assoc($result))
                {

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
                    by 
                    <?php 

                    $author_id = $row['post_author']; 
                    
                    $author = mysqli_query($connection, "SELECT username FROM users
                                                         WHERE user_id = {$author_id}") 
                                                        or die(mysqli_error($connection));
                    echo mysqli_fetch_assoc($author)['username'];

                    ?>
                    
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>

                
                <div class="row">

                    <div class="col-md-2 pull-right">
                        <?php 

                            if(countLikes($connection, $the_post_id) == 0)
                            {
                                echo "<a id='like' href='#'> <strong> <span class='glyphicon glyphicon-thumbs-up'> </span> Like </strong> </a>";
                            }
                            else
                            {
                                echo "<a id='like' href='#'> <strong> <span class='glyphicon glyphicon-thumbs-down'> </span> Dislike </strong> </a>";
                            }


                        ?>
                    </div>
                    

                    
                </div>

                <div id class="row">
                    <div class="col-md-2 pull-right">
                        <strong>Likes:</strong>
                        <span class='numlikes'>
                            <?php echo countLikes($connection, $post_id, true); ?>
                        </span>
                    </div>
                    
                </div>

                <hr>

                <?php
                }
                ?>

                <!-- Blog Comments -->


                <?php 
                    if(isset($_POST['create_comment'])) 
                    {
                        $the_post_id = escape($_POST['p_id']);

                        $comment_author = escape($_POST['comment_author']);
                        $comment_email = escape($_POST['comment_email']);
                        $comment_content = escape($_POST['comment_content']);

                        $error_message = "";

                        if(empty($comment_author))
                            $error_message .= 'author, ';
                        if(empty($comment_email))
                            $error_message .= 'email, ';

                        if(!empty($comment_author) && !empty($comment_email)) 
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
                    <form action="/cms/post.php" method="POST" role="form">

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

                        <input type="hidden" name="p_id" value="<?php echo $_GET['p_id']; ?>">

                        <button name="create_comment" type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                


                <!-- Posted Comments -->

                <hr>
                <?php

                $the_post_id = $_GET['p_id'];


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


<script>
    
    const p_id = <?php echo $post_id; ?>;    

    const numlikes = document.querySelector(".numlikes");

    document.querySelector("#like").addEventListener('click', likeEventHandler);

    function likeEventHandler(e) {

        const link = e.currentTarget;
        

        let xhr = new XMLHttpRequest();
        xhr.open('POST', '/cms/functions.php', true);

        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                link.innerHTML = xhr.responseText;
            }
        }

        xhr.send("post_id=" + p_id);

        e.preventDefault();
    }


    setInterval(() => {
        let xhr = new XMLHttpRequest();

        let url = '/cms/functions.php?p_count=' + p_id;
        xhr.open("GET", url , true);

        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                console.log(xhr.responseText);
                numlikes.textContent = xhr.responseText;
                
            }
        }

        xhr.send();
    }, 1000);

</script>
