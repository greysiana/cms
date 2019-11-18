<?php
if (isset($_POST['create_post'])) {
    $post_title = escape($_POST['title']);
    $post_user = escape($_POST['post_user']);
    $post_category_id = escape($_POST['post_category']);
    $post_status = escape($_POST['post_status']);
    $post_image = escape($_FILES['image']['name']);
    $post_image_temp = escape($_FILES['image']['tmp_name']);
    $post_tags = escape($_POST['post_tags']);
    $post_content = escape($_POST['post_content']);
    $post_date = escape(date('d-m-y'));

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "insert into posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status)";
    $query .= " values ('{$post_category_id}', '{$post_title}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
    $create_post_query = mysqli_query($connection, $query);
    confirmQuery($create_post_query);

    // Mengambil id dari data yang baru dibuat
    $the_post_id = mysqli_insert_id($connection);

    // Link untk menampilkan langsung data yang ditmabahkan
    echo "<p class='bg-success'>Post Created. <a href='post/{$the_post_id}'> View Post </a>or<a href= 'posts.php' > View More Posts </a></p>";
}
?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="categories">Categories : </label>
        <select name="post_category" id="post_category">
            <?php
            //   mengambil semua kategori pada file
            $query = "select * from categories";
            $select_categories = mysqli_query($connection, $query);
            //pengkondisian ketika data ada
            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                //membuat pilihan kategori menggunakan opsi
                echo "<option value='$cat_id'>{$cat_title}</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="users">Users : </label>
        <select name="post_user" id="">
            <?php
            $users_query = "Select * from users ";
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

    <div class="form-group">
        <label for="poststatus">Post Status : </label>
        <select name="post_status" id="">
            <option value=''>Select Options</option>
            <option value='published'>Publish</option>
            <option value='draft'>Draft</option>
            <?php
            if (post_status == 'published') {
                $post_status = "published";
            } else {
                $post_status = "draft";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" class="form-control" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>

    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea type="text" class="form-control" name="post_content" id="body" cols="30" rows="10"></textarea>
    </div>

    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
    </div>
</form>