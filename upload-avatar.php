<?php

session_start();
if ($_SESSION['email']) {

    //$nonav = '';
    include 'init.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

            $myId = $_SESSION['uid'];

            $stmt = $con->prepare("
         INSERT INTO 
         avatars ( `avatar`, `avatar_date`, `user_id`) 
         VALUES ( :avatar, now(), :useID)");
            $stmt->execute(array(
                'avatar' => $neName,
                'useID'  => $myId
            ));

            if ($stmt) {
                $success = "تم رفع الصورة بنجاح";
            }
        }
    }
    $myId = $_SESSION['uid'];

    $stmt = $con->prepare("SELECT * FROM avatars WHERE user_id = $myId order by avatar_id desc");
    $stmt->execute();
    $avatar = $stmt->fetch();

?>

<div class="container-fluid">
    <div class="row">
        <div class="  col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="  col-sm-offset-4 col-sm-4">
                <?php
                    if (empty($avatar['avatar'])) {
                        echo ' <img class="img-responsive img-thumbnail" src="upload/avatar/default-user-image.png" >';
                    } else {
                        echo ' <img class="img-responsive img-thumbnail" src="upload/avatar//' . $avatar['avatar'] . ' " >';
                    }


                    ?>
                <form actio="<?PHP echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">

                    <input class="form-control" name="avatar" type="file">
                    <button type="submit" class="login-btn btn-block"> تحميل </button>

                </form>
                <?php if (isset($error)) {
                    ?>
                <div class="alert alert-danger text-center"><?php echo $error ?></div>
                <?php } elseif (isset($success)) {
                    ?>
                <div class="alert alert-success text-center"><?php echo $success ?></div>
                <?php } ?>

            </div>
        </div>
    </div>
</div>


<?php
    include $tmbl . 'footer.php';
} else {
    header('location:login.php');
}