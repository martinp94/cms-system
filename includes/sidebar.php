<div class="col-md-4">

    <?php

        if(!isset($_SESSION['username']))
        {
    ?>

    <!-- Login -->
    <div class="well">
        <h4>Login</h4>
        <form method="POST" action="/cms/login-complete.php">
            <div class="form-group">
                
                <input name="username" type="text" class="form-control" placeholder="Enter username">
            </div>

            <div class="form-group">
                <input name="password" type="password" class="form-control" placeholder="Enter password">
            </div>

            <div class="form-group">
                <button class="btn btn-primary form-control" name="login" type="submit">
                    Login
                </button>
            </div>

            
        </form>
        <!-- /.input-group -->
        <p>Nemate nalog? <br> <a href="registration">Registracija</a></p>

        <p> <a href="/cms/forgot-complete.php?forgot=<?php echo uniqid(true); ?>">Forgot password?</a> </p>
    </div>

    <?php
        }
    ?>

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form method="POST" action="search.php">
            <div class="input-group">
                
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button class="btn btn-default form-control" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>







    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>

        <div class="row">
            <div class="col-lg-6">
                <ul class="list-unstyled">
                    <?php 

                    $query = "SELECT * FROM categories";
                    
                    $categories = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($categories)) :
                    ?>
                        <li><a href="/cms/category/<?php echo $row['cat_id']; ?>"><?php echo $row['cat_title']; ?></a> </li>
                    
                    <?php
                    endwhile;
                    ?>
                </ul>
            </div>
            
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>

    <?php include "widget.php"; ?>

    </div>

</div>
<!-- /.row -->