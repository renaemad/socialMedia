<?php 
    session_start();
    include '../../connect.php';
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){  
        $filter =  array('mohammed','ahmed','mahmoud');
        
        $msg =  str_replace($filter,'****',$_POST['msg']);
        $friend = $_POST['friend'];
        $myId   = $_SESSION['uid'];
        
        //$chatId = $friend.$myId;
        
        if($friend > $myId){
            $chatId = $friend.$myId;
        }elseif($myId > $friend){
            $chatId = $myId.$friend;
        }
        
        $formError = array();
        
        if(mb_strlen($msg,'UTF-8') < 1){
            $formError[]    = 'لايمكن ارسال رساله فارغه';
        }
        
        if(empty($formError)){ 
        
        $stmt = $con->prepare("INSERT INTO `chat` 
            (`chat_id`, `sender`, `other`, `msg`, `time`, `date`) 
        VALUES 
            (:chatId, :sender, :other, :msg, now(),now())");
        $stmt->execute(array(
            'chatId'    => $chatId,
            'sender'    => $myId,
            'other'     => $friend,
            'msg'       => $msg
        ));
            
        }
        
        $stmt = $con->prepare("
        SELECT chat.* , users.* FROM chat 
        INNER JOIN users ON chat.sender = users.user_id 
        WHERE chat.chat_id = $chatId order by chat.time ");
        $stmt->execute();
        $rows = $stmt->fetchAll();  
        
        foreach($rows as $row){ 
                    if($row['sender'] == $_SESSION['uid']){
                        
                        $stmt = $con->prepare("SELECT * FROM users WHERE user_id = ".$row['sender']." ");
                        $stmt->execute();
                        $userInfo = $stmt->fetch();
                 ?> 
                 <!-- start  by me -->  
                   <li class="by-me margin-bottom-10" >
                      <div class="avatar pull-left" > 
                        <img height="50px" width="50px" src="upload/avatar/default-user-image.png"   >
                      </div>
                      <div class="content" >
                         <div class="chat-meta" > <?php echo $userInfo['f_name'] ?> <span class="pull-right"> <?php echo $row['time'] ?> </span></div>
                         <div class="clearfix" ><?php echo $row['msg'] ?></div>
                      </div> 
                   </li>
                 <!-- end by me -->
                    <?php }elseif($row['other'] == $_SESSION['uid']){ 
                        $stmt = $con->prepare("SELECT * FROM users WHERE user_id = ".$row['sender']." ");
                        $stmt->execute();
                        $userInfo = $stmt->fetch();
                    ?>
                 <!-- start  by other -->
                   <li class="by-other margin-bottom-10" >
                     <div class="avatar pull-right" > 
                        <img height="50px" width="50px" src="upload/avatar/default-user-image.png" >
                      </div>
                      <div class="content" >
                         <div class="chat-meta" > <?php echo $row['time'] ?> <span class="pull-right"><?php echo $userInfo['f_name'] ?> </span></div>
                         <div class="clearfix" ><?php echo $row['msg'] ?></div>
                      </div> 
                   </li>
                 <!-- end  by other -->
                 <?php } }  
    }
?>