<?php 
    session_start();
    include '../../connect.php';
    $friendId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

    $stmt = $con->prepare("INSERT INTO `friend_request` 
        (`first_user`, `second_user`) 
    VALUES 
        (?,?)");
    $stmt->execute([$_SESSION['uid'],$friendId]);
?>
<a href="javascript:void(0)" class="btn btn-primary" role="button"><i class="fa fa-check"></i></a> 
<a href="chat.php?frind=<?php echo $info['user_id']; ?>" class="btn btn-default" role="button"><i class="fa fa-comments"></i></a>