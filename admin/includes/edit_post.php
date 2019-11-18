<?php
// untuk mendapatkan id yang akan diedit
if (isset($_GET['p_id'])) {
    $the_post_id = escape($_GET['p_id']);
}

$query = "select * from posts where post_id = $the_post_id ";
$select_posts_by_id = mysqli_query($connection, $query);

// Memunculkan semua data post yang ada pada tabel
while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
    $post_id = $row['post_id'];
    $post_user = $row['post_user'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_content = $row['post_content'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
}

//untuk memasukan data perubahan ke dalam database
if (isset($_POST['update_post'])) {

    $post_user = escape($_POST['post_user']);
    $post_title = escape($_POST['post_title']);
    $post_category_id = escape($_POST['post_category']);
    $post_status = escape($_POST['post_status']);
    $post_image = escape($_FILES['image']['name']);
    $post_image_temp = escape($_FILES['image']['tmp_name']);
    $post_content = escape($_POST['post_content']);
    $post_tags = escape($_POST['post_tags']);

    move_uploaded_file($post_image_temp, "../images/$post_image");

    // kondisi apabila gambar tidak ingin diupdate 
    if (empty($post_image)) {
        $query = "select * from posts where post_id = $the_post_id ";
        $select_image = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_array($select_image)) {
            $post_image = $row['post_image'];
        }
    }

    // $post_title = mysqli_real_escape_string($connection, $post_title);
    // query untuk melakukan update posts
    $query = "update posts set ";
    $query .= "post_title = '{$post_title}', ";
    $query .= "post_category_id = '{$post_category_id}', ";
    $query .= "post_date = now(), ";
    $query .= "post_user = '{$post_user}', ";
    $query .= "post_status = '{$post_status}', ";
    $query .= "post_tags = '{$post_tags}', ";
    $query .= "post_content = '{$post_content}', ";
    $query .= "post_image = '{$post_image}' ";
    $query .= "where post_id = {$the_post_id} ";

    $update_post = mysqli_query($connection, $query);
    confirmQuery($update_post);

    // Membuat link untuk menampilkan langsung data yang diedit berdasarkan id
    echo "<p class='bg-success'>Post Update. <a href='post/{$the_post_id}'> View Post </a>or<a href= 'posts.php' > Edit More Posts </a></p>";
}

// untuk menampilkan data yang dipilih untuk diwdit
?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Tite</label>
        <!-- htmlspecialchars(stripslashes digunakan agar data yang menggunakan tanda seru tanya, dll akan terbaca normal tanpa slash -->
        <input value="<?php echo htmlspecialchars(stripslashes($post_title)); ?>" type="text" class="form-control" name="post_title">
    </div>

    <div class="form-group">
        <label for="categories">Categories</label>
        <select name="post_category" id="post_category">
            <?php
            //   mengambil semua kategori pada file
            $query = "select * from categories";
            $select_categories = mysqli_query($connection, $query);
            //   confirmQuery($select_categories);
            //pengkondisian ketika data ada
            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                // Menampilkan awal select dengan data kategori yang telah terpilih
                if ($cat_id == $post_category_id) {
                    echo "<option selected value='$cat_id'>{$cat_title}</option>";
                } else {
                    //membuat pilihan kategori menggunakan opsi
                    echo "<option value='$cat_id'>{$cat_title}</option>";
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="users">Users</label>
        <select name="post_user" id="">
            <?php "<option value='{$post_user}'>{$post_user}</option>"; ?>
            <?php
            $users_query = "SELECT * from users ";
            $select_users = mysqli_query($connection, $users_query);
            confirmQuery($select_users);
            while ($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row['user_id'];
                $username = $row['username'];
                echo "<option value='{$username}'>{$username}</option>";
            }
            ?>
        </select>
    </div>

    <!-- Cara untuk membuat opsi -->
    <div class="form-group">
        <label for="poststatus">Post Status : </label>
        <select name="post_status" id="">
            <option value='<?php echo $post_status ?>'><?php echo $post_status ?></option>
            <?php
            if ($post_status == 'published') {
                echo " <option value='draft'>draft</option> ";
            } else {
                echo " <option value='published'>published</option> ";
            }
            ?>
        </select>
    </div>

    <!-- cara untuk mengambil gambar dari database -->
    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image; ?>" alt="">
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input value="<?php echo htmlspecialchars(stripslashes($post_tags)); ?>" type="text" class="form-control" name="post_tags">
    </div>

    <!-- untuk memanggil data yang menggunakan textarea -->
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea type="text" class="form-control" name="post_content" id="body" cols="30" rows="10">
            <!-- Untuk menghilangkan slash bisa menggunakan str_replace atau yang dibawahnya -->
            <?php echo str_replace('\r\n', '</br>', $post_content); ?>
            <!-- <?php // echo htmlspecialchars(stripslashes($post_content));
                    ?> -->
        </textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
    </div>
</form>