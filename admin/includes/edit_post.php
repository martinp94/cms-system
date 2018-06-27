<?php
	
	if(isset($_GET['p_id']))
	{
		$edit_post_id = $_GET['p_id'];

		if(isset($_POST['update_post']))
		{
			$post_title = $_POST['title'];
			$post_author = $_POST['author'];
			$post_category = $_POST['post_category'];
			$post_status = $_POST['status'];
			
			$post_image = $_FILES['image']['name'];
			$post_image_temp = $_FILES['image']['tmp_name'];

			$post_tags = $_POST['tags'];
			$post_content = $_POST['content'];

			move_uploaded_file($post_image_temp, "../images/{$post_image}");

			$query = "UPDATE posts SET ";
			$query .= "post_title = '{$post_title}', ";
			$query .= "post_author = '{$post_author}', ";
			$query .= "post_category_id = {$post_category}, ";
			$query .= "post_date = now(), ";
			$query .= "post_status = '{$post_status}', ";
			if(!empty($post_image))
				$query .= "post_image = '{$post_image}', "; 
			$query .= "post_tags = '{$post_tags}', ";
			$query .= "post_content = '{$post_content}'";
			$query .= "WHERE post_id = {$edit_post_id}";

			if(mysqli_query($connection, $query))
			{
				echo "<p class='bg-success'> Post Updated.
				<a href='../post.php?p_id={$edit_post_id}'>
				View Post </a> or
				<a href='posts.php'>
				Edit more posts </a>
				</p>";
			}
			else die("Error " . mysqli_error($connection));

		}

        $query = "SELECT * FROM posts WHERE post_id = {$edit_post_id}";
        $posts = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($posts))
        {

        	$the_post_id = $row['post_id'];

        	$post_title = $row['post_title'];
        	$post_category_id = $row['post_category_id'];
        	$post_author = $row['post_author'];
        	$post_image = $row['post_image'];
        	$post_tags = $row['post_tags'];
        	$post_status = $row['post_status'];
        	$post_content = $row['post_content'];

        	



?>

<form action="" method="post" enctype="multipart/form-data">
	
	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" name="title" id="title" value="<?php echo $post_title; ?>" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_category">Category</label>
		<select name="post_category" id="post_category" class="form-control">
			
			<?php

			$query = "SELECT cat_id, cat_title FROM categories"; 
    		$categories = mysqli_query($connection, $query);

    		while($row = mysqli_fetch_assoc($categories)) {
    			echo "<option value={$row['cat_id']}> {$row['cat_title']} </option>";
    		}


			?>

		</select>
	</div>

	<div class="form-group">
		<label for="author">Author</label>
		<select name="author" id="author" class="form-control">
			
			<?php

			$query = "SELECT * FROM users"; 
    		$users = mysqli_query($connection, $query);

    		while($row = mysqli_fetch_assoc($users)) {
    			echo "<option value={$row['user_id']}> {$row['username']} </option>";
    		}

			?>

		</select>
	</div>


	<div class="form-group">
		<label for="status">Post Status</label>
		<select name="status" id="status" class="form-control">
			
			<?php

			if($post_status == 'Draft') 
			{ 
				echo "<option value='Published'> Published </option>";
				echo "<option value='Draft'> Draft </option>";
			}
			else
			{
				echo "<option value='Draft'> Draft </option>";
				echo "<option value='Published'> Published </option>";
			}

			?>

		</select>
		
	</div>

	<div class="form-group">
		<label for="image">Post Image</label>
		<input type="file" name="image" id="image" class="">
	</div>

	<div class="form-group">
		<img width="100" src="../images/<?php echo $post_image; ?>">
	</div>

	<div class="form-group">
		<label for="tags">Post Tags</label>
		<input type="text" name="tags" id="tags" value="<?php echo $post_tags; ?>" class="form-control">
	</div>

	<div class="form-group">
		<label for="content"></label>
		<textarea id="editor" name="content" class="form-control" cols="30" rows="10" style="resize: none;"><?php echo $post_content; ?></textarea>
	</div>

	<div class="form-group">
		<input type="submit" name="update_post" class="btn btn-primary" value="Publish">
	</div>
</form>

<?php
}
}
?>

