<?php include 'db.php'; ?>
<?php session_start(); ?>

<?php



if(isset($_POST['login']))
{
	$username = $_POST['username'];
	$password = $_POST['password'];

	$username = mysqli_real_escape_string($connection, $username);
	$password = mysqli_real_escape_string($connection, $password);

	if($role = checkCredentials($username, $password)) 
	{
		if($role !== 'admin') 
			header("Location: ../index.php");
		else
			header("Location: ../admin/index.php");
	}
	else 
	{
		header("Location: ../index.php");
	}


	

}




function checkCredentials($username, $password) 
{
	global $connection;

	$query = "SELECT * FROM users WHERE username = '{$username}'";

	$result = mysqli_query($connection, $query);
	
	if($result)
	{
		if(mysqli_num_rows($result))
		{
			$row = mysqli_fetch_assoc($result);

			$passwordHash = $row['user_password'];

			if(password_verify($password, $passwordHash))
			{
				$_SESSION['username'] = $row['username'];
				$_SESSION['firstname'] = $row['user_firstname'];
				$_SESSION['lastname'] = $row['user_lastname'];
				$_SESSION['role'] = $row['user_role'];
				return $row["user_role"];
			}
			
			return false;
		}
		else
		{
			echo "User doesn't exists";
			return false;
		}
	}
	else
	{
		die(mysqli_error($connection));
		return false;
	}

}

?>