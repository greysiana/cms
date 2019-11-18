<?php
if (isset($_POST['create_user'])) {

    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $user_role = escape($_POST['user_role']);
    $username = escape($_POST['username']);
    $user_email = escape($_POST['user_email']);
    $user_password = escape($_POST['user_password']);

    // Melakukan secret password
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "insert into users(user_firstname, user_lastname, user_role, username, user_email, user_password)";
    $query .= " values ( '{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$user_password}')";
    $create_user_query = mysqli_query($connection, $query);
    confirmQuery($create_user_query);

    // Membuat link untuk melihat user tambahan langsung
    echo " User Created: " . " " . "<a href ='users.php'>View Users</a> ";
}
?>


<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">
    </div>

    <div class="form-group">
        <label for="userrole">User Role : </label>
        <!-- Membuat button down untuk menampilkan pilihan role -->
        <select name="user_role" id="">
            <option value="select_options">Select Options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>

        </select>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
    </div>
</form>