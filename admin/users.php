<!-- Membuat tampilan agar tetap sama yang diganti hanya bagian default -->
<?php include "includes/admin_header.php"; ?>

<?php
if (!is_admin($_SESSION['username'])) {
    header("Location: /cms");
}
?>

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
                        Welcome to Users
                        <h2>
                            <small>User by : <?php echo $_SESSION['username'] ?></small>
                        </h2>
                    </h1>

                    <?php
                    // mengisi halaman ketika edit diganti komen maka desain tetap tetapi isi berbeda
                    if (isset($_GET['source'])) {
                        $source = $_GET['source'];
                    } else {
                        $source = '';
                    }
                    switch ($source) {
                            // mrmanggil halaman user.php
                        case 'add_user';
                            include  "includes/add_user.php";
                            break;

                        case 'edit_user';
                            include "includes/edit_user.php";
                            break;

                        case '200';
                            echo 'NICE 200';
                            break;

                        default:
                            // melakukan pemanggilan terhadap halaman view all comment
                            include "includes/view_all_users.php";
                            break;
                    }

                    ?>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php" ?>