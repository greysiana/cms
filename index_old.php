<!-- Melakukan pemanggilan halaman dimana datanya akan digunakan -->
<?php include "includes/db.php"; ?>
<?php include "includes/header.php" ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <?php
            // Menampilkan data yang ada pada post
            $query = "Select * from posts ";
            $select_all_posts_query = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_id = $row['post_id'];
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = substr($row['post_content'], 0, 100);  // memnuat jumlah karakter content
                $post_status = $row['post_status'];

                // Menampilkan data post yang hanya berstatus published

                if ($post_status == 'published') {
                    ?>
                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <!-- Unruk mendapatkan judul dengan titlr post yang diambil dari id -->
                        <a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title; ?></a>
                    </h2>
                    <p class="lead">
                        <!-- Untuk menampilkan halaman author posy dan membuat url menampilkan username yang login dan id data -->
                        by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id; ?>"><?php echo $post_author ?></a>

                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?> </p>
                    <hr>
                    <!-- Untuk membuat respon yaitu memunculkan kolom komen ketika gambar di klik gunaka <a> href -->
                    <a href="post.php?p_id=<?php echo $post_id ?>">
                        <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                    </a>
                    <hr>
                    <p><?php echo $post_content ?> </p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                    <hr>
            <?php }
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