<?php 
    session_start();
    include '../../connect.php';

    $action = isset($_GET['action']) && is_numeric($_GET['action']) ? intval($_GET['action']) : 0;
    $user   = isset($_GET['user']) && is_numeric($_GET['user']) ? intval($_GET['user']) : 0;
    
    if($action == 1){
        /* 
        ========================================== 
        استعلام تعديل حالة الطلب الى 1
        ========================================== 
        */
        
        $stmt = $con->prepare("UPDATE friend_request SET status = 1 WHERE first_user = $user AND second_user = ".$_SESSION['uid']. " " );
        $stmt->execute();
        
        if($stmt){
            //ادخال العضو فى جدول الأصدقاء
            $stmt = $con->prepare("INSERT INTO `friends` (`user`, `friend`) VALUES (?,?)");
            $stmt->execute([$_SESSION['uid'],$user]);
            
            //الدخول فى جدول اصدقاء العضو
            $stmt = $con->prepare("INSERT INTO `friends` (`user`, `friend`) VALUES (?,?)");
            $stmt->execute([$user,$_SESSION['uid']]);
        }
        
    }elseif($action == 2){
       /* 
        ========================================== 
        استعلام تعديل حالة الطلب الى 2
        ========================================== 
        */ 
        $stmt = $con->prepare("UPDATE friend_request SET status = 2 WHERE first_user = $user AND second_user = ".$_SESSION['uid']. " " );
        $stmt->execute();
    }
?>