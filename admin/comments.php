<?php
include("./includes/admin_header.php");
include("./includes/admin_navbar.php");
include("./includes/admin_sidebar.php");
?>


<div class="col-md-10">
    <h3> All Comments</h3>
     <table class="table table-dark mt-3">
        <thead>
            <tr>
                <!-- <th>#</th> -->
                <th>id</th>
                <th>Name</th>
                <th>Comment</th>
                <th>View Post</th>
                <th>Un_Approved</th>
                <th>Status</th>
                <th>Approved</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $comments = $pdo->query("SELECT * FROm comments");
            foreach ($comments as $comment):
            ?>
                <tr>
                    <th><?= $comment['id'] ?></th>
                    <th><?= $comment['name'] ?></th>
                    <th><?= $comment['comments'] ?></th>
                    <th>
                        <a href="../postDetails.php?post_id=<?=$comment['post_id']?>" class="btn btn-warning">View Post</a>
                    </th>
                    <th>
                        <a href="comments.php?un_approved=<?=$comment['id']?>" class="btn btn-info">Un Approved</a>
                    </th>
                    <th><?=$comment['status']?></th>
                    <th>
                        <a href="comments.php?approved=<?=$comment['id']?>" class="btn btn-info">Approved</a>
                    </th>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
                <?php 
                if(isset($_GET['un_approved'])){
                    $un_approved_id=$_GET['un_approved'];
                    $stmt=$pdo->prepare("UPDATE comments set status = 'unapproved' where id = ?");
                    $stmt->execute([$un_approved_id]);
                    header("location:comments.php");
                }
                ?>
                <?php 
                if(isset($_GET['approved'])){
                    $approved_id=$_GET['approved'];
                    $stmt=$pdo->prepare("UPDATE comments set status = 'approved' where id = ?");
                    $stmt->execute([$approved_id]);
                    header("location:comments.php");
                }
                ?>
</div>


<?php include("./includes/admin_footer.php") ?>