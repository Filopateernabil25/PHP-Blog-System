<div class="col-md-4 ">
    <div class="links d-flex flex-column">
        <?php
        $categories = $pdo->query("SELECT * FROM categories");
        foreach ($categories as $category): ?>
            <a href="categories.php?cat_id=<?= $category['id'] ?>" class="btn btn-outline-primary mb-2 w-100"><?= $category['name'] ?></a>
        <?php endforeach; ?>
    </div>
</div>