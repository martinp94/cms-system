<table class="table table-hover table-bordered">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
            <th class="text-center">Options</th>
            
        </tr>
    </thead>

    <tbody>
    
    <?php

        if(isset($_GET['update_role']) && isset($_GET['role']))
        {

            if(!isset($_SESSION['role']))
                return false;

            if($_SESSION['role'] != 'admin')
                return false;
            
            $user_id = $_GET['update_role'];
            $role = $_GET['role'];

            $query = "UPDATE users SET user_role = '{$role}' WHERE user_id = {$user_id}";
            mysqli_query($connection, $query) or die(mysqli_error($connection));
            header("Location: users.php");
        }

        if(isset($_GET['delete']) && isset($_GET['p_id']))
        {

            if(!isset($_SESSION['role']))
                return false;

            if($_SESSION['role'] != 'admin')
                return false;

            $user_id = $_GET['p_id'];
            $query = "DELETE FROM users WHERE user_id = {$user_id}";
            mysqli_query($connection, $query) or die(mysqli_error($connection));
            header("Location: users.php");
        }

        $query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $query);

        while($row = mysqli_fetch_assoc($select_users))
        {

            $user_id = $row['user_id'];
            $user_username = $row['username'];
            $user_password = $row['user_password'];
            $user_firstname = $row['user_firstname'];
            $user_lastname = $row['user_lastname'];
            $user_email = $row['user_email'];
            $user_image = $row['user_image'];
            $user_role = $row['user_role'];
            $user_randSalt = $row['randSalt'];
    ?>

    <tr>
        <td><?php echo $user_id; ?></td>
        <td><?php echo $user_username; ?></td>
        <td><?php echo $user_firstname; ?></td>
        <td><?php echo $user_lastname; ?></td>
        <td><?php echo $user_email; ?></td>
        <td><?php echo $user_role; ?></td>
        <td class="text-center">
        	<a href="?source=edit&u_id=<?php echo $row['user_id']; ?>">Edit</a> |
            <a href="?delete&p_id=<?php echo $row['user_id']; ?>">Delete</a> |
            <a href="?update_role=<?php echo $row['user_id']; ?>&role=subscriber">Change to Subscriber</a> |
            <a href="?update_role=<?php echo $row['user_id']; ?>&role=admin">Change to Admin</a>
        </td>
        
       
    </tr>

    <?php } ?>

    </tbody>

</table>