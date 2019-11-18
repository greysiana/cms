<?php include "includes/admin_header.php"; ?>

<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <!-- Untuk membuat isi dibawah welcome admin -->
                    <div class="col-xs-6">

                        <!-- pemanggilan fungsi insert untuk memasukan data -->
                        <?php insert_categories(); ?>

                        <!-- form untuk melakukan fungsi insert data -->
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="cat-title">Add Category</label>
                                <input type="text" class="form-control" name="cat_title">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                            </div>
                        </form>

                        <!-- memanggil halaman update_categories.php ketika "edit" di klik -->
                        <?php
                        if (isset($_GET['edit'])) {
                            $cat_id = escape($_GET['edit']);
                            include "includes/update_categories.php";
                        }
                        ?>

                    </div>
                    <!-- menggunakan sebagian halaman dari ukuran 12 -->
                    <div class="col-xs-6">

                        <!-- Membuat tabel yang berkotak -->
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title </th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>

                            <!-- Memangil Fungsi findAllCategories dan delete yang membentuk tabel -->
                            <tbody>
                                <?php findAllCategories(); ?>
                                <?php deleteCategories(); ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->
    <?php include "includes/admin_footer.php" ?>