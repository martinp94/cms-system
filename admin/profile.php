
<?php include_once "includes/admin_header.php"; ?>

    <?php 
        if(isset($_SESSION['username']))
        {
            $username = $_SESSION['username'];

            $query = "SELECT * FROM users WHERE username = '{$username}'";

            $user_result = mysqli_query($connection, $query);

            if(!mysqli_num_rows($user_result))
                header("Location: ../includes/logout.php");

            while($row = mysqli_fetch_assoc($user_result)) 
            {
                $user_id = $row['user_id'];
                $user_username = $row['username'];
                $user_password = $row['user_password'];
                $user_firstname = $row['user_firstname'];
                $user_lastname = $row['user_lastname'];
                $user_email = $row['user_email'];
                $user_image = $row['user_image'];
                $user_role = $row['user_role'];
                $user_randSalt = $row['randSalt'];

            }
        }

        if(isset($_POST['update_user']))
        {
            $the_username = $_SESSION['username'];

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
            $query .= "WHERE username = '{$the_username}'";
            
            $update_user = mysqli_query($connection, $query) or die(mysqli_error($connection));

            header("Location: profile.php");
        }
    ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Profile
                            <small>Author</small>
                        </h1>

                        <form action="" method="post" enctype="multipart/form-data">
            
                            <div class="form-group">
                                <label for="user_firstname">First Name</label>
                                <input type="text" name="user_firstname" class="form-control" value="<?php echo $user_firstname; ?>">
                            </div>

                            <div class="form-group">
                                <label for="user_lastname">Last Name</label>
                                <input type="text" name="user_lastname" class="form-control" value="<?php echo $user_lastname; ?>">
                            </div>
                            
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $user_username; ?>">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $user_email; ?>">
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
                                <input type="submit" name="update_user" class="btn btn-primary" value="Update Profile">
                            </div>
                        </form> 


                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>
    <!-- /#page-wrapper -->



    <?php include_once "includes/admin_footer.php"; ?>