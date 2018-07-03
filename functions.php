<?php
session_start();

function redirect($location){


    header("Location:" . $location);
    exit;

}


function ifItIsMethod($method=null){

    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){

        return true;

    }

    return false;

}

function countLikes($connection, $post_id, $all = false) {


    $user_id = $_SESSION['user_id'];

    if(!$all)
    {
      $stmt = mysqli_prepare($connection, "SELECT COUNT(id) as 'l_count' FROM likes WHERE post_id = ? AND user_id = ?");
      mysqli_stmt_bind_param($stmt, 'ii', $post_id, $user_id);
        
    }
    else
    {
      $stmt = mysqli_prepare($connection, "SELECT COUNT(id) as 'l_count' FROM likes WHERE post_id = ?");
      mysqli_stmt_bind_param($stmt, 'i', $post_id);
        
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $l_count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    



    return $l_count;
}

function updateLike($post_id)
{
    include 'includes/db.php';

    $user_id = $_SESSION['user_id'];

    $l_count = countLikes($connection, $post_id);

    if($l_count == 0)
    {
        $stmt = mysqli_prepare($connection, "INSERT INTO likes (post_id, user_id) VALUES(?, ?)");

        mysqli_stmt_bind_param($stmt, 'ii', $post_id, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo "<strong> <span class='glyphicon glyphicon-thumbs-down'> </span> Dislike </strong>";
    }
    else
    {
        $stmt = mysqli_prepare($connection, "DELETE FROM likes WHERE post_id = ? AND user_id = ?");

        mysqli_stmt_bind_param($stmt, 'ii', $post_id, $user_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        echo "<strong> <span class='glyphicon glyphicon-thumbs-up'> </span> Like </strong>";
    }
}


if(ifItIsMethod('GET'))
{
    if(isset($_GET['p_count']))
    {
        include 'includes/db.php';
        $post_id = $_GET['p_count'];

        echo countLikes($connection, $post_id, true);
        
        exit;
    }
}

if(ifItIsMethod('POST'))
{
    if(isset($_POST['post_id']))
    {
        $post_id = $_POST['post_id'];

        updateLike($post_id);
        
        exit;
    }
}

function isLoggedIn(){

    if(isset($_SESSION['role'])){

        return true;


    }


   return false;

}

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){

    if(isLoggedIn()){

        redirect($redirectLocation);

    }

}

function escape($string) {

    global $connection;

    return mysqli_real_escape_string($connection, trim($string));


}



function set_message($msg){

    if(!$msg) {

    $_SESSION['message']= $msg;

    } else {

    $msg = "";


        }

}


function display_message() {

    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }


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

users_online();

function confirmQuery($result) {
    
    global $connection;

    if(!$result ) {
          
          die("QUERY FAILED ." . mysqli_error($connection));
   
          
    }
    
    return true;

}



function insert_categories(){
    
    global $connection;

        if(isset($_POST['submit'])){

            $cat_title = $_POST['cat_title'];

        if($cat_title == "" || empty($cat_title)) {
        
             echo "This Field should not be empty";
    
    } else {





    $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?) ");

    mysqli_stmt_bind_param($stmt, 's', $cat_title);

    mysqli_stmt_execute($stmt);


        if(!$stmt) {
        die('QUERY FAILED'. mysqli_error($connection));
        
                  }


        
             }

             
    mysqli_stmt_close($stmt);
   
        
       }

}


function findAllCategories() {
global $connection;

    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection,$query);  

    while($row = mysqli_fetch_assoc($select_categories)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];

    echo "<tr>";
        
    echo "<td>{$cat_id}</td>";
    echo "<td>{$cat_title}</td>";
   echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
   echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
    echo "</tr>";

    }


}


function deleteCategories(){
global $connection;

    if(isset($_GET['delete'])){
    $the_cat_id = $_GET['delete'];
    $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
    $delete_query = mysqli_query($connection,$query);
    header("Location: categories.php");


    }
            


}


function UnApprove() {
    global $connection;
    if(isset($_GET['unapprove'])){
        
        $the_comment_id = $_GET['unapprove'];
        
        $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id ";
        $unapprove_comment_query = mysqli_query($connection, $query);
        header("Location: comments.php");
    
    
    }
}


function is_admin($username) {

    global $connection; 

    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    $row = mysqli_fetch_array($result);


    if($row['user_role'] == 'admin'){

        return true;

    }else {


        return false;
    }

}



function username_exists($username){

    global $connection;

    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0) {

        return true;

    } else {

        return false;

    }





}



function email_exists($email){

    global $connection;


    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0) {

        return true;

    } else {

        return false;

    }



}


function register_user($username, $email, $password, $firstname, $lastname){

    global $connection;

    $username = mysqli_real_escape_string($connection, $username);
    $email    = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);
    $firstname = mysqli_real_escape_string($connection, $firstname);
    $lastname = mysqli_real_escape_string($connection, $lastname);

    $password = password_hash($password, PASSWORD_DEFAULT, array('cost' => 12));
        
        
    $query = "INSERT INTO users (username, user_email, user_password, user_firstname, user_lastname, user_role) ";
    $query .= "VALUES('{$username}', '{$email}', '{$password}', '{$firstname}', '{$lastname}', 'subscriber')";
    $register_user_query = mysqli_query($connection, $query);

    return confirmQuery($register_user_query);

}

 function login_user($username, $password)
 {

     global $connection;

     $username = trim($username);
     $password = trim($password);

     $username = mysqli_real_escape_string($connection, $username);
     $password = mysqli_real_escape_string($connection, $password);


     $query = "SELECT * FROM users WHERE username = '{$username}' ";
     $select_user_query = mysqli_query($connection, $query);
     if (!$select_user_query) {

         die("QUERY FAILED" . mysqli_error($connection));

     }


     while ($row = mysqli_fetch_array($select_user_query)) {

         $db_user_id = $row['user_id'];
         $db_username = $row['username'];
         $db_user_password = $row['user_password'];
         $db_user_firstname = $row['user_firstname'];
         $db_user_lastname = $row['user_lastname'];
         $db_user_role = $row['user_role'];


         if (password_verify($password,$db_user_password)) {

             $_SESSION['user_id'] = $db_user_id;
             $_SESSION['username'] = $db_username;
             $_SESSION['firstname'] = $db_user_firstname;
             $_SESSION['lastname'] = $db_user_lastname;
             $_SESSION['role'] = $db_user_role;



             redirect("/cms/admin");


         } else {


             return false;



         }

     }

     return true;

 }







