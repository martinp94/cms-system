<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Email</th>
            <th>Content</th>
            <th>Status</th>
            <th>In response to</th>
            <th>Date</th>
            <th>Options</th>
            
        </tr>
    </thead>

    <tbody>
    
    <?php

        if(!isset($_GET['p_id'])) 
        {
            $query = "SELECT * FROM comments
                      ORDER BY comment_status";
        }
        else
        {
            $p_id = $_GET['p_id'];

            $query = "SELECT * FROM comments
                      WHERE comment_post_id = {$p_id}
                      ORDER BY comment_status";
        }

        
        $comments = mysqli_query($connection, $query) or die(mysqli_error($connection));

        while($row = mysqli_fetch_assoc($comments))
        {

    ?>

    <tr>
        <td><?php echo $row['comment_id']; ?></td>
        <td><?php echo $row['comment_author']; ?></td>
        <td><?php echo $row['comment_email']; ?></td>
        <td><?php echo $row['comment_content']; ?></td>
        <td><?php echo $row['comment_status']; ?></td>
        <td>
        
        <?php

         	$query = "SELECT post_id, post_title FROM posts WHERE post_id = {$row['comment_post_id']}";
         	$post_title = mysqli_query($connection, $query);

         	while($row1 = mysqli_fetch_assoc($post_title))
         		echo "<a href='../post.php?p_id={$row1['post_id']}'>" . $row1['post_title'] .  "</a>";

        ?>
         	
        </td>
        <td><?php echo $row['comment_date']; ?></td>
        <td>
        	<a href="?approve&p_id=<?php echo $row['comment_id']; ?>">Approve</a>
        	<a href="?unapprove&p_id=<?php echo $row['comment_id']; ?>">Unppprove</a>
        	<a href="?delete&p_id=<?php echo $row['comment_id']; ?>">Delete</a>
        </td>
        
       
    </tr>


    <?php
        }

        if(isset($_GET['approve'])) 
        {
        	$comment_id = $_GET['p_id'];

        	$query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = {$comment_id}";
        	mysqli_query($connection, $query) or die(mysqli_error($connection));
        	header("Location: comments.php");
        }

        if(isset($_GET['unapprove'])) 
        {
        	$comment_id = $_GET['p_id'];

        	$query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = {$comment_id}";
        	mysqli_query($connection, $query) or die(mysqli_error($connection));
        	header("Location: comments.php");
        }

        if(isset($_GET['delete'])) 
        {
        	$comment_id = $_GET['p_id'];

        	$query = "SELECT comment_post_id from comments WHERE comment_id = {$comment_id}";
        	$post_id = mysqli_query($connection, $query) or die(mysqli_error($connection));
        	$result = mysqli_fetch_assoc($post_id);
        	$post_id = $result['comment_post_id'];

        	$query = "DELETE FROM comments WHERE comment_id = {$comment_id}";
        	mysqli_query($connection, $query) or die(mysqli_error($connection));



        	$query = "SELECT COUNT(comment_id) as 'comments_count' FROM comments WHERE comment_post_id = {$post_id}";
            $comments_count = mysqli_query($connection, $query) or die(mysqli_error($connection));
            $result = mysqli_fetch_assoc($comments_count);
            $comments_count = $result['comments_count'];

            $query = "UPDATE posts SET post_comment_count = {$comments_count} WHERE post_id = {$post_id}";
            mysqli_query($connection, $query) or die(mysqli_error($connection));

        	header("Location: comments.php");
        }
    ?>

    </tbody>

</table>