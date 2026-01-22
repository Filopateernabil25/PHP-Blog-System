<?php
include("./includes/admin_header.php");
include("./includes/admin_navbar.php");
include("./includes/admin_sidebar.php");
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
                    <input type="text" class="form-control" name="title">
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
                        <option value="draft">Draft</option>
                        <option value="published">publish</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Category_id</label>
                    <select name="category_id" id="" class="form-select">
                        <?php
                        $categories = $pdo->query("SELECT * FROm categories");
                        foreach ($categories as $category):
                        ?>
                            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <button name="btn_add" type="submit" class="btn btn-primary w-100">Add New Post</button>
                </div>
            </form>
            <?php
            if (isset($_POST['btn_add'])) {

                $title = $_POST['title'];
                $content = $_POST['content'];
                $image = $_FILES['image']['name'];
                $status = $_POST['status'];
                $category_id = $_POST['category_id'];
                // echo $image;
                if($image){
                    $targetFile="../uploads/".basename($image);
                    move_uploaded_file($_FILES['image']['tmp_name'],$targetFile);
                    $stmt=$pdo->prepare("INSERT INTO posts (title,content,image,status,category_id) values (?,?,?,?,?)");
                    $stmt->execute([$title,$content,$image,$status,$category_id]);
                    header("location:posts.php");
                }
            } ?>
        </div>
    </div>
</div>
<?php include("./includes/admin_footer.php") ?>