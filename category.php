<!-- Melakukan pemanggilan halaman dimana datanya akan digunakan -->
<?php include "includes/db.php"; ?>
<?php include "includes/header.php" ?>
<?php include "./admin/functions.php"; ?>
<!-- Navigation -->
<?php include "includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php

            if (isset($_GET['category'])) {
                $post_category_id = $_GET['category'];

                if (is_admin($_SESSION['username'])) {
                    $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content from posts where post_category_id = ? ");
                } else {
                    // $query = "Select * from posts where post_category_id = $post_category_id AND post_status= 'published' ";
                    $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_author, post_date, post_image, post_content from posts where post_category_id = ? and post_status = ? ");
                    $published = 'published';
                }

                // $select_all_posts_query = mysqli_query($connection, $query);

                if (isset($stmt1)) {
                    mysqli_stmt_bind_param($stmt1, "i", $post_category_id);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    mysqli_stmt_store_result($stmt1);
                    $stmt = $stmt1;
                } else {
                    mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_author, $post_date, $post_image, $post_content);
                    mysqli_stmt_store_result($stmt2);
                    $stmt = $stmt2;
                }

                if (mysqli_stmt_num_rows($stmt) === 0) {
                    echo "<h1 class='text-center'>NO POST AVAILABLE</h1>";
                }

                // while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                while (mysqli_stmt_fetch($stmt)) :
                    // $post_id = $row['post_id'];
                    // $post_title = $row['post_title'];
                    // $post_author = $row['post_author'];
                    // $post_date = $row['post_date'];
                    // $post_image = $row['post_image'];
                    // $post_content = substr($row['post_content'], 0, 100);
                    // $post_content = $row['post_content'];
                    //  echo "<li><a href='#'>{$post_title}</a></li>";
                    ?>
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <!-- Unruk mendapatkan judul dengan titlr post yang diambil dari id -->
                        <a href="/cms/post/<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="/cms"><?php echo $post_author ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date; ?> </p>
                    <hr>
                    <img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="">
                    <hr>
                    <p><?php echo $post_content ?> </p>
                    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
            <?php
                endwhile;
                mysqli_stmt_close($stmt);
            } else {
                header("Location: /cms");
            }
            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <!-- Memanggil halaman sidebar -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php"; ?>