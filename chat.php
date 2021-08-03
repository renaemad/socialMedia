<?php
session_start();

include 'init.php';

$id = isset($_GET['frind']) && is_numeric($_GET['frind']) ? intval($_GET['frind']) : 0;

$stmt =  $con->prepare("SELECT * FROM users WHERE user_id = $id ");
$stmt->execute();
$info = $stmt->fetch();

$stmt = $con->Prepare("SELECT avatar FROM avatars where user_id = $id order by avatar_id desc ");
$stmt->execute();
$avatar = $stmt->fetch();
$count = $stmt->rowCount();

$sender = $_SESSION['uid'];
$other  = isset($_GET['frind']) && is_numeric($_GET['frind']) ? intval($_GET['frind']) : 0;


if ($sender > $other) {
  $chatId = $sender . $other;
} else {
  $chatId = $other . $sender;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  $msg    = $_POST['msg'];

  $stmt = $con->prepare("
     INSERT INTO `chat` (`chat_id`,`sender`, `other`, `msg`, `time`, `date`) 
     VALUES (:chat_id,:sender,:other,:msg,now(),now())");
  $stmt->execute(array(
    'chat_id' => $chatId,
    'sender' => $sender,
    'other'  => $other,
    'msg'    => $msg
  ));
}

$stmt = $con->prepare("
    SELECT chat.* , users.* FROM chat 
    INNER JOIN users ON chat.sender = users.user_id 
    WHERE chat.chat_id = $chatId order by chat.time ");
$stmt->execute();
$rows = $stmt->fetchAll();

?>

<div class="continer-fluid">
  <div class="col-xs-12  posts col-sm-12 col-md-9 col-lg-9">

    <div class="panel panel-default">
      <div class="panel-heading">
        <p> الرسائل </p>
      </div>

      <div class="panel-body">
        <div class="scroll">
          <ul class="chats">
            <?php foreach ($rows as $row) {
              $avId =  $row['sender'];
              $stmt = $con->prepare("SELECT * from avatars where user_id = $avId order by avatar_id desc");
              $stmt->execute();
              $pic = $stmt->fetch();


              if ($row['sender'] == $_SESSION['uid']) {
            ?>
                <!-- start  by me -->
                <li class="by-me margin-bottom-10">
                  <div class="avatar pull-left">
                    <img height="50px" width="50px" src="upload/avatar/<?php echo $pic['avatar'] ?>">
                  </div>
                  <div class="content">
                    <div class="chat-meta"> <?php echo ucfirst($row['f_name']) ?> <span class="pull-right">
                        <?php echo $row['time'] ?> </span></div>
                    <div class="clearfix"> <?php echo $row['msg'] ?> </div>
                  </div>
                </li>
                <!-- end by me -->
              <?php } elseif ($row['sender'] == $id) {

                $stmt = $con->prepare("SELECT * from avatars where user_id = $id order by avatar_id desc");
                $stmt->execute();
                $pic2 = $stmt->fetch();

              ?>
                <!-- start  by other -->
                <li class="by-other margin-bottom-10">
                  <div class="avatar pull-right">
                    <?php if (empty($row['avater'])) { ?>
                      <img height="50px" width="50px" src="upload/avatar/default-user-image.png">
                    <?php } else { ?>
                      <img height="50px" width="50px" src="upload/avatar/<?php echo $row['avatar'] ?>">
                    <?php } ?>
                  </div>
                  <div class="content">
                    <div class="chat-meta"> <?php echo $row['time'] ?> <span class="pull-right"><?php echo $row['f_name'] ?></span></div>
                    <div class="clearfix"> <?php echo $row['msg'] ?> </div>
                  </div>
                </li>
                <!-- end  by other -->
            <?php }
            } ?>
          </ul>
        </div>

        <div>
          <form action="<?PHP echo $_SERVER['PHP_SELF'] . '?frind=' . $id; ?>" method="post" class="form-inline">
            <div class="form-group">
              <input class="form-control" name="msg" type="text">
            </div>
            <button class="btn btn-info" type="submit"> send </button>
          </form>
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
        <?php if ($count > 0) { ?>
          <img class="img-responsive img-thumbnail" src="upload/avatar/<?php echo $avatar['avatar'] ?>">
        <?php } else { ?>
          <img class="img-responsive img-thumbnail" src="upload/avatar/default-user-image.png">
        <?php } ?>


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
    <div class="panel panel-default info">
      <div class="panel-heading">
        <p> المعلموات الشخصية </p>
      </div>
      <div class="panel-body">
        <h4>
          <stron><?php echo ucfirst($info['f_name']) . ' ' . ucfirst($info['l_name']) ?></stron>
        </h4>
        <ul class="list-unstyled">
          <li><span> السن </span> | <?php echo $info['age'] ?></li>
          <li><span> المدينة </span> | <?php echo $info['town'] ?></li>
          <li><span> الحالة الإجتماعية </span> | <?php echo $info['rel_status'] ?></li>
        </ul>
      </div>
    </div>
  </div>

</div>

<?php include $tmbl . 'footer.php' ?>