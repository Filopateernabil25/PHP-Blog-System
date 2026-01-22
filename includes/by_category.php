<div class="col-md-8">
    <?php
    $cat_id = isset($_GET['cat_id']) ? (int)$_GET['cat_id'] : null;
    if (!$cat_id) {
        echo '<div class="alert alert-warning">No category selected.</div>';
        return;
    }

    // Fetch posts by category
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE category_id = ? ORDER BY created_at DESC");
    $stmt->execute([$cat_id]);
    $posts = $stmt;

    if ($posts->rowCount() > 0):
        // Display the first (latest) post prominently
        $post = $posts->fetch();
    ?>
    <div class="card">
        <img class="card-img-top" src="./uploads/<?= $post['image'] ?>" height="200" alt="Title" />
        <div class="card-body">
            <h4 class="card-title"><?= $post['title'] ?></h4>
            <p class="card-text"><?= $post['content'] ?></p>
            <a href="postDetails.php?post_id=<?= $post['id'] ?>" class="btn btn-primary w-100">More Details</a>
        </div>
    </div>

    <div class="row">
        <?php
        // Loop through remaining posts (skip the first one if already displayed)
        $posts->execute([$cat_id]); // Re-execute to reset
        $first = true;
        foreach ($posts as $post):
            if ($first) { $first = false; continue; } // Skip the first post
        ?>
        <div class="col-md-6 mb-3">
            <div class="card">
                <img class="card-img-top" src="./uploads/<?= $post['image'] ?>" height="200" alt="Title" />
                <div class="card-body">
                    <h4 class="card-title"><?= $post['title'] ?></h4>
                    <p class="card-text"><?= $post['content'] ?></p>
                    <a href="postDetails.php?post_id=<?= $post['id'] ?>" class="btn btn-primary w-100">More Details</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="alert alert-info" role="alert">
        No posts available in this category.
    </div>
    <?php endif; ?>
</div>