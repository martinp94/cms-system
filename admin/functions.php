<?php


function escape($string) 
{
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function users_online() 
{
    global $connection;

    $session_id = session_id();

    $query = "SELECT * FROM users_online 
              WHERE session = '{$session_id}'";

    $time = time();
    $timeout = $time - 10;

    $send_query = mysqli_query($connection, $query);
    $count = mysqli_num_rows($send_query);

    if(!$count)
    {
        mysqli_query($connection, "INSERT INTO users_online (session, time) 
                                   VALUES ('{$session_id}', {$time})")
        or die(mysqli_error($connection));
    }
    else
    {
        mysqli_query($connection, "UPDATE users_online SET time = {$time}
                                   WHERE session = '{$session_id}'")
        or die(mysqli_error($connection));
    }

    $users_online = mysqli_query($connection, "SELECT COUNT(*) as 'count' FROM users_online
                                               WHERE time > {$timeout}")
    or die(mysqli_error($connection));

    $users_online = mysqli_fetch_assoc($users_online)['count'];

    return $users_online;
}

function insert_categories()
{

	global $connection;

	if(isset($_POST['submit']))
    {
        $title = escape($_POST['cat_title']);

        unset($_POST['cat_title']);

        if($title)
        {


        	// Check if exists
			$query = "SELECT * FROM categories WHERE cat_title = '{$title}'";
        	echo "<h1> " . $query . " </h1>";
        	$result = mysqli_query($connection, $query);

        	// IF DOESN'T EXISTS THEN INSERT
        	if(mysqli_num_rows($result) === 0)
        	{
        		$query = "INSERT INTO categories (cat_title) VALUES ('{$title}')";
	            $insertCategory = mysqli_query($connection, $query);

	            if(!$insertCategory)
	            
				{
	                die("Connection failed " . mysqli_error($connection));
	            }
			}
  			
  			header('Location: categories.php');
        } 
        else
        {
            echo "<h1> MRS </h1>";
        }

        

    }
}

function edit_categories() 
{

	include '../includes/db.php';
	//global $connection;
	
	if(isset($_POST['editCategory']))
	{
		$cat = json_decode($_POST['editCategory']);

	    $cat_id = $cat->cat_id;
	    $cat_title = $cat->cat_title;



	    $query = "UPDATE categories SET cat_title = '{$cat_title}' WHERE cat_id = {$cat_id}";

	    $editCategory = mysqli_query($connection, $query);

	    if(!$editCategory){
	    	die(mysqli_error($connection));
	    }

	    echo $cat_title;
	}
}

if(isset($_POST['editCategory']))
{
	edit_categories();
}



function delete_categories()
{

	global $connection;

	if(isset($_GET['delete']))
    {
        $deleteCatId = $_GET['delete'];

        if($deleteCatId)
        {
            $query = "DELETE FROM categories WHERE cat_id = {$deleteCatId}";
            $deleteCategory = mysqli_query($connection, $query);

            if(!$deleteCategory)
            {
                die("Connection failed " . mysqli_error($connection));
            }
        }

        header('Location: categories.php');
    }
}

function find_all_categories()
{

	global $connection;

	$query = "SELECT * FROM categories"; 
    $categories = mysqli_query($connection, $query);

    
    echo '<table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">Id</th>
                    <th class="text-center">Category title</th>
                    <th class="text-center">Options</th>
                </tr>
            </thead>
    
            <tbody>';
            

            delete_categories();


            while($row = mysqli_fetch_assoc($categories))
            {

            echo '<tr>
                    <td>' . $row["cat_id"] . '</td>
                                        <td id="title' . $row['cat_id'] . '">' . $row['cat_title'] . '</td>
                                        <td class="text-center"> <a href="javascript:edit(' . $row["cat_id"] . ')"> <span class="glyphicon glyphicon-edit"> </span> </a>
                                        <a href="?delete=' . $row['cat_id'] . '"> <span class="glyphicon glyphicon-trash" style="color: darkred;"> </span> </a></td>
                                    </tr>';


            
            }
            
        	echo '</tbody>
            </table>';
}



function deletePosts()
{
    global $connection;

    if(!isset($_SESSION['role']))
        return false;

    if($_SESSION['role'] != 'admin')
        return false;

    if(isset($_GET['delete']))
    {
        $query = "DELETE FROM posts WHERE post_id = {$_GET['delete']}";
        if(mysqli_query($connection, $query))
            header("Location: posts.php");
    }
}

function editPosts()
{
    global $connection;

    if(isset($_GET['edit']))
    {
        $query = "UPDATE posts SET post_content =  WHERE post_id = {$_GET['edit']}";
    }
}

function tableRowCounter($table, $where = []) 
{
    global $connection;
    $counter;

    if(count($where)) 
    {
        $column = array_keys($where)[0];
        $value = $where[$column];

        $counter = mysqli_query(
            $connection,
            "SELECT COUNT(*) as 'count' FROM {$table} WHERE {$column} = '{$value}'"
        );

        if(!$counter)
            die(mysqli_error($connection));

        $counter = mysqli_fetch_assoc($counter);
    }
    else
    {
        $counter = mysqli_query(
            $connection,
            "SELECT COUNT(*) as 'count' FROM {$table}"
        );

        if(!$counter)
            die(mysqli_error($connection));

        $counter = mysqli_fetch_assoc($counter);
    }
    

    return $counter['count'];
}


?>