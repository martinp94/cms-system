<!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    
                </button>
                <a class="navbar-brand" href="/cms/index">Home</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php 

                    $query = "SELECT * FROM categories"; 


                    $result = mysqli_query($connection, $query);

                    while($row = mysqli_fetch_assoc($result))
                    {
                        $pageName = basename($_SERVER["PHP_SELF"]);

                        if(isset($_GET['category']) && $_GET['category'] == $row['cat_id']) 
                        {
                            echo "<li class='active'> <a href='/cms/category.php?category={$row['cat_id']}'> {$row['cat_title']} </a> </li>";
                        }
                        else
                        {
                            echo "<li> <a href='/cms/category.php?category={$row['cat_id']}'> {$row['cat_title']} </a> </li>";
                        }

                    
                        
                    }

                    ?>
                    

                    <?php
                        if(isset($_SESSION['role']))
                        {
                            if(isset($_GET['p_id']))
                            {
                                $the_post_id = $_GET['p_id'];
                                echo "<li> <a href='/cms/admin/posts.php?source=edit_post&p_id={$the_post_id}'> Edit Post </a> </li>";
                            }
                        }
                    ?>

                    <li>
                        <a href="/cms/contact">Contact</a>
                    </li>
                   
                  
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
                                    <a href="/cms/includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                        
                        <?php if(is_admin($_SESSION['username'])): ?>
                            <li> <a href="/cms/admin">Admin</a> </li>
                        <?php endif; ?>
                    
                    </ul>
                <?php
                }
                else
                {
                ?>

                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="/cms/login.php">Login</a></li>


                        
                    </ul>

                <?php

                }
                ?>

                
            </div>
            <!-- /.navbar-collapse -->




        </div>

        <!-- /.container -->
    </nav>