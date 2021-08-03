<?php
session_start();
include 'init.php';
if (isset($_SESSION['email'])) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $uid       = $_SESSION['uid'];

        $fname     = $_POST['fname'];
        $lname     = $_POST['lname'];
        $email     = $_POST['email'];
        $pass      = $_POST['pass'];
        $town      = $_POST['town'];
        $relStatus = $_POST['rel_status'];

        $stmt = $con->prepare("
        UPDATE 
          users 
        SET 
          f_name = ? ,
          l_name = ? , 
          email = ? , 
          pass = ? , 
          town  = ? , 
          rel_status = ? 
        WHERE 
          user_id = ? ");
        $stmt->execute(array(
            $fname,
            $lname,
            $email,
            $pass,
            $town,
            $relStatus,
            $uid
        ));

        if ($stmt) {
            echo 'success';
        }
    }
    $uid       = $_SESSION['uid'];

    $stmt = $con->prepare("SELECT * FROM users WHERE user_id = $uid");
    $stmt->execute();
    $info = $stmt->fetch();

?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 col-md-offset-3 col-md-6">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p> تعديل البيانات الشخصية </p>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="form-horizontal">
                            <div class="form-group">

                                <div class="col-sm-9">
                                    <input class="form-control" value="<?php echo $info['f_name'] ?>" name="fname" type="text">
                                </div>
                                <label class="col-sm-3"> الاسم الأول </label>
                            </div>

                            <div class="form-group">

                                <div class="col-sm-9">
                                    <input class="form-control" value="<?php echo $info['l_name'] ?>" name="lname" type="text">
                                </div>
                                <label class="col-sm-3"> الاسم الثاني </label>
                            </div>

                            <div class="form-group">

                                <div class="col-sm-9">
                                    <input class="form-control" value="<?php echo $info['email'] ?>" name="email" type="email">
                                </div>
                                <label class="col-sm-3"> البريد الألكترونى </label>
                            </div>

                            <div class="form-group">

                                <div class="col-sm-9">
                                    <input class="form-control" value="<?php echo $info['pass'] ?>" name="pass" type="password">
                                </div>
                                <label class="col-sm-3"> كلمة المرور </label>
                            </div>

                            <div class="form-group">

                                <div class="col-sm-9">
                                    <input class="form-control" value="<?php echo $info['town'] ?>" name="town" type="text">
                                </div>
                                <label class="col-sm-3"> المدينة </label>
                            </div>

                            <div class="form-group">
                                <?php
                                $uid = $_SESSION['uid'];

                                $stmt = $con->prepare("select sex from users where user_id = $uid");
                                $stmt->execute();
                                $sex = $stmt->fetch();

                                $single = 'اعزب';
                                if ($sex['sex'] == 'ذكر') {
                                    $single = 'اعزب';
                                } elseif ($sex['sex'] == 'أنثى') {
                                    $single = 'عزباء';
                                }

                                if ($sex['sex'] == 'ذكر') {
                                    $engaged = 'خاطب';
                                } elseif ($sex['sex'] == 'أنثى') {
                                    $engaged = 'مخطوبة';
                                }

                                if ($sex['sex'] == 'ذكر') {
                                    $marrid = 'متزوج';
                                } elseif ($sex['sex'] == 'أنثى') {
                                    $marrid = 'متزوجة';
                                }

                                if ($sex['sex'] == 'ذكر') {
                                    $Divorced = 'مطلق';
                                } elseif ($sex['sex'] == 'أنثى') {
                                    $Divorced = 'مطلقة';
                                }

                                ?>
                                <div class="col-sm-9">
                                    <select class="form-control" name="rel_status">

                                        <option value="<?php echo $single ?>"> اعزب </option>
                                        <option value="<?php echo $engaged ?>"> خاطب / مخطوبة </option>
                                        <option value="<?php echo $marrid ?>"> متزوج / متزوجة </option>
                                        <option value="<?php echo $Divorced ?>"> مطلق / مطلقة </option>
                                    </select>
                                </div>
                                <label class="col-sm-3"> الحالة الاجتماعية </label>

                            </div>

                            <div class="form-group">
                                <div class="  col-md-9">
                                    <button class="login-btn btn-block" type="submit"> حفظ </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php
    include $tmbl . 'footer.php';
} else {

    header('location:login.php');
}


?>