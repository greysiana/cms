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
                        Welcome to Comments
                        <h2>
                            <small>User by : <?php echo $_SESSION['username'] ?></small>
                        </h2>
                    </h1>


                    <?php
                    // mengisi halaman ketika edit diganti komen maka desain tetap tetapi isi berbeda
                    if (isset($_GET['source'])) {
                        $source = escape($_GET['source']);
                    } else {
                        $source = '';
                    }
                    switch ($source) {
                        case 'add_post';
                            include  "includes/add_post.php";
                            break;

                        case 'edit_post';
                            include "includes/edit_post.php";
                            break;

                        case '200';
                            echo 'NICE 200';
                            break;

                        default:
                            // melakukan pemanggilan terhadap halaman view all comment
                            include "includes/view_all_comments.php";
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