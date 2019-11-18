<?php include "includes/admin_header.php"; ?>
<div id="wrapper">
    <!-- Navigation -->
    <?php include "includes/admin_navigation.php"; ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <!-- Membuat bagian atas halaman -->
                    <h1 class="page-header">
                        Welcome to comments
                        <h2>
                            <small>User by : <?php echo $_SESSION['username'] ?></small>
                        </h2>
                    </h1>
                    <?php
                    if (isset($_POST['checkBoxArray'])) {
                        foreach ($_POST['checkBoxArray'] as $commentValueId) {
                            $bulk_options = $_POST['bulk_options'];
                            switch ($bulk_options) {
                                case 'approved':
                                    $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$commentValueId}  ";
                                    $update_to_approved_status = mysqli_query($connection, $query);
                                    confirmQuery($update_to_approved_status);
                                    break;


                                case 'unapproved':
                                    $query = "UPDATE comments SET comment_status = '{$bulk_options}' WHERE comment_id = {$commentValueId}  ";
                                    $update_to_unapproved_status = mysqli_query($connection, $query);
                                    confirmQuery($update_to_unapproved_status);
                                    break;



                                case 'delete':
                                    $query = "DELETE FROM comments WHERE comment_id = {$commentValueId}  ";
                                    $update_to_delete = mysqli_query($connection, $query);
                                    confirmQuery($update_to_delete);
                                    break;
                            }
                        }
                    }
                    ?>

                        <form action="" method="post">
                            <div id="bulkOptionsContainer" class="col-xs-4">
                                <select class="form-control" name="bulk_options" id="">
                                    <option value="">Select Options</option>
                                    <option value="approved">Approve</option>
                                    <option value="unapproved">Unapprove</option>
                                    <option value="delete">Delete</option>
                                </select>
                            </div>

                            <!-- Membuat tabel pada halaman comments -->
                            <table class="table table-bordered table-hover">

                                <div class="col-xs-4">
                                    <input type="submit" name="submit" class="btn btn-success" value="Apply">
                                </div>

                                <thead>
                                    <tr>
                                        <th><input id="selectAllBoxes" type="checkbox"></th>
                                        <th>Id</th>
                                        <th>Author</th>
                                        <th>Comment</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>In Response to</th>
                                        <th>Date</th>
                                        <th>Approve</th>
                                        <th>Unapprove</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>

                                <!-- Cara manual memasukan data pada tabel -->

                                <body>

                                    <?php
                                    // untuk mengambil semua data yang melakukan komen
                                    $query = "select * from comments where comment_post_id = " . mysqli_real_escape_string($connection, $_GET['id']) . " ";
                                    $select_comments = mysqli_query($connection, $query);

                                    // Memunculkan semua data post yang ada pada tabel
                                    while ($row = mysqli_fetch_assoc($select_comments)) {
                                        $comment_id = $row['comment_id'];
                                        $comment_post_id = $row['comment_post_id'];
                                        $comment_author = $row['comment_author'];
                                        $comment_content = $row['comment_content'];
                                        $comment_email = $row['comment_email'];
                                        $comment_status = $row['comment_status'];
                                        $comment_date = $row['comment_date'];
                                        echo "<tr>";
                                        ?>

                                        <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $comment_id; ?>'></td>

                                    <?php
                                        echo "<td>$comment_id</td>";
                                        echo "<td>$comment_author</td>";
                                        echo "<td>$comment_content</td>";
                                        echo "<td>$comment_email</td>";
                                        echo "<td>$comment_status</td>";
                                        // untuk mengambil judul post yang dikomentari
                                        $query = " SELECT * from posts where post_id = $comment_post_id ";
                                        $select_post_id_query = mysqli_query($connection, $query);

                                        while ($row = mysqli_fetch_assoc($select_post_id_query)) {
                                            $post_id = $row['post_id'];
                                            $post_title = $row['post_title'];
                                            // mengambil folder dari post disini mundur 2 folder dan untuk masuk ke link post
                                            //     echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                                            echo "<td><a href='post/$post_id'>$post_title</a></td>";
                                        }
                                        // }
                                        echo "<td>$comment_date</td>";
                                        // cara untuk menambahkan link edit, hapus, approve dan unapprove yang berupa link 
                                        echo "<td><a href='post_comments.php?approved=$comment_id&id=" . $_GET['id'] . "''>Approve</a></td>";
                                        echo "<td><a href='post_comments.php?unapproved=$comment_id&id=" . $_GET['id'] . "''>Unapprove</a></td>";
                                        //memanggil halaman komen
                                        echo "<td><a href='post_comments.php?delete=$comment_id&id=" . $_GET['id'] . "'>Delete</a></td>";
                                        echo "<tr>";
                                    }
                                    ?>

                                </body>
                            </table>
                        </form>

                        <?php
                        // approve merupakan data comment_id yang di buat pada approve untuk memasukkan ke proses 
                        if (isset($_GET['approved'])) {
                            $the_comment_id = escape($_GET['approved']);
                            $query = " UPDATE comments SET comment_status = 'approved' where comment_id = $the_comment_id ";
                            $approve_comment_query = mysqli_query($connection, $query);
                            header("Location: post_comments.php?id=" . $_GET[id] . " ");
                        }

                        if (isset($_GET['unapproved'])) {
                            $the_comment_id = escape($_GET['unapproved']);
                            $query = " UPDATE comments SET comment_status = 'unapproved' where comment_id = $the_comment_id ";
                            $unapprove_comment_query = mysqli_query($connection, $query);
                            header("Location: post_comments.php?id=" . $_GET[id] . " ");
                        }

                        //  Untuk menghapus data berdasarkan id yang dibuat dengan penampungan delete
                        if (isset($_GET['delete'])) {
                            $the_comment_id = escape($_GET['delete']);
                            $query = " delete from comments where comment_id = {$the_comment_id} ";
                            $delete_query = mysqli_query($connection, $query);
                            header("Location: post_comments.php?id=" . $_GET[id] . " ");
                        }


                        ?>

                </div>
            </div>
        </div>
    </div>

    <?php include "includes/admin_footer.php" ?>