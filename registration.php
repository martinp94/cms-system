<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>

<?php 

require './vendor/autoload.php'; 

$dotenv = new \Dotenv\Dotenv(__DIR__);
$dotenv->load();

$pusher = new Pusher\Pusher(getenv('APP_KEY'), getenv('APP_SECRET'), getenv('APP_ID'), [
    'cluster' => 'eu',
    'encrypted' => true
]);


    if(isset($_POST['registration']))
    {
        if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])
            && !empty($_POST['firstname']) && !empty($_POST['lastname']))
        {
            $username = escape($_POST['username']);
            $email = escape($_POST['email']);
            $password = escape($_POST['password']);
            $firstname = escape($_POST['firstname']);
            $lastname = escape($_POST['lastname']);

            

            if(register_user($username, $email, $password, $firstname, $lastname))
            {
                $data['message'] = $username;
                $pusher->trigger('notifications', 'new-user', $data);
                redirect("index");
                login_user($username, $password);
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
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" value="<?php echo isset($username) ? $username : ''; ?>" required />
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" required />
                        </div>
                        <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password" required />
                        </div>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">First Name</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter First Name" value="<?php echo isset($firstname) ? $firstname : ''; ?>" required />
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">Last Name</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Last Name" value="<?php echo isset($lastname) ? $lastname : ''; ?>" required />
                        </div>
                
                        <input type="submit" name="registration" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>

                    <?php
                        //displayErrors();
                    ?>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
