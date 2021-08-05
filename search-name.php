<?php 

session_start();
if($_SESSION['email']){

 //$nonav = '';
 include 'init.php';
?>

<div class="container-fluid">
  
    
    <div class="col-lg-9" >
         <div class="panel panel-default" >
            <div class="panel-heading">
                    <p>  الأعضاء </p> 
            </div>
            <div class="panel-body" >
                <?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $phrase = $_POST['phrase'];
                   
    
                    $stmt = $con->prepare("
                    SELECT *  
                    FROM `users` 
                    WHERE (CONVERT(`f_name` USING utf8) LIKE '%$phrase%' 
                    OR CONVERT(`l_name` USING utf8) LIKE '%$phrase%'
                    OR CONVERT(`email` USING utf8) LIKE '%$phrase%'
                    )");
                    $stmt->execute();
                    $infos = $stmt->fetchAll();
    }else{
        header("loaction:index.php");
    }
                ?>
              <div class="row">
                  <?php foreach($infos as $info){ ?>
                  <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                      <img src="themes/img/default-user-image.png" alt="...">
                      <div class="caption">
                        <h5 class="text-center"><strong><?php echo $info['f_name'] . ' ' .  $info['l_name']; ?></strong></h5>
                        <p class="text-center"><span ><?php echo $info['town'] ?></span> | <span ><?php echo $info['age'] ?></span> </p>
                          <p><a href="#" class="btn btn-primary" role="button"><i class="fa fa-user-plus"></i></a> <a href="#" class="btn btn-default" role="button"><i class="fa fa-comments"></i></a></p>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
              </div>
            </div>
         </div>
    </div>
    <div class=" col-xs-12 col-sm-12 col-md-3 col-lg-3" >
        <?php include $tmbl . 'buttons.php'; ?>
    </div>
</div>


<?php
include $tmbl . 'footer.php';
}else{
    header('location:login.php');
}