<?php
include("./includes/admin_header.php");
include("./includes/admin_navbar.php");
include("./includes/admin_sidebar.php");
?>

<div class="col-md-10">
    <h3 class="mb-3"> All Posts</h3>
    <a href="addPost.php" class="btn btn-primary mb-3">Add New Post</a>
    <table class="table table-dark mt-3">
        <thead>
            <tr>
                <!-- <th>#</th> -->
                <th>id</th>
                <th>Title</th>
                <th>Content</th>
                <th>image</th>
                <th>Category Name</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Use JOIN to fetch category name directly
            $posts = $pdo->query("SELECT posts.*, categories.name AS category_name FROM posts LEFT JOIN categories ON posts.category_id = categories.id");
            foreach ($posts as $post):
                $category_name = $post['category_name'] ?? 'N/A'; // Use 'N/A' if no category
            ?>
                <tr>
                    <th><?= $post['id'] ?></th>
                    <th><?= $post['title'] ?></th>
                    <th><?= $post['content'] ?></th>
                    <th>
                        <img src="../uploads/<?= $post['image'] ?>" width="100" alt="">
                    </th>
                    <th><?= $category_name ?></th>
                    <th><?= $post['status'] ?></th>
                    <th>
                        <a href="updatePost.php?edit_id=<?= $post['id'] ?>" class="btn btn-warning">Edit</a>
                        <a href="posts.php?delete_id=<?= $post['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure delete this post?')">Delete</a>
                    </th>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isset($_GET['delete_id'])):
        $delete_id = $_GET['delete_id'];
        $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$delete_id]);
        header("Location: posts.php");
        exit; // Prevent further execution
    endif; ?>

</div>

<?php include("./includes/admin_footer.php") ?>