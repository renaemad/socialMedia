<?php
    session_start();
    include '../../connect.php';
        
        $other = isset($_GET['frind']) && is_numeric($_GET['frind']) ? intval($_GET['frind']) : 0;
        $sender = $_SESSION['uid'];

        if($sender > $other ){
          $chatId = $sender.$other;
         }else{
          $chatId = $other.$sender;
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
                         <div class="clearfix" ><?php echo nl2br($row['msg']); ?></div>
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
                         <div class="clearfix" ><?php echo nl2br($row['msg']) ?></div>
                      </div> 
                   </li>
                 <!-- end  by other -->
                 <?php } }
     
?>