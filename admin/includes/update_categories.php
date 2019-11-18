<form action="" method="post">
    <div class="form-group">
        <label for="cat-title">Edit Category</label>

        <?php
        // menampilkan data pilihan yang akan diedit pada kolom
        if (isset($_GET['edit'])) {
            $cat_id = escape($_GET['edit']);
            $query = "select * from categories where cat_id = $cat_id";
            $select_categories_id = mysqli_query($connection, $query);

            //pengkondisian ketika data ada
            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                ?>
                <input value="<?php if (isset($cat_title)) {
                                            echo $cat_title;
                                        } ?> " type="text" class="form-control" name="cat_title">
        <?php }
        } ?>

        <?php
        // Memasukan data ketika button update diklik
        if (isset($_POST['update_category'])) {
            $the_cat_title = escape($_POST['cat_title']);

            $stmt = mysqli_prepare($connection, "UPDATE categories set cat_title = ? where cat_id = ? ");
            mysqli_stmt_bind_param($stmt, 'si', $the_cat_title, $cat_id);
            mysqli_execute($stmt);
            // header("Location: categories.php");
            if (!$stmt) {
                die("QUERY FAILED" . mysqli_error($connection));
            }

            mysqli_stmt_close($stmt);
            redirect("categories.php");
        }
        ?>
    </div>

    <!-- pembentukan UI button update kategori -->
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_category" value="Update Category">
    </div>
</form>