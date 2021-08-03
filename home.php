<?php session_start();

include 'init.php';
$myId    = $_SESSION['uid'];

$page = isset($_GET['page']) ? $_GET['page'] : 'post';


if ($page == 'post') {
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $myId    = $_SESSION['uid'];
    $content =  $_POST['content'];
    if (!empty($_FILES['avatar']['tmp_name'])) {
      $name =  $_FILES['avatar']['name'];
      $type =  $_FILES['avatar']['type'];
      $tmp  =  $_FILES['avatar']['tmp_name'];
      $size =  $_FILES['avatar']['size'];

      $allowed = array("jpg", "jpeg", "png", "gif");

      $explode  = explode('.', $name);
      $filetype = strtolower(end($explode));

      if (!in_array($filetype, $allowed)) {
        $error = "هذا الملف غير مدعوم";
      } else {
        $neName  = rand(0, 1000) . '_' . $name;
        move_uploaded_file($tmp, 'upload/avatar//' . $neName);
      }
      $date = date("y M,d");
      $time = date("H:i");
      $dayOfYear = date("ymd");
      $stmt = $con->prepare("
       INSERT INTO posts (user_id, img_id,content, date, time,day ) 
       VALUES ( :userId ,:imgId ,:content,:date,:time ,:day)");
      $stmt->execute(array(
        'userId'   => $myId,
        'imgId'    => $neName,
        'content'  => $content,
        'date'     => $date,
        'time'     => $time,
        'day'      => $dayOfYear,
      ));
    } else {
      $date = date("y M,d");
      $time = date("H:i");
      $dayOfYear = date("ymd");
      $stmt = $con->prepare("
       INSERT INTO posts (user_id,content, date, time,day ) 
       VALUES ( :userId  ,:content,:date,:time ,:day)");
      $stmt->execute(array(
        'userId'   => $myId,
        'content'  => $content,
        'date'     => $date,
        'time'     => $time,
        'day'      => $dayOfYear,
      ));
    }
  }
} elseif ($page = 'comment') {
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $content = $_POST['comment'];
    $userId  = $_POST['userId'];
    $postId  = $_POST['postId'];
    $date  = date("d/M,Y");
    $time  = date("h:i");

    $stmt = $con->prepare("
        INSERT INTO 
            comments 
        (user, post, content, date, time) 
            VALUES 
        ( :user , :post , :content , :date , :time ) ");
    $stmt->execute(array(
      'user'  => $userId,
      'post'  => $postId,
      'content' => $content,
      'date'  => $date,
      'time'  => $time
    ));
  }
}




$query = $con->prepare("SELECT * FROM posts order by time DESC");
$query->execute();
$postInfo = $query->fetchAll();


?>


<div class="container-fluid">
    <div class="row">
        <div class=" hidden-sm col-md-5 col-lg-4 col-xl-4">
            <?php include $tmbl . 'ads.php'; ?>
        </div>

        <div class="col-sm-12 col-md-7 col-lg-8 col-xl-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p> اضافة منشور </p>
                </div>
                <div class="panel-body">
                    <form action="?page=post" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <textarea name="content" cols="30" rows="10" placeholder="اكتب هنا ..."></textarea>
                        </div>
                        <div class="form-group">
                            <input class="form-control-file" name="avatar" type="file">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-edit"></i> اضافة منشور
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <?php foreach ($postInfo as $info) {
    $userId = $info['user_id'];
    $stmt = $con->prepare("SELECT * FROM users WHERE user_id = $userId");
    $stmt->execute();

    $userName = $stmt->fetch();


    $stmt1 = $con->prepare("SELECT * FROM avatars WHERE user_id = $userId");
    $stmt1->execute();
    $avatars = $stmt1->fetch();


    $Pdate = $info['day'];
    $today = date('ymd');
    $dayAgo = $today - $Pdate;
if ($dayAgo  == 0) {
      $postDate = 'اليوم';
    } elseif ($dayAgo == 1) {
      $postDate = 'أمس';
    } elseif ($dayAgo == 2) {
      $postDate = 'منذ يومين';
    } elseif ($dayAgo > 2) {
      if ($dayAgo == 7) {
        $postDate = 'منذ اسبوع';
      } elseif ($dayAgo > 7) {
        $postDate = $Pdate;
      } else {
        $postDate = 'منذ ' . $dayAgo . ' ايام';
      }
    }
  ?>
    <div class="full-post col-md-offset-5  col-lg-offset-4 col-xl-offset-4 col-sm-12 col-md-7 col-lg-8 col-xl-8">
        <!-- Post Header -->
        <?php
      if (!empty($info['img_id'])) {
      ?>
        <div class="media">
        <div class="media-left">
                <?php
            if (!empty($avatars['avatar'])) { ?>

                <a href="#">
                    <img style="height:50px;width:50px" class="media-object"
                        src="upload/avatar/<?php echo $avatars['avatar'] ?>" alt="...">
                </a>
                <?php } else {
            ?><a href="#">
                    <img style="height:50px;width:50px" class="media-object" src="upload/avatar/default-user-image.png"
                        alt="...">
                </a><?php
                }
                  ?>
            </div>
            <div class="media-body">
                <h4 class="media-heading ">
                    <?php echo ucfirst($userName['f_name']) . ' ' . ucfirst($userName['l_name']); ?><span><?php echo  $postDate . ' ' . $info['time']; ?></span>
                </h4>
                <div class="caption mt-5">
                    <p><?php echo $info['content']; ?></p>
                </div>
                <?php
            echo ' <img class="img-responsive img-thumbnail" style="height:350px;width:850px"  src="upload/avatar//' . $info['img_id'] . ' " >' ?>
            </div>
        </div>
        <?php } else { ?>
        <div class="media">
        <div class="media-left">
                <?php
            if (!empty($avatars['avatar'])) { ?>

                <a href="#">
                    <img style="height:50px;width:50px" class="media-object"
                        src="upload/avatar/<?php echo $avatars['avatar'] ?>" alt="...">
                </a>
                <?php } else {
            ?><a href="#">
                    <img style="height:50px;width:50px" class="media-object" src="upload/avatar/default-user-image.png"
                        alt="...">
                </a><?php
                }
                  ?>
            </div>
            <div class="media-body">
                <h4 class="media-heading ">
                    <?php echo ucfirst($userName['f_name']) . ' ' . ucfirst($userName['l_name']); ?><span><?php echo  $postDate . ' ' . $info['time']; ?></span>
                </h4>
                <div class="caption mt-5">
                    <p><?php echo $info['content']; ?></p>
                </div>

            </div>
        </div>
        <?php } ?>

        <?php
      $stmt = $con->prepare("SELECT * FROM likes WHERE post = " . $info['post_id'] . " ");
      $stmt->execute();
      $likeCount = $stmt->rowCount();
      ?>
        <p class="text-right" style="direction:rtl"> <?php echo $likeCount; ?> اشخاص اعجبوا بهذا </p>
        <!-- Post buttons  -->
        <div class="btn-group btn-group-justified" role="group" aria-label="...">

            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default">share <i class="fas fa-share"></i></button>
            </div>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default">comment <i class="far fa-comment-alt"></i></button>
            </div>
            <div id="<?php echo $info['post_id']; ?>" class="btn-group" role="group">

                <?php
          $postId = $info['post_id'];
          $userId = $_SESSION['uid'];

          $stmt  = $con->prepare("SELECT * FROM likes WHERE post = $postId and user = $userId ");
          $stmt->execute();
          $Count = $stmt->rowCount();

          if ($Count > 0) { ?>
                <a href="javascript:void(0)"
                    onclick="insertLike('inc/post/deslike.php?postId=<?php echo $info['post_id'] ?>&userId=<?php echo $_SESSION['uid'] ?>','<?php echo $info['post_id']; ?>')"
                    class="btn btn-default"> deslike <i class="fas fa-thumbs-up"></i></a>
                <?php } else { ?>
                <a href="javascript:void(0)"
                    onclick="insertLike('inc/post/like.php?postId=<?php echo $info['post_id'] ?>&userId=<?php echo $_SESSION['uid'] ?>','<?php echo $info['post_id']; ?>')"
                    class="btn btn-default"> like <i class="far fa-thumbs-up"></i></a>
                <?php } ?>
            </div>
        </div>
        <hr>
        <?php

      $postId = $info['post_id'];
      $stmt  = $con->prepare("SELECT * FROM comments WHERE post = $postId ORDER BY comment_id");
      $stmt->execute();
      $comments = $stmt->fetchAll();
foreach ($comments as $comment) {
        $useCid = $comment['user'];
        $stmt = $con->prepare("SELECT * FROM avatars WHERE user_id = $useCid order by avatar_id DESC");
        $stmt->execute();
        $comentAvatar = $stmt->fetch();
      ?>
        <!-- single comments -->
        <div id="<?php echo $info['post_id']; ?>" class="media">
            <div class="media-left">
                <a href="#">
                    <img style="height:30px;width:30px" class="media-object" src="upload/avatar/<?php if ($comentAvatar['avatar'] == '') {
                                                                                            echo 'default-user-image.png';
                                                                                          } else {
                                                                                            echo $comentAvatar['avatar'];
                                                                                          } ?>" alt="...">
                </a>
            </div>
            <div class="media-body media-comment">
                <h4 class="media-heading">Fname Lname</h4>
                <?php echo $comment['content'] ?>
            </div>

        </div>


        <?php } ?>

        <hr>
        <form enctype="multipart/form-data" id="fupForm">
            <input type="hidden" name="userId" value="<?php echo $_SESSION['uid']; ?>" />
            <input type="hidden" name="postId" value="<?php echo $info['post_id']; ?>" />
            <textarea name="comment" class="form-control">comment...  </textarea>
            <button type="submit" name="submit" class="btn btn-primary btn-block">Comment</button>
        </form>
    </div>
    <?php } ?>
</div>

<script>
function insertLike(page, postId) {
    var xmlhttp;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXobject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {

        if (this.readyState == 4 & this.status == 200) {
            document.getElementById(postId).innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET", page, true);
    xmlhttp.send();
}
</script>
<?php include $tmbl . 'footer.php'; ?>