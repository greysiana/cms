<!-- Melakukan pemanggilan halaman dimana datanya akan digunakan -->
<?php include "includes/db.php"; ?>
<?php include "includes/header.php" ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<?php ob_start(); ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            // Untuk membuat perhitungan per halaman
            $per_page = 2;
            if (isset($_GET['page'])) {
                $page = $_GET['page'];
            } else {
                $page = "";
            }

            if ($page == "" || $page == 1) {
                $page_1 = 0;
            } else {
                $page_1 = ($page * $per_page) - $per_page;
            }

            // untuk mengecek apakah data ada atau tidak
            $post_query_count = " SELECT * from posts";
            $find_count = mysqli_query($connection, $post_query_count);
            $jumlah = mysqli_num_rows($find_count);

            if ($jumlah < 1) {
                echo "<h1 class='text-center'>NO POSTS AVAILABLE</h1>";
            } else {

                if (isset($_SESSION['user_role']) == 'admin') {
                    $query = " SELECT * from posts limit $page_1, $per_page";
                    $data_post = "SELECT * from posts ";
                    $find_count = mysqli_query($connection, $data_post);
                    $count = mysqli_num_rows($find_count);
                } else {
                    $query = " SELECT * from posts where post_status = 'published' limit $page_1, $per_page ";
                    $data_post = "SELECT * from posts where post_status = 'published' ";
                    $find_count = mysqli_query($connection, $data_post);
                    $count = mysqli_num_rows($find_count);
                }

                // Digunakan untuk menentukan banyak halaman dari jumlah data yang ada
                $count = ceil($count / $per_page);

                $select_all_posts_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_author = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    $post_content = substr($row['post_content'], 0, 100);  // memnuat jumlah karakter content
                    $post_status = $row['post_status'];
                    ?>

                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>


                    <!-- First Blog Post -->
                    <h1><?php echo $count; ?></h1>
                    <h2>
                        <!-- Unruk mendapatkan judul dengan titlr post yang diambil dari id -->
                        <a href="post/<?php echo $post_id ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        <!-- Untuk menampilkan halaman author posy dan membuat url menampilkan username yang login dan id data -->
                        by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>

                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?> </p>
                    <hr>
                    <!-- Untuk membuat respon yaitu memunculkan kolom komen ketika gambar di klik gunaka <a> href -->
                    <a href="post/<?php echo $post_id ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo $post_content ?> </p>
                    <a class="btn btn-primary" href="post/<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
            <?php
                }
            }

            ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <!-- Memanggil halaman sidebar -->
        <?php include "includes/sidebar.php" ?>

    </div>
    <!-- /.row -->

    <hr>

    <ul class="pager">
        <?php
        for ($i = 1; $i <= $count; $i++) {
            // Membuat url dengan menunjukan halaman dan menghitamkan button angka halaman dengan menggunakan active_link dari styles.css
            if ($i == $page) {
                echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
            } else {
                echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
            }
        }
        ?>
    </ul>

    <?php include "includes/footer.php"; ?>