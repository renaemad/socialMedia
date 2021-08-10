<div class="panel panel-default" >
    <div class="panel-heading">
    
            <p>  الأعضاء </p> 
           
    </div>
    <div class="panel-body" > 
        <?php 
            
        
            if(isset($_GET['page'])){
                $page = $_GET['page'];
            }else{
                $page = 1;
            }
        
            $num_ber_page = 2;
            $from = ($page-1)*$num_ber_page;
         
            $stmt = $con->prepare("SELECT * FROM users LIMIT $from,$num_ber_page");
            $stmt->execute();
            $infos = $stmt->fetchAll();
        ?>
      <div class="row"> 
          <?php foreach($infos as $info){ ?>
          <div class="col-sm-8 col-md-4">
          <div class="thumbnail">
                            <?php
                  $id = $info['user_id'];
                  $stmt1 = $con->prepare("SELECT * FROM avatars WHERE user_id = $id");
                  $stmt1->execute();
                  $avatars = $stmt1->fetch();
                  ?>

                            <?php if (!empty($avatars['avatar'])) {
                  ?>
                            <img src="upload/avatar/<?php echo $avatars['avatar'] ?>" style="height: 300px;" alt="...">
                            <?php  } else { ?>
                            <img src="themes/img/default-user-image.png" alt="...">
                            <?php } ?>
                <div class="caption" >
                <h5 class="text-center"><strong><?php echo $info['f_name'] . ' ' .  $info['l_name']; ?></strong></h5>
                <p class="text-center"><span ><?php echo $info['user_id'] ?></span> | <span ><?php echo $info['age'] ?></span> </p>
                   <div id="<?php echo $info['user_id']; ?>" >
                     <a href="javascript:void(0)" onclick="getinfo('inc/friend/request.php?id=<?php echo $info['user_id']; ?>','<?php echo $info['user_id']; ?>')" class="btn btn-primary" role="button"><i class="fa fa-user-plus"></i></a> 
                     <a href="chat.php?frind=<?php echo $info['user_id']; ?>" class="btn btn-default" role="button"><i class="fa fa-comments"></i></a>
                   </div>
              </div>
            </div>
          </div>
          <?php } ?>
          <nav aria-label="Page navigation example">
          <ul class="pagination">
            <li class="page-item"><a class="page-link" href="index.php?page=<?php if(($page - 1) > 0 ){ echo $page - 1; }else{ echo '1'; } ?>">Previous</a></li>
              <?php
                $query = $con->prepare("SELECT user_id FROM users ");
                $query->execute();
                $TotalUsers = $query->rowCount();
              
                $totalPage = ceil($TotalUsers/$num_ber_page);
               
                for($i=1;$i<=$totalPage;$i++){ 
              ?>
              
            <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $i ?>"><?php echo $i ?></a></li> 
              <?php } ?>
            <li class="page-item"><a class="page-link" href="index.php?page=<?php if(($page + 1) < $totalPage){ echo $page + 1; }elseif(($page + 1) >= $totalPage){ echo $totalPage; }  ?>">Next</a></li>
          </ul>
        </nav>
      </div>
    </div>
 </div>
