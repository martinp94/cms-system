
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

                if(isset($_GET['category']))
                {
                    $post_category_id = $_GET['category'];
                }
                else
                {
                    header("Location: index.php");
                }

                if(isset($_SESSION['username']))
                    if(is_admin($_SESSION['username'])) 
                    {
                        $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ?");

                    }
                    else
                    {
                        $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ?");
                        $published = "Published";
                    }


                if(isset($stmt1))
                {
                    mysqli_stmt_bind_param($stmt1, "i", $post_category_id);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    $stmt = $stmt1;
                 
                }

                if(isset($stmt2))
                {
                    mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    $stmt = $stmt2;

                }

                

                mysqli_stmt_store_result($stmt);
                
                
                

                if(mysqli_stmt_num_rows($stmt))
                {

                    while(mysqli_stmt_fetch($stmt)) :
                        
                    ?>


                    <!-- First Blog Post -->
                    <h2>
                        <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                       
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                    <hr>
                    <img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="">
                    <hr>
                    <p><?php echo $post_content; ?></p>
                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>
                <?php

                    endwhile;
                    mysqli_stmt_free_result($stmt);
                    mysqli_stmt_close($stmt);
                }
                else
                {
                    echo "<h1> No posts for this category </h1>";
                }
                ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        <hr>

<?php include "includes/footer.php"; ?>
