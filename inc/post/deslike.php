<?php 
include '../../connect.php';

  $postId = isset($_GET['postId']) && is_numeric($_GET['postId']) ? intval($_GET['postId']) : 0 ;
  $userId = isset($_GET['userId']) && is_numeric($_GET['userId']) ? intval($_GET['userId']) : 0 ; 
  
     $DELETE = $con->prepare("DELETE FROM likes WHERE post = $postId AND user = $userId");
     $DELETE->execute();  
?>
<a href="javascript:void(0)" onclick="insertLike('inc/post/like.php?postId=<?php echo $postId ?>&userId=<?php echo $userId ?>','<?php  echo $postId; ?>')"  class="btn btn-default"> like <i class="far fa-thumbs-up"></i></a>