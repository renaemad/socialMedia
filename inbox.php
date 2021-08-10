<?php
$title = 'الدردشه';
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
<section class="main-chat-section">
    <div class="container">
        <div class="row">
            <div class="left-item  col-lg-8 col-md-6 col-sm-12 d-sm-none d-md-block">

                <div class="scroll">
                    <script>
                    setInterval(function() {
                        $('#Success').load('inc/chat/chat.php?frind=<?php echo $other; ?>');
                    }, 3000);
                    </script>
                    <ul class="chats" id="Success">
                        <?php foreach ($rows as $row) {
                            if ($row['sender'] == $_SESSION['uid']) {

                                $stmt = $con->prepare("SELECT * FROM users WHERE user_id = " . $row['sender'] . " ");
                                $stmt->execute();
                                $userInfo = $stmt->fetch();
                                $stmt = $con->prepare("SELECT * FROM avatars WHERE user_id = " . $row['sender'] . "");
                                $stmt->execute();
                                $avatar = $stmt->fetch();
                        ?>
                        <!-- start  by me -->
                        <li class="by-me margin-bottom-10">
                            <div class="avatar pull-left">
                                <!-- <img height="50px" width="50px" src="upload/avatar/default-user-image.png"> -->
                                <img src="upload/avatar/<?php echo $avatar['avatar'] ?>" height="50px" width="50px" alt="...">
                            </div>
                            <div class="content">
                                <div class="chat-meta"> <?php echo $userInfo['f_name'] ?> <span class="pull-right">
                                        <?php echo $row['time'] ?> </span></div>
                                <div class="clearfix"><?php echo $row['msg'] ?></div>
                            </div>
                        </li>
                        <!-- end by me -->
                        <?php } elseif ($row['other'] == $_SESSION['uid']) {
                                $stmt = $con->prepare("SELECT * FROM users WHERE user_id = " . $row['sender'] . " ");
                                $stmt->execute();
                                $userInfo = $stmt->fetch();
                                $stmt = $con->prepare("SELECT * FROM avatars WHERE user_id = " . $row['sender'] . "");
                                $stmt->execute();
                                $avatars = $stmt->fetch();
                            ?>
                        <!-- start  by other -->
                        <li class="by-other margin-bottom-10">
                            <div class="avatar pull-right">
                            <img src="upload/avatar/<?php echo $avatars['avatar'] ?>" height="50px" width="50px" alt="...">
                            </div>
                            <div class="content">
                                <div class="chat-meta"> <?php echo $row['time'] ?> <span
                                        class="pull-right"><?php echo $userInfo['f_name'] ?> </span></div>
                                <div class="clearfix"><?php echo $row['msg'] ?></div>
                            </div>
                        </li>
                        <!-- end  by other -->
                        <?php }
                        } ?>
                    </ul>
                </div>
                <div style="padding-top: 15px;" class="row">
                    <div class="col-lg-offset-1 col-lg-10 chat-form">
                        <form id="Chat" enctype="multipart/form-data">
                            <div class="form-group">
                                <input type="hidden" name="friend" value="<?php echo $other; ?>">
                                <textarea class="form-control" id="msg" name="msg" rows="5"></textarea>
                            </div>
                            <button type="submit" name="submit" class="btn btn-block btn-primary"> <i
                                    class="fa fa-paper-plane"></i> </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
            $stmt = $con->prepare("SELECT DISTINCT chat_id,sender,other FROM chat WHERE sender = " . $_SESSION['uid'] . " ");
            $stmt->execute();
            $infos = $stmt->fetchAll();
            ?>
            <div class="right-item  overflow-auto col-lg-4 col-md-6 col-sm-12">
                <?php foreach ($infos as $info) {
                    $stmt = $con->prepare("SELECT * FROM chat WHERE sender = " . $info['other'] . " ");
                    $stmt->execute();
                    $chat = $stmt->fetch();

                    $stmt = $con->prepare("SELECT * FROM users WHERE user_id = " . $info['other'] . " ");
                    $stmt->execute();
                    $user = $stmt->fetch();

                    //background-color: #ddd;
                    $stmt = $con->prepare("SELECT * from avatars where user_id = " . $info['other'] . "");
                    $stmt->execute();
                    $pic2 = $stmt->fetch();

                ?>
                <a href="inbox.php?frind=<?php echo $user['user_id']; ?>">
                    <div <?php if ($info['other'] == $other) {
                                    echo 'style="background-color: #ddd;"';
                                } ?> class="row users-messages text-right">
                        <div class="col-md-8 user-item">
                            <h6 style="direction:rtl;color:#286090;font-weight: 700;font-size:20px;margin:0">
                                <?php echo $user['f_name'] . ' ' . $user['l_name'] ?></h6>
                            <p style="color: #99999b; font-weight: bold;margin:0">
                                <?php mb_internal_encoding("UTF-8");
                                    echo mb_substr($chat['msg'], 0, 30); ?></p>
                            <p style="margin:0" class="time"><?php echo $chat['time'] ?> </p>

                        </div>
                        <div class="col-md-4 user-img">
                            <!-- <img class="img-fluid img-thumbnail mx-auto" src="upload/avatar/default-user-image.png"> -->
                            <img class="img-fluid img-thumbnail mx-auto"
                                src="upload/avatar/<?php echo $pic2['avatar'] ?>">
                        </div>
                    </div>
                </a>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<!-- Jquery JS -->
<?php include $tmbl . 'footer.php';