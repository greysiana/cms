<!-- Membuat tampilan agar tetap sama yang diganti hanya bagian default -->
<?php include "includes/admin_header.php"; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <!-- Membuat bagian atas halaman -->
                    <h1 class="page-header">
                        Welcome to admin
                        <small><?php echo $_SESSION['username'] ?></small>
                    </h1>

                    <?php
                    if (isset($_SESSION['username'])) {
                        $temp_username = escape($_SESSION['username']);

                        $query = "SELECT * FROM users WHERE username = '{$temp_username}' ";
                        $select_user_profile_query = mysqli_query($connection, $query);

                        while ($row = mysqli_fetch_assoc($select_user_profile_query)) {
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
                            $username1 = escape($_POST['username']);
                            $user_email = escape($_POST['user_email']);
                            $user_password = escape($_POST['user_password']);

                            $query_password = "SELECT user_password from users where username = '{$temp_username}'";
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
                            $query .= "username = '{$username1}', ";
                            $query .= "user_email = '{$user_email}', ";
                            $query .= "user_password = '{$user_password}' ";
                            $query .= "where username = '{$username}' ";
                            $edit_user_query = mysqli_query($connection, $query);
                            confirmQuery($edit_user_query);

                            echo " Data Update ";
                            $_SESSION['username'] = $username1;
                        }
                    }
                    ?>


                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <input type="text" value="<?php echo $user_firstname; ?>" class="form-control" name="user_firstname">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Lastname</label>
                            <input type="text" value="<?php echo $user_lastname; ?>" class="form-control" name="user_lastname">
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
                            <input class="btn btn-primary" type="submit" name="edit_user" value="Update Profile">
                        </div>
                    </form>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php"; ?>