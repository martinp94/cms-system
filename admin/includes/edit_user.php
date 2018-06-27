<?php

if(isset($_POST['edit_user']))
{
	$the_user_id = $_GET['u_id'];
	$user_firstname = $_POST['user_firstname'];
	$user_lastname = $_POST['user_lastname'];
	$username = $_POST['username'];
	$email = $_POST['email'];

	$user_password = $_POST['user_password'];

	$passwordHash = password_hash($user_password, PASSWORD_DEFAULT);

	$passwordChangePart = $user_password == "defaultpassword" ? "" : ", user_password = '{$passwordHash}' ";

	$query = "UPDATE users SET ";
	$query .= "user_firstname = '{$user_firstname}', ";
	$query .= "user_lastname = '{$user_lastname}', ";
	$query .= "username = '{$username}', ";
	$query .= "user_email = '{$email}' ";
	$query .= $passwordChangePart;
	$query .= "WHERE user_id = {$the_user_id}";
	
	$update_user = mysqli_query($connection, $query) or die(mysqli_error($connection));

	header("Location: users.php");
}




if(isset($_GET['u_id']))
{
	$the_user_id = $_GET['u_id'];
	$query = "SELECT * FROM users WHERE user_id = {$the_user_id}";

	$user_query = mysqli_query($connection, $query) or die(mysqli_error($connection));

	if(!mysqli_num_rows($user_query))
		header("Location: users.php");

	while($row = mysqli_fetch_assoc($user_query))
	{

		$first_name = $row['user_firstname'];
		$last_name = $row['user_lastname'];
		$username = $row['username'];
		$email = $row['user_email'];
		$password = $row['user_password'];

?>

		<form action="" method="post" enctype="multipart/form-data">
			
			<div class="form-group">
				<label for="user_firstname">First Name</label>
				<input type="text" name="user_firstname" class="form-control" value="<?php echo $first_name; ?>">
			</div>

			<div class="form-group">
				<label for="user_lastname">Last Name</label>
				<input type="text" name="user_lastname" class="form-control" value="<?php echo $last_name; ?>">
			</div>
			
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
			</div>

			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
			</div>

			<div class="form-group">
				<label for="user_password">Password</label>
				<input type="password" name="user_password" class="form-control" value="defaultpassword">
			</div>

			<!-- <div class="form-group">
				<label for="image">Post Image</label>
				<input type="file" name="image" id="image" class="">
			</div> -->

			<div class="form-group">
				<input type="submit" name="edit_user" class="btn btn-primary" value="Edit User">
			</div>
		</form>		

<?php
	}


}
else
{
	header("Location: users.php");
}
?>







