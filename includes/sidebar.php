<div class="col-md-4">

    <!-- Blog Search Well -->
    <!-- Membuat pencarian pada bar sebelah kanan -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method="post">
            <div class="input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>

    <!-- membuat form login -->
    <div class="well">
        <!-- Apabila sudah login -->
        <?php if (isset($_SESSION['user_role'])) : ?>
            <h4>Logged in as <?php echo $_SESSION['username'] ?></h4>
            <a href="/cms/includes/logout.php" class="btn btn-primary">Logout</a>

        <?php else : ?>
            <h4>Login</h4>
            <form action="/cms/includes/login.php" method="post">
                <div class="form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                <div class="input-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                    <!-- Membuat tombol submit di sebelah form password -->
                    <span class="input-group-btn">
                        <button class="btn btn-primary" name="login" type="submit">Submit</button>
                    </span>
                </div>
            </form>
            <!-- /.input-group -->
        <?php endif; ?>

    </div>




    <!-- Blog Categories Well -->
    <div class="well">
        <!-- pemanggilan data pada tabel kategori -->
        <?php
        $query = "select * from categories";
        $select_categories_sidebar = mysqli_query($connection, $query);
        ?>

        <!-- Membuat tampilan kategori dengan bentuk ke bawah -->
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php
                    while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        // memgambil data category title melalui id post
                        echo "<li><a href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                    }
                    ?>
                </ul>
            </div>

        </div>
        <!-- /.row -->
    </div>

    <!-- Side Widget Well -->
    <?php include "includes/widget.php"; ?>

</div>