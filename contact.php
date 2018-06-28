<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>

    <?php

        if(isset($_POST['submit']))
        {
            if(!empty($_POST['subject']) && !empty($_POST['body']))
            {
                $subject = $_POST['subject'];
                $body = strip_tags($_POST['body']);

                mail("martinpopovicfit@gmail.com", $subject, $body);
                header("Location: index.php");
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
                <h1>Contact</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">

                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter subject">
                        </div>

                        <div class="form-group">
                            <label for="body" class="sr-only">Body</label>
                            <textarea name="body" id="editor" class="form-control"></textarea>
                        </div>
                       
                        
                
                        <input type="submit" name="submit" id="btn-contact" class="btn btn-custom btn-lg btn-block" value="Send">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
