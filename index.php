
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

                $posts_count = mysqli_fetch_assoc(mysqli_query($connection, "SELECT COUNT(*) as 'count' FROM posts"))['count'];

                $items_per_page = 5;

                $pages = ceil($posts_count / $items_per_page);

                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

                $offset = ($current_page - 1) * $items_per_page;

                $query = "SELECT * FROM posts WHERE post_status = 'Published' ORDER BY post_date DESC
                          LIMIT {$items_per_page} OFFSET {$offset}";
                $result = mysqli_query($connection, $query);

                if(mysqli_num_rows($result))
                {
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_content = $row['post_content'];
                        $post_image = $row['post_image'];
                    ?>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
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

                    <a href="post.php?p_id=<?php echo $post_id; ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    </a>
                    
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    

                    <hr>

                    <?php
                    }
                    ?>

                    <ul class="pager">
                        <?php
                            if($pages)
                            {
                                echo "<a href='?page=1'> Prva </a>";
                                for($i = 1; $i <= $pages; $i++) {
                                    if($i == $current_page)
                                        echo "<li class='active'><a href='?page={$i}'> {$i} </a></li>";
                                    else
                                        echo "<li><a href='?page={$i}'> {$i} </a></li>";
                                }
                            } 
                        ?>
                    </ul>

                <?php
                }
                else
                {
                    echo "<h1> No posts availible </h1>";
                }

                ?>

                


                


                

            </div>


            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        <hr>

<?php include "includes/footer.php"; ?>
