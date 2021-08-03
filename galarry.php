<?php 
    session_start();

    include 'init.php';

    $id = isset($_GET['uid']) && is_numeric($_GET['uid']) ? intval($_GET['uid']) : 0;

    $stmt =  $con->prepare("SELECT * FROM users WHERE user_id = $id");
    $stmt->execute();
    $info = $stmt->fetch();
?>

<div class="continer-fluid">
    <div class="col-xs-12 col-md-offset-1 col-sm-12 col-md-10 col-lg-10" >
         <div class="panel  panel-default" >
            <div class="panel-heading" >
                <p> الصور الشخصية </p>
            </div>
            <div class="panel-body">
             <?php 
                    $id = isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) : 0;
                    
                    $stmt = $con->prepare("SELECT * FROM avatars WHERE user_id = $id order by avatar_id desc ");
                    $stmt->execute();
                    $avatars = $stmt->fetchAll();
                    
                    foreach($avatars as $avatar){
             
             ?>
                <div class="col-sm-3"  >  
                     <a href="galarry.php?userID=' . $myId . '" >    
                        <?php echo '<img  style="height:210px;width:100%;margin-bottom:10px;" src="upload/avatar//' . $avatar['avatar'] . '" >'; ?> 
                     </a>
                </div>
              <?php } ?>
            </div>
        </div>
         
    </div> 

</div>

<?php include $tmbl . 'footer.php' ?>