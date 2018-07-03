<?php

include 'delete_modal.php';

if(isset($_POST['checkBoxArray']))
{

    $boxes = $_POST['checkBoxArray'];
    $option = $_POST['bulk_options'];

    $ids = implode(", ", $boxes);

    $query = "";

    if($option) {
        switch ($option) {
            case 'Publish':
                $query = "UPDATE posts SET post_status = 'Published'
                WHERE post_id IN ({$ids})";
                echo $query;
                break;

            case 'Draft':
                $query = "UPDATE posts SET post_status = 'Draft'
                WHERE post_id IN ({$ids})";
                echo $query;
                break;

            case 'Delete':
                $query = "DELETE FROM posts
                WHERE post_id IN ({$ids})";
                echo $query;
                break;

            case 'Clone':
                $query = "INSERT INTO posts 
                          (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status)
                          SELECT post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status
                          FROM posts WHERE post_id IN ({$ids})";
                echo $query;
                break;

            case 'Reset views':
                $query = "UPDATE posts 
                          SET post_views_count = 0
                          WHERE post_id IN ({$ids})";
                echo $query;
                break;

            
            default:
                # code...
                break;
        }
    }

    if($query)
        mysqli_query($connection, $query) or die(mysqli_error($connection));


}

?>


<form method="POST" action="">
    <table class="table table-hover table-bordered" style="margin: 15px;">

        <div id="bulkOptionsContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="Publish">Publish</option>
                <option value="Draft">Draft</option>
                <option value="Delete">Delete</option>
                <option value="Clone">Clone</option>
                <option value="Reset views">Reset views</option>
            </select>
        </div>

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a href="posts.php?source=add" class="btn btn-primary">Add new</a>
        </div>

        <thead>
            <tr>
                <th><input id="selectAllBoxes" type="checkbox"></th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Views</th>
                <th>Options</th>
            </tr>
        </thead>

        <tbody>
        
        <?php

            $query = "SELECT * FROM posts";
            $posts = mysqli_query($connection, $query);

            deletePosts();
            editPosts();

            while($row = mysqli_fetch_assoc($posts))
            {

        ?>

        <tr>
            <td><input class="checkBoxes" value="<?php echo $row['post_id']; ?>" type="checkbox" name="checkBoxArray[]"></td>
            <td>
                <?php 

                $author_id = $row['post_author']; 
                
                $author = mysqli_query($connection, "SELECT username FROM users
                                                     WHERE user_id = {$author_id}") 
                                                    or die(mysqli_error($connection));
                echo mysqli_fetch_assoc($author)['username'];

                ?>
                
            </td>
            <td><?php echo $row['post_title']; ?></td>
            <td>
               
                <?php

                $query = "SELECT cat_title FROM categories WHERE cat_id = {$row['post_category_id']}";
                $category = mysqli_query($connection, $query);
                while($row1 = mysqli_fetch_assoc($category))
                {
                    echo $row1['cat_title']; 
                }
                ?>
                    
            </td>
            <td><?php echo $row['post_status']; ?></td>
            <td><img width='100' src='../images/<?php echo $row['post_image']; ?>' alt='post_image'></td>
            <td><?php echo $row['post_tags']; ?></td>
            <td>
                <a href="comments.php?p_id=<?php echo $row['post_id']; ?>">
                <?php
                    $comment_count = mysqli_query($connection, "SELECT COUNT(*) as 'count' FROM comments
                        WHERE comment_post_id = {$row['post_id']}") or die(mysqli_error($connection));

                    echo mysqli_fetch_assoc($comment_count)['count'];
                ?>
                </a>
            </td>
            <td><?php echo $row['post_date']; ?></td>
            <td><?php echo $row['post_views_count']; ?></td>
            <td> 
                <a class="btn btn-primary" href="../post/<?php echo $row['post_id']; ?>">View</a> | 
                <a class="btn btn-warning" href="?source=edit_post&p_id=<?php echo $row['post_id']; ?>">Edit</a> 
                |
                <form method="POST">
                    <input type="hidden" name="delete_post_id" value="<?php echo $row['post_id']; ?>">

                    <button class="btn btn-danger" type="submit" name="deletepost">Delete</button>
                </form>
                 

            </td>
        </tr>


        <?php
            }
        ?>

        </tbody>

    </table>
</form>

<script>

$(() => {

    document.querySelectorAll(".delete_link").forEach((del) => {

        const id = del.getAttribute("rel");
        const delete_url = "posts.php?delete=" + id + "";

        

        const modal_delete_link = document.querySelector(".modal_delete_link");
        modal_delete_link.setAttribute("href", delete_url);

        del.addEventListener("click", () => {
            $("#myModal").modal("show");
        });
        


     });

});



</script>

