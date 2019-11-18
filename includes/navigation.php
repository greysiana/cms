<?php session_start(); ?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- memanggil halaman index.php -->
            <a class="navbar-brand" href="/cms">CMS Front</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->

        <!-- membuat navigasi diatas halaman dengan langsung mengambil data dari kategori -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <?php
                $query = "select * from categories";
                $select_all_categories_query = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                    $cat_title =  $row['cat_title'];
                    $cat_id = $row['cat_id'];

                    // Mengaktifkaan navigasi category
                    $category_class = '';
                    $registration_class = '';
                    $contact_class = '';
                    $admin_class = '';

                    // Pemanggilan halaman
                    $pageName = basename($_SERVER['PHP_SELF']);
                    $registration = "/cms/registration";
                    $contact = "/cms/contact";
                    $admin = "/cms";

                    // Apabila ada maka bentuk akan kotak dan tulisan terang
                    if (isset($_GET['category']) && $_GET['category'] == $cat_id) {
                        $category_class = 'active';
                    } elseif ($pageName == $registration) {
                        $registration_class = "active";
                    } elseif ($pageName == $contact) {
                        $contact_class = "active";
                    } elseif ($pageName == $admin) {
                        $admin_class = "active";
                    }
                    echo "<li class='$category_class'><a href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                }
                ?>

                <!-- Melakukan ke halaman admin dengan mengklik kata Admin -->
                <li class='<?php echo $admin_class; ?>'>
                    <a href="/cms/admin">Admin</a>
                </li>
                <li class='<?php echo $registration_class; ?>'>
                    <a href="/cms/registration">Registration</a>
                </li>
                <li class='<?php echo $contact_class; ?>'>
                    <a href="/cms/contact">Contact</a>
                </li>
                <!-- Untuk memunculkan link edit post setebelah admin setelah login -->

                <?php
                if (isset($_SESSION['user_role'])) {
                    if (isset($_GET['p_id'])) {
                        $the_post_id = $_GET['p_id'];
                        echo "<li><a href='/cms/admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
                    }
                }
                ?>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>