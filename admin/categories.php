<?php
include("./includes/admin_header.php");
include("./includes/admin_navbar.php");
include("./includes/admin_sidebar.php");
?>


<div class="col-md-10">
    <h3> All Categories</h3>
    <div class="row">
        <div class="col-md-6">
            <div class="card p-3">
                <div class="card-header text-center text-white bg-primary">
                    <h3>Add New Category</h3>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label for="description">description</label>
                            <input type="text" class="form-control" name="description">
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="btn_add" class="btn btn-primary w-100">Add New Category</button>
                        </div>
                    </form>
                    <?php
                    if (isset($_POST['btn_add'])) {
                        $name = $_POST['name'];
                        $description = $_POST['description'];
                        // echo $description;
                        $stmt = $pdo->prepare("INSERT INTO categories (name,description) values (?,?)");
                        $stmt->execute([$name, $description]);
                        header("location:categories.php");
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php if (isset($_GET['edit_id'])):
            $edit_id = $_GET['edit_id'];
            $stmt = $pdo->prepare("SELECT * FROM categories where id = ?");
            $stmt->execute([$edit_id]);
            $category = $stmt->fetch(); //Get Single Row
        ?>
            <div class="col-md-6">
                <div class="card p-3">
                    <div class="card-header text-center text-white bg-warning">
                        <h3>Update Category</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" value="<?= $category['name'] ?>" class="form-control" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="description">description</label>
                                <input type="text" value="<?= $category['Description'] ?>" class="form-control" name="description">
                            </div>
                            <div class="mb-3">
                                <button name="btn_edit" type="submit" class="btn btn-warning w-100">Add New Category</button>
                            </div>
                        </form>
                        <?php
                        if (isset($_POST['btn_edit'])) {

                            $name = $_POST['name'];
                            $description = $_POST['description'];
                            $stmt = $pdo->prepare("UPDATE categories set name = ? , description = ? where id = ?");
                            $stmt->execute([$name, $description, $edit_id]);
                            // header("location:categories.php");

                        } ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <table class="table table-dark mt-3">
        <thead>
            <tr>
                <th>id</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($_GET['delete_id'])):
                $delete_id = $_GET['delete_id'];
                // Optional: Confirm delete (add a form or JS prompt here for safety)
                $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
                $stmt->execute([$delete_id]);
                header("Location: categories.php");
                exit; // Prevent further execution
            endif; ?>

            <?php
            $categories = $pdo->query("SELECT * FROM categories");
            foreach ($categories as $category):
            ?>
                <tr>
                    <th><?= $category['id'] ?></th>
                    <th><?= $category['name'] ?></th>
                    <th><?= $category['Description'] ?></th>
                    <th>
                        <a href="categories.php?edit_id=<?= $category['id'] ?>" class="btn btn-warning">Edit</a>
                        <a href="categories.php?delete_id=<?= $category['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure Delete Category?')">Delete</a>
                    </th>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include("./includes/admin_footer.php") ?>