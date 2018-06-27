<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>

    <?php

        if(isset($_POST['submit']))
        {
            if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])
                && !empty($_POST['firstname']) && !empty($_POST['lastname']))
            {
                $username = escape($_POST['username']);
                $email = escape($_POST['email']);
                $password = escape($_POST['password']);
                $firstname = escape($_POST['firstname']);
                $lastname = escape($_POST['lastname']);

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                $query = "INSERT INTO users (username, user_email, user_password, user_role, user_firstname, user_lastname) 
                          VALUES('{$username}', '{$email}', '{$passwordHash}', 'subscriber', '{$firstname}', '{$lastname}')";



                $register_user = mysqli_query($connection, $query);
                if($register_user) 
                {
                    echo "<script> alert('Registration succeeded'); </script>";
                    header("Location: index.php");
                }
                else
                {
                    echo 'Greska: ' . mysqli_error($connection);
                }
            }
            else
            {
                echo "<script> alert('Morate popuniti polja za registraciju'); </script>";
            }
        }

    ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">First Name</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter First Name">
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Last Name">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
