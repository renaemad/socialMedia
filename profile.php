<?php 
    session_start();

    include 'init.php';

    $id = isset($_GET['uid']) && is_numeric($_GET['uid']) ? intval($_GET['uid']) : 0;

?>

<div class="continer-fluid">
    <div class="col-xs-12  posts col-sm-12 col-md-9 col-lg-9" >
         <div class="panel panel-default" >
            <div class="panel-heading" >
                <p>  المنشورات </p>
            </div>
            <div class="panel-body">
                
            </div>
        </div>
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <p>  المنشورات </p>
            </div>
            <div class="panel-body">
                
            </div>
        </div>
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <p>  المنشورات </p>
            </div>
            <div class="panel-body">
                
            </div>
        </div>
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <p>  المنشورات </p>
            </div>
            <div class="panel-body">
                
            </div>
        </div>
    </div> 
    <div class="col-xs-12  col-sm-12 col-md-3 col-lg-3" >
        <div class="panel panel-default" >
            <div class="panel-heading" >
                <p>  الصورة الشخصية </p>
            </div>
            <div class="panel-body">
                <img class="img-responsive img-thumbnail" src="themes/img/default-user-image.png" >
           
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default"><i class="fa fa-user-plus"></i></button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default"><i class="fa fa-comments"></i></button>
                  </div>
                  <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default"><i class="fa fa-heart"></i></button>
                  </div>
                </div>
            </div>
        </div>
    </div> 
    <div class="col-xs-12  col-sm-12 col-md-3 col-lg-3" >
         <div class="panel panel-default" >
            <div class="panel-heading" >
                <p> معرض الصور </p>
            </div>
            <div class="panel-body">
                
            </div>
        </div>
    </div> 
    <div class="col-xs-12  col-sm-12 col-md-3 col-lg-3" >
        <div class="panel panel-default info" >
            <div class="panel-heading" >
                <p>  المعلموات الشخصية </p>
            </div>
            <div class="panel-body">
                <h4 ><stron><?php echo ucfirst($info['f_name']) .' '. ucfirst($info['l_name']) ?></stron></h4>
                <ul class="list-unstyled" >
                    <li ><span >  السن </span> | <?php echo getinfo('*','users','user_id',$id,'age'); ?></li>
                    <li ><span >  المدينة </span> | <?php echo getinfo('*','users','user_id',$id,'town'); ?></li>
                    <li ><span >  الحالة الإجتماعية </span> | <?php echo getinfo('*','users','user_id',$id,'rel_status');   ?></li>
                </ul>
            </div>
        </div>   
    </div> 

</div>

<?php include $tmbl . 'footer.php' ?>