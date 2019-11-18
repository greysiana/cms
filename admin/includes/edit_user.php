<?php

if (isset($_GET['edit_user'])) {
    $the_user_id = escape($_GET['edit_user']);

    $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
    $select_users_query = mysqli_query($connection, $query);

    // Memunculkan semua data post yang ada pada tabel
    while ($row = mysqli_fetch_assoc($select_users_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
    }
    ?>


<?php
    if (isset($_POST['edit_user'])) {

        $user_firstname = escape($_POST['user_firstname']);
        $user_lastname = escape($_POST['user_lastname']);
        $user_role = escape($_POST['user_role']);
        $username = escape($_POST['username']);
        $user_email = escape($_POST['user_email']);
        $user_password = ($_POST['user_password']);

        $query_password = "SELECT user_password from users where user_id = $the_user_id";
        $get_user_query = mysqli_query($connection, $query_password);
        confirmQuery($get_user_query);

        $row = mysqli_fetch_array($get_user_query);
        $db_user_password = $row['user_password'];

        // Membuat apabila password diedit akan tetap kena crypt baik untuk tampilan maupun ke dalam database

        if (!empty($user_password)) {
            if ($db_user_password != $user_password) {
                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
                $user_password = $hashed_password;
            }
        } else {
            $db = $db_user_password;
            $hashed_password = password_hash($db, PASSWORD_BCRYPT, array('cost' => 12));
            $user_password = $db_user_password;
        }

        $query = "UPDATE users set ";
        $query .= "user_firstname= '{$user_firstname}', ";
        $query .= "user_lastname = '{$user_lastname}', ";
        $query .= "user_role = '{$user_role}', ";
        $query .= "username = '{$username}', ";
        $query .= "user_email = '{$user_email}', ";
        $query .= "user_password = '{$user_password}' ";
        $query .= "where user_id = {$the_user_id} ";

        $edit_user_query = mysqli_query($connection, $query);
        confirmQuery($edit_user_query);
        echo "User Updated  " . "<a href='users.php'>View Users</a>";
        $_SESSION['username'] = $username;
    }
}
// else {
//     header("Location: index.php");
// }
?>

<!-- Membuat form untuk memasukan data users -->
<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" value="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname">
    </div>

    <!-- Membuat button down untuk menampilkan pilihan role -->
    <div class="form-group">
        <label for="userrole">User Role </label>
        <select name="user_role" id="">
            <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
            <?php
            // untuk membuat pilihan selain  yang sudah dipilih
            if ($user_role == 'admin') {
                echo "<option value='subscriber'>subscriber</option>";
            } else {
                echo "<option value='admin'>admin</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" value="<?php echo $username; ?>" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" value="<?php echo $user_email; ?>" class="form-control" name="user_email">
    </div>

    <div class="form-group">
        <label for="user_password">Password</label>
        <!-- <input autocomplete="off" type="password" class="form-control" name="user_password"> -->
        <input type="password" class="form-control" name="user_password">
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="edit_user" value="Edit User">
    </div>
</form>