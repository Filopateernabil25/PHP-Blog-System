<?php
include("./includes/header.php");
include("./includes/navbar.php");
$post_id = $_GET['post_id'];
$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$post_id]);
$post = $stmt->fetch();
?>
<div class="col-8">
    <div class="card p-3">
        <img src="./uploads/<?= $post['image'] ?>" height="300px" alt="">
        <h4><?= $post['title'] ?></h4>
        <p><?= $post['content'] ?></p>
        <a href="index.php" class="btn btn-primary">Back To Home</a>
    </div>
</div>
<div class="col-md-4">
    <div class="card p-3">
        <div class="bg-success card-header text-white text-center">
            <h4>Comments</h4>
        </div>
        <form method="post">
            <div class="mb-3">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="mb-3">
                <label for="comment">Comment</label>
                <textarea class="form-control" name="comment" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Add Comment</button>
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = trim($_POST['name']);
            $comment = trim($_POST['comment']);
            if (!empty($name) && !empty($comment)) {
                $stmt = $pdo->prepare("INSERT INTO comments (name, comments, post_id, status) VALUES (?, ?, ?, 'approved')");
                $stmt->execute([$name, $comment, $post_id]);
                echo '<div class="alert alert-success mt-3">Comment added successfully!</div>';
            } else {
                echo '<div class="alert alert-danger mt-3">Please fill in all fields.</div>';
            }
        }
        ?>
    </div>
</div>
<div class="card mt-3">
    <?php 
    $stmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = ? AND status = 'approved'");
    $stmt->execute([$post_id]);
    $comments = $stmt->fetchAll();
        foreach ($comments as $comment):
    ?>
    <div class="card-body">
        <h5><?=$comment['name']?></h5>
        <p><?=$comment['comments']?></p>
    </div>
    <?php endforeach; ?>
</div>
<?php include("./includes/footer.php") ?>