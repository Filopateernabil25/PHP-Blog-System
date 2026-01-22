<?php
include("./includes/admin_header.php");
include("./includes/admin_navbar.php");
include("./includes/admin_sidebar.php");

if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$edit_id]);
    $post = $stmt->fetch();

    if ($post) {
        // Fetch category name
        $category_name = 'N/A';
        if (!empty($post['category_id'])) {
            $stmt_cat = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
            $stmt_cat->execute([$post['category_id']]);
            $category = $stmt_cat->fetch();
            if ($category) {
                $category_name = $category['name'];
            }
        }
    } else {
        echo "Post not found.";
        exit;
    }
} else {
    echo "No edit ID provided.";
    exit;
}
?>

<div class="col-md-10">
    <div class="card p-3">
        <div class="card-header text-center text-white bg-primary">
            <h3>Update Category</h3>
        </div>
        <div class="card-body">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title">title</label>
                    <input type="text" value="<?=$post['title']?>" class="form-control" name="title">
                </div>
                <div class="mb-3">
                    <label for="content">content</label>
                    <textarea type="text" value="<?= $category['description'] ?>" class="form-control" name="content"></textarea>
                </div>
                <div class="mb-3">
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="">Status</label>
                    <select name="status" id="" class="form-select">
                        <option <?= $post['status']=='draft'? 'selected':''?> value="draft">Draft</option>
                        <option <?= $post['status']=='published'? 'selected':''?> value="published">publish</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Category_id</label>
                    <select name="category_id" id="" class="form-select">
                        <?php
                        $categories = $pdo->query("SELECT * FROm categories");
                        foreach ($categories as $category):
                        ?>
                            <option <?php if($category['id']==$post['Category_id']){echo "selected";}?> value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <button name="btn_edit" type="submit" class="btn btn-primary w-100">Add New Post</button>
                </div>
            </form>
            <?php
            if (isset($_POST['btn_edit'])) {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $image = $_FILES['image']['name'];
                $status = $_POST['status'];
                $category_id = $_POST['category_id'];
                // echo $image;
                if ($image) {
                    if($post['image'] && file_exists("../uploads/".$post['image'])){
                        unlink("../uploads/".$post['image']);//Remove Image
                    }
                    $targetFile = "../uploads/" . basename($image);
                    move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
                }else{
                    $image=$post['image'];
                    
                }
                $stmt = $pdo->prepare("UPDATE `posts` SET `title`=?,`content`=?,`image`=?,`status`=?,`category_id`=? WHERE id= ?");
                $stmt->execute([$title, $content, $image, $status, $category_id,$edit_id]);
                header("location:posts.php");
            } ?>
        </div>
    </div>
</div>
<?php include("./includes/admin_footer.php") ?>