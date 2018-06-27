<?php

if(isset($_POST['create_post']))
{
	$post_title = escape($_POST['title']);
	$post_author = escape($_POST['author']);
	$post_category_id = escape($_POST['post_category']);


	$post_image = $_FILES['image']['name'];
	$post_image_temp = $_FILES['image']['tmp_name'];

	$post_tags = escape($_POST['tags']);
	$post_content = escape($_POST['content']);
	$post_date = escape(date('Y-m-d'));
	$post_comment_count = 0;

	move_uploaded_file($post_image_temp, "../images/$post_image");

	$query = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status)";

	$query .= "VALUES ('{$post_category_id}', '{$post_title}', '{$post_author}', '{$post_date}' ,'{$post_image}', '{$post_content}', '{$post_tags}', '{$post_comment_count}', 'Draft')";

	$insertPost = mysqli_query($connection, $query);

	if($insertPost)
	{
		$the_last_id = mysqli_insert_id($connection);

		echo "<p class='bg-success'> Post Added.
		<a href='../post.php?p_id={$the_last_id}'>
		View Post </a> or
		<a href='posts.php?source=add'>
		Add more posts </a>
		</p>";
	}
	else die("Error " . mysqli_error($connection));

}
	
?>





<form action="" method="post" enctype="multipart/form-data">
	
	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" name="title" id="title" class="form-control">
	</div>

	<div class="form-group">
		<label for="post_category">Post Category</label>

		<select name="post_category" id="post_category" class="form-control">
			<?php
				$query = "SELECT * FROM categories";
				$categories = mysqli_query($connection, $query);

				while($row = mysqli_fetch_assoc($categories))
				{
					$cat_id = $row['cat_id'];
					$category = $row['cat_title'];

					echo "<option value='{$cat_id}'> {$category} </option>";
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
		<label for="image">Post Image</label>
		<input type="file" name="image" id="image" class="">
	</div>

	<div class="form-group">
		<label for="tags">Post Tags</label>
		<input type="text" name="tags" id="tags" class="form-control">
	</div>

	<div class="form-group">
		<label for="content">Post Content</label>
		<textarea id="editor" name="content" class="form-control" cols="30" rows="10" style="resize: none;"></textarea>
	</div>

	<div class="form-group">
		<input type="submit" name="create_post" class="btn btn-primary" value="Publish">
	</div>
</form>

