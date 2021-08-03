 <?php 
  session_start();
  include '../../connect.php';
  $postId = isset($_GET['postId']) && is_numeric($_GET['postId']) ? intval($_GET['postId']) : 0 ;
  $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0 ;
     
     $insertLike = $con->prepare("insert into likes (`post`,`user`) VALUES (:post , :user)");
     $insertLike->execute(array(
      'post'  => $postId,
      'user'  => $userId
     ));  
 
     $stmt = $con->prepare("SELECT * FROM posts WHERE post_id = $postId ");
     $stmt->execute();
     $post = $stmt->fetch();
    
     $stmt = $con->prepare("SELECT * FROM users  WHERE user_id = ".$_SESSION['uid']." ");
     $stmt->execute();
     $user = $stmt->fetch();

     $postuser = $post['user_id'];
     $url      = 'post.php?id'. $postId;
     $content  = $user['f_name'].' Has liked your post';
    
     $stmt = $con->prepare("INSERT INTO `notification` 
        (`user`, `url`, `content`)    
     VALUES 
        (?,?,?)");
    $stmt->execute([$postuser,$url,$content]);
    ?>
<a href="javascript:void(0)" onclick="insertLike('inc/post/deslike.php?postId=<?php echo $postId ?>&userId=<?php echo $userId ?>','<?php  echo $postId; ?>')"  class="btn btn-default"> deslike <i class="fas fa-thumbs-up"></i></a>