<div class="col-md-8">
    <?php 
    $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC LIMIT 1");
    $post = $stmt->fetch();
    if ($post):
    ?>
     <div class="card mb-3">
         <img class="card-img-top" src="./uploads/<?= $post['image'] ?>" height="400" alt="Title" />
         <div class="card-body">
             <h4 class="card-title"><?= $post['title'] ?></h4>
             <p class="card-text"><?= $post['content'] ?></p>
             <a href="postDetails.php?post_id=<?= $post['id'] ?>" class="btn btn-primary w-100">More Details</a>
         </div>
     </div>
    <?php else: ?>
     <div class="alert alert-warning" role="alert">
        No latest post available.
     </div>
    <?php endif; ?>
     
     <div class="row">
         <?php
         $posts = $pdo->query("SELECT * FROM posts");
         if ($posts->rowCount() > 0):
            foreach ($posts as $post):
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
         <?php else: ?>
             <div class="alert alert-info" role="alert">
                 No posts available.
             </div>
         <?php endif; ?>
     </div>
 </div>