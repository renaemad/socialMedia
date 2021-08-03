<?php
session_start();

include 'init.php';
$session = $_SESSION['uid'];

$stmt =  $con->prepare("SELECT * FROM users WHERE user_id = $session");
$stmt->execute();
$info_p = $stmt->fetch();
?>

<div class="continer-fluid">
    <div class="col-xs-12  posts col-sm-12 col-md-9 col-lg-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p> المنشورات </p>
            </div>
            <div class="panel-body">
                <?php
                $query = $con->prepare("SELECT * FROM posts order by time DESC");
                $query->execute();
                $postInfo = $query->fetchAll();
                ?>
                <div class="row">
                    <?php foreach ($postInfo as $info) {

                        $userId = $info['user_id'];
                        $stmt = $con->prepare("SELECT * FROM users WHERE user_id = $userId");
                        $stmt->execute();
                        $userName = $stmt->fetch();
                        $stmt1 = $con->prepare("SELECT * FROM avatars WHERE user_id = $session");
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
                    <div
                        class="full-post col-md-offset-5  col-lg-offset-4 col-xl-offset-4 col-sm-12 col-md-7 col-lg-8 col-xl-8">
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
                                    <img style="height:50px;width:50px" class="media-object"
                                        src="upload/avatar/default-user-image.png" alt="...">
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
                                    <img style="height:50px;width:50px" class="media-object"
                                        src="upload/avatar/default-user-image.png" alt="...">
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
                                <button type="button" class="btn btn-default">share <i
                                        class="fas fa-share"></i></button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default">comment <i
                                        class="far fa-comment-alt"></i></button>
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
                                    <img style="height:30px;width:30px" class="media-object"
                                        src="upload/avatar/<?php if ($comentAvatar['avatar'] == '') {
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

            </div>
        </div>

    </div>
    <div class="col-xs-12  col-sm-12 col-md-3 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p> الصورة الشخصية </p>
            </div>
            <div class="panel-body">

                <a class="upload-avatar-link" style="text-decoration:none;" href="upload-avatar.php">
                    <p style="margin-top:95px; margin-left:90px;">تحميل صورة شخصية </p>
                </a>

                <?php
                $myId = $_SESSION['uid'];

                $stmt = $con->prepare("SELECT * FROM avatars WHERE user_id = $myId order by avatar_id desc");
                $stmt->execute();
                $avatar = $stmt->fetch();

                if (empty($avatar['avatar'])) {
                    echo ' <img style="height:200px;width:100%" class="img-responsive img-thumbnail" src="upload/avatar/default-user-image.png" >';
                } else {
                    echo ' <img style="height:200px;width:100%" class="img-responsive img-thumbnail" src="upload/avatar//' . $avatar['avatar'] . ' " >';
                }
                ?>

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
    <div class="col-xs-12  col-sm-12 col-md-3 col-lg-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <p> معرض الصور </p>
            </div>
            <div class="panel-body">
                <?php
                $myId = $_SESSION['uid'];

                $stmt = $con->prepare("SELECT * FROM avatars WHERE user_id = $myId order by avatar_id desc limit 4 ");
                $stmt->execute();
                $avatars = $stmt->fetchAll();


foreach ($avatars as $avatar) {
                ?>
                <div class="col-sm-6">
                    <?php
                        echo '<a href="galarry.php?userID=' . $myId . '" >';
                        echo '<img style="height:100px;width:100%;margin-bottom:10px;" src="upload/avatar//' . $avatar['avatar'] . '" >';
                        echo '</a>';
                        ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="col-xs-12  col-sm-12 col-md-3 col-lg-3">
        <div class="panel panel-default info">
            <div class="panel-heading">
                <p> المعلموات الشخصية </p>
            </div>
            <div class="panel-body">
                <h4>
                    <stron><?php echo ucfirst($info_p['f_name']) . ' ' . ucfirst($info_p['l_name']) ?></stron>
                </h4>
                <ul class="list-unstyled">
                    <li><span> السن </span> | <?php echo $info_p['age'] ?></li>
                    <li><span> المدينة </span> | <?php echo $info_p['town'] ?></li>
                    <li><span> الحالة الإجتماعية </span> | <?php echo $info_p['rel_status'] ?></li>
                </ul>
            </div>
        </div>
    </div>

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
<?php include $tmbl . 'footer.php' ?>