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

?>