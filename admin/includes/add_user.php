<?php

if(isset($_POST['create_user']))
{

	$user_firstname = $_POST['user_firstname'];
	$user_lastname = $_POST['user_lastname'];
	$user_role = $_POST['user_role'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$user_password = $_POST['user_password'];


	$password_hash = password_hash($user_password, PASSWORD_DEFAULT, array('cost' => 12));

	

	$query = "INSERT INTO users (user_firstname, user_lastname, user_role, username, user_email, user_password)";

	$query .= "VALUES ('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}' ,'{$email}', '{$password_hash}')";

	$create_user = mysqli_query($connection, $query);

	header("Location: users.php?source=add");
}
	
?>





<form action="" method="post" enctype="multipart/form-data">
	
	<div class="form-group">
		<label for="user_firstname">First Name</label>
		<input type="text" name="user_firstname" class="form-control">
	</div>

	<div class="form-group">
		<label for="user_lastname">Last Name</label>
		<input type="text" name="user_lastname" class="form-control">
	</div>

	<div class="form-group">
		<select name="user_role" class="form-control">
			<option value="subscriber">Select options</option>
			<option value="admin">Admin</option>
			<option value="subscriber">Subscriber</option>
		</select>
	</div>
	

	<div class="form-group">
		<label for="username">Username</label>
		<input type="text" name="username" class="form-control">
	</div>

	<div class="form-group">
		<label for="email">E-mail</label>
		<input type="email" name="email" class="form-control">
	</div>

	<div class="form-group">
		<label for="user_password">Password</label>
		<input type="password" name="user_password" class="form-control">
	</div>

	<!-- <div class="form-group">
		<label for="image">Post Image</label>
		<input type="file" name="image" id="image" class="">
	</div> -->

	<div class="form-group">
		<input type="submit" name="create_user" class="btn btn-primary" value="Create User">
	</div>
</form>

