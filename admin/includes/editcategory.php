<?php include "../../includes/db.php"; ?>

<?php


    function edit_categories() 
    {
        global $connection;
        if(isset($_POST['editCategory']))
        {
            $cat = json_decode($_POST['editCategory']);

            $cat_id = $cat->cat_id;
            $cat_title = $cat->cat_title;



            $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ?");

            mysqli_stmt_bind_param($stmt, "si", $cat_title, $cat_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            echo $cat_title;
        }
    }

    if(isset($_POST['editCategory']))
    {
        edit_categories();
    }

?>