<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    
                </button>
                <a class="navbar-brand" href="index.php">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php 

                    $query = "SELECT cat_title FROM categories"; 


                    $result = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($result))
                    {
                    
                        echo "<li> <a href='#'> {$row['cat_title']} </a> </li>";
                    }

                    ?>
                    <li>
                        <a href="admin">Admin</a>
                    </li>

                    <?php
                        if(isset($_SESSION['role']))
                        {
                            if(isset($_GET['p_id']))
                            {
                                $the_post_id = $_GET['p_id'];
                                echo "<li> <a href='admin/posts.php?source=edit_post&p_id={$the_post_id}'> Edit Post </a> </li>";
                            }
                        }
                    ?>
                   
                  
                </ul>

                <?php
                if(isset($_SESSION['username']))
                { 
                ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" class="users_online">Users Online : 0</a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['username']; ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                <?php
                }
                ?>

                
            </div>
            <!-- /.navbar-collapse -->




        </div>

        <!-- /.container -->
    </nav>