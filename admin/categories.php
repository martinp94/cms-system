<?php include_once "includes/admin_header.php"; ?>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/admin_navigation.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                        </h1>

                        <div class="col-xs-6">

                            <?php

                            insert_categories();

                            ?>

                            <form method="POST" action="categories.php">
                                <div class="form-group">
                                    <label for="cat_title">Add Category</label>
                                    <input class="form-control" type="text" name="cat_title">
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Add category">
                                </div>
                            </form>

                        </div> <!-- Add category div -->

                        <div class="col-xs-6">
                            <?php find_all_categories(); ?>
                        </div>

                            
                        </div>
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->



    <?php include_once "includes/admin_footer.php"; ?>

    <script>

        let editCategoryTitle,
            selectedId;;

        function edit(id) {
            selectedId = id;
            editCategoryTitle();
        }

        $(function(){

            editCategoryTitle = function() {
                $("#title" + selectedId).html('<input id=edit' + selectedId + ' type="text" />');
                $("#edit" + selectedId).blur(function(){

                    let title = $(this).val();

                    let toSend = JSON.stringify({
                        cat_id : selectedId,
                        cat_title : title

                    });

                    $.ajax({
                        url : 'includes/editcategory.php',
                        type : 'post',
                        data : { editCategory : toSend},
                        dataType : 'text',
                        success : function(data) {
                            console.log(data['cat_title']);
                            $("#title" + selectedId).html(data);
                        },
                        error : function(err) {
                            console.log(err);
                        }

                    });
                    
                });
            }
            
         });
    </script>