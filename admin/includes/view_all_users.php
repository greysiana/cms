<?php
include("delete_modal.php");


if (isset($_POST['checkBoxArray'])) {
    foreach ($_POST['checkBoxArray'] as $commentValueId) {
        $bulk_options = $_POST['bulk_options'];
        switch ($bulk_options) {
            case 'subscriber':
                // $query = " UPDATE users SET user_role = '{$bulk_options}' where user_id = $commentValueId ";
                // $change_to_sub_query = mysqli_query($connection, $query);
                // confirmQuery($change_to_sub_query);
                break;

            case 'admin':
                // $query = " UPDATE users SET user_role = '{$bulk_options}' where user_id = $commentValueId ";
                // $change_to_admin_query = mysqli_query($connection, $query);
                // confirmQuery($change_to_admin_query);
                break;

            case 'delete':


                // $query = "DELETE FROM users WHERE user_id = {$commentValueId}  ";
                // $update_to_delete = mysqli_query($connection, $query);
                // confirmQuery($update_to_delete);
                break;
        }
    }
}
?>

    <form action="" method="post">
        <div id="bulkOptionsContainer" class="col-xs-4">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <option value="admin">Admin</option>
                <option value="subscriber">Subscriber</option>
                <option value="delete">Delete</option>
            </select>
        </div>

        <!-- Membuat tabel pada halaman comments -->
        <table class="table table-bordered table-hover">
            <div class="col-xs-4">
                <input type="submit" name="submit" class="btn btn-success" value="Apply">
            </div>

            <thead>
                <tr>
                    <th><input id="selectAllBoxes" type="checkbox"></th>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Admin</th>
                    <th>Subscriber</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>

            <!-- Cara manual memasukan data pada tabel -->

            <body>

                <?php
                // untuk mengambil semua data
                $query = "select * from users";
                $select_users = mysqli_query($connection, $query);

                // Memunculkan semua data post yang ada pada tabel
                while ($row = mysqli_fetch_assoc($select_users)) {
                    $user_id = $row['user_id'];
                    $username = $row['username'];
                    $user_password = $row['user_password'];
                    $user_firstname = $row['user_firstname'];
                    $user_lastname = $row['user_lastname'];
                    $user_email = $row['user_email'];
                    $user_image = $row['user_image'];
                    $user_role = $row['user_role'];
                    echo "<tr>";
                    ?>
                    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $user_id; ?>'></td>
                <?php
                    echo "<td>$user_id</td>";
                    echo "<td>$username</td>";
                    echo "<td>$$user_password</td>";
                    echo "<td>$user_firstname</td>";
                    echo "<td>$user_lastname</td>";
                    echo "<td>$user_email</td>";
                    echo "<td>$user_role</td>";

                    // cara untuk menambahkan link edit, hapus, approve dan unapprove yang berupa link 
                    echo "<td><a href='users.php?change_to_admin={$user_id}'>Admin</a></td>";
                    echo "<td><a href='users.php?change_to_sub={$user_id}'>Subscriber</a></td>";

                    //memanggil halaman komen
                    echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>";
                    echo "<td><a rel='$user_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";
                    // echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";
                    echo "<tr>";
                }
                ?>

            </body>
        </table>
    </form>

    <?php
    // approve merupakan data comment_id yang di buat pada approve untuk memasukkan ke proses 
    if (isset($_GET['change_to_admin'])) {
        $the_user_id = escape($_GET['change_to_admin']);
        $query = " UPDATE users SET user_role = 'admin' where user_id = $the_user_id ";
        $_SESSION['user_role'] = 'admin';
        $change_to_admin_query = mysqli_query($connection, $query);
        header("Location: users.php ");
    }

    if (isset($_GET['change_to_sub'])) {
        $the_user_id = escape($_GET['change_to_sub']);
        $query = " UPDATE users SET user_role = 'subscriber' where user_id = $the_user_id ";
        $_SESSION['user_role'] = 'subscriber';
        $change_to_sub_query = mysqli_query($connection, $query);
        header("Location: users.php ");
    }

    //  Untuk menghapus data berdasarkan id yang dibuat dengan penampungan delete
    if (isset($_GET['delete'])) {
        // session digunakan agar tidak bisa menghapus data sebelum login
        if (isset($_SESSION['user_role'])) {
            if ($_SESSION['user_role'] == 'admin') {
                $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);
                $query = " delete from users where user_id = {$the_user_id} ";
                $delete_user_query = mysqli_query($connection, $query);
                header("Location: users.php ");
            }
        }
    }

    ?>


    <script>
        $(document).ready(function() {
            $(".delete_link").on('click', function() {
                var id = $(this).attr("rel");
                var delete_url = "users.php?delete=" + id + " ";
                $(".modal_delete_link").attr("href", delete_url);
                $("#myModal").modal('show');
            });
        });
    </script>