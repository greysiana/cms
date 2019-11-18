<?php
function redirect($location)
{
    return header("Location:" . $location);
}

// Membuat warning sebelum going online
function escape($string)
{
    global $connection;
    return mysqli_real_escape_string($connection, trim(($string)));
}

// Fungsi untuk mengetahui jumlah user online
function users_online()
{
    // Mengambil dari javascript
    if (isset($_GET['onlineusers'])) {
        global $connection;

        if (!$connection) {
            session_start();
            include("../includes/db.php");
        }
        $session = session_id();
        $time  = time();
        $time_out_in_seconds = 02;
        $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * from users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);

        if ($count == NULL) {
            mysqli_query($connection, "INSERT into users_online(session,time) values('$session','$time')");
        } else {
            mysqli_query($connection, "UPDATE users_online set time = '$time' where session = '$session'");
        }

        $users_online_query = mysqli_query($connection, "SELECT * from users_online where time > '$time_out'");
        echo $count_user = mysqli_num_rows($users_online_query);
    } //get request isset
}

users_online();

//untuk melakukan konfirmasi apakah terkoneksi ke database atauh gak
function confirmQuery($result)
{
    global $connection;
    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}


// ********************************************** CODE ************************************************* CODE **********************************************

function insert_categories()
{
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = escape($_POST['cat_title']);
        if ($cat_title == "" || empty($cat_title)) {
            echo "This field should not empty";
        } else {



            $stmt = mysqli_prepare($connection, "insert into categories(cat_title) values(?)");
            mysqli_stmt_bind_param($stmt, 's', $cat_title);
            mysqli_stmt_execute($stmt);
            // $query .= "value ('{$cat_title}')";
            // $create_category_query = mysqli_query($connection, $query);
            if (!$stmt) {
                die('QUERY FAILED' . mysqli_error($connection));
            }
        }

        mysqli_stmt_close($stmt);
    }
}

function findAllCategories()
{
    global $connection;
    $query = "select * from categories";
    $select_categories = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td> ";
        echo "<td> <a href='categories.php?delete={$cat_id}'>DELETE</a></td>";
        echo "<td> <a href='categories.php?edit={$cat_id}'>EDIT</a></td>";

        echo "</tr>";
    }
}

function deleteCategories()
{
    global $connection;
    if (isset($_GET['delete'])) {
        $the_cat_id = escape($_GET['delete']);
        $query = "delete from categories where cat_id = {$the_cat_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}

// <!-- Menghitung jumlah data yang ada pada post -->
function recordCount($table)
{
    global $connection;
    $query = "SELECT * from " . $table;
    $select_all_post = mysqli_query($connection, $query);
    $result =  mysqli_num_rows($select_all_post);
    confirmQuery($result);
    return $result;
}


function checkStatus($table, $column, $status)
{
    global $connection;
    $query = "SELECT * FROM $table WHERE $column = '$status' ";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return mysqli_num_rows($result);
}

// Pengecekan yang login apakah admin atau tidak
function is_admin($username)
{
    global $connection;
    $query = "SELECT user_role from users where username = '$username' ";
    $result = mysqli_query($connection, $query);
    confirmQuery('$result');

    $row = mysqli_fetch_array($result);

    if ($row['user_role'] == 'admin') {
        return true;
    } else {
        return false;
    }
}

// Untuk melakukan pengecekan saat register apakah username sudah ada atau belum
function username_exists($username)
{
    global $connection;

    $query = "SELECT username from users where username = '$username' ";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}


function email_exists($email)
{
    global $connection;

    $query = "SELECT user_email from users where user_email = '$email' ";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}


function register_user($username, $email, $password)
{
    global $connection;


    // Mengambil data dari database
    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    // Digunakan untuk merahasiakan password
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

    // Membuat tulisan password menjadi kata lain yang nantinya akan otomatis dimasukan ke kolom randSalt
    // $query = " SELECT randSalt from users ";
    // $select_randsalt_query = mysqli_query($connection, $query);
    // if (!$select_randsalt_query) {
    //     die("QUERY FAILED" . mysqli_error($connection));
    // }
    // $row = mysqli_fetch_array($select_randsalt_query);
    // $salt = $row['randSalt'];
    // $password = crypt($password, $salt);


    $query = "INSERT into users (username, user_email, user_password, user_role) ";
    $query .= " VALUES ('{$username}','{$email}','{$password}','subscriber') ";
    $register_user_query = mysqli_query($connection, $query);

    confirmQuery($register_user_query);

    // $message = "Your registration submitted";

}

function login_user($username, $password)
{
    global $connection;

    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * from users where username = '{$username}' ";
    $select_users_query = mysqli_query($connection, $query);
    if (!$select_users_query) {
        die("QUERY FAILED " . mysqli_error($connection));
    }

    while ($row = mysqli_fetch_array($select_users_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
    }

    //Membuat agar tetap bisa login dengan pass karena adanya cryp password
    //$password = crypt($password, $db_user_password); 

    // Menggunakan password_verify untuk login
    if (password_verify($password, $db_user_password)) {
        $_SESSION['username'] = $db_username;
        $_SESSION['user_firstname'] = $db_user_firstname;
        $_SESSION['user_lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;
        // header("Location: ../admin");
        redirect("/cms/admin");
    } else {
        redirect("/cms");
        // header("Location: ../index.php");
    }
}
