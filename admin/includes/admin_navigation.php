<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/cms">CMS Admin</a>
    </div>

    <!-- Top Menu Items -->
    <!-- membuat pemanggilan halaman index menggunakan HOME SITE -->
    <ul class="nav navbar-right top-nav">

        <!-- Menampilkan banyak pengguna yang online -->
        <li><a href="">Users Online : <span class="usersonline"></span> </a></li>

        <li><a href="/cms">HOME SITE</a></li>

        <!-- mwmbuat untuk user profil logout dan profile -->
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                <!-- Untuk menampilkan nama yang login -->
                <?php
                if (isset($_SESSION['username'])) {
                    echo $_SESSION['username'];
                }
                ?>
                <b class="caret"></b></a>

            <!-- membuat menu-menu dalam profil user -->
            <ul class="dropdown-menu">
                <li>
                    <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>

                <li class="divider"></li>
                <li>
                    <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>

        </li>
    </ul>

    <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    <!-- membuat navigasi sebelah kiri halaman -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <!-- Membuka halaman index menggunakan kata Dasbord -->
            <li>
                <a href="/cms"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>

            <!-- Membuka post dengan menggunakan klik akan keluar menu-menu -->
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts_dropdown"><i class="fa fa-fw fa-arrows-v"></i> Posts <i class="fa fa-fw fa-caret-down"></i></a>
                <!-- Membuat menu-menu pada post -->
                <ul id="posts_dropdown" class="collapse">
                    <li>
                        <a href="./posts.php">View All Posts</a>
                    </li>
                    <li>
                        <a href="posts.php?source=add_post">Add Posts</a>
                    </li>
                </ul>
            </li>

            <!-- Membuat navigasi Categories -->
            <li>
                <a href="./categories.php"><i class="fa fa-fw fa-wrench"></i> Categories</a>
            </li>

            <!-- Membuat navigasi komen -->
            <li class="">
                <a href="./comments.php"><i class="fa fa-fw fa-file"></i> Comments </a>
            </li>

            <!-- Membuat navigasi untuk masuk ke halaman pengelolaan user -->
            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i></a>
                <ul id="demo" class="collapse">
                    <li>
                        <a href="users.php">View All Users</a>
                    </li>
                    <li>
                        <a href="users.php?source=add_user">Add User</a>
                    </li>
                </ul>
            </li>

            <!-- Membuat navigasi untuk ke halaman profile -->
            <li>
                <a href="profile.php"><i class="fa fa-fw fa-dashboard"></i> Profile </a>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>