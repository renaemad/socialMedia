<?php 
    session_start();
    $nonav = '';

   if(isset($_SESSION['email'])){
       header('location:index.php');
   }
     
    include 'init.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
     
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $pass  = $_POST['pass'];
        $pass2 = $_POST['conf-pass'];
        $birth = $_POST['bitrhDay'];
        $year  =  date('Y');
        $age   = $year - $birth;
        $sex   = $_POST['sex'];
      

        $stmt = $con->prepare("SELECT * FROM users Where email = ? ");
        $stmt->execute(array($email));
        $count = $stmt ->rowCount();
     
        $formError = array();
       
        if($fname == ''){
         $formError[] = 'حقل الاسم الأول فارغ';
        }
        if($lname == ''){
         $formError[] = 'حقل الاسم الثاني فارغ';
        }
        if($email == ''){
         $formError[] = 'حقل البريد الإلكترونى فارغ ';
        }
        if($pass == ''){
         $formError[] = 'حقل كلمة المرور فارغ ';
        }
        if($pass == ''){
         $formError[] = 'حقل تأكيد كلمة المرور فارغ ';
        }
        if(strlen($fname) < 3 ){
         $formError[] = 'الحد الادني للاسم الأول  3 احرف';
        }
        if(strlen($fname) > 10 ){
         $formError[] = 'الحد الأقصى للأسم الأول 10 احرف';
        }
         if(strlen($lname) < 3 ){
         $formError[] = 'الحد الادني للأسم الثاني 3 احرف';
        }
        if(strlen($lname) > 10 ){
         $formError[] = 'الحد الأقصى للأسم الثاني 10 احرف';
        }
         if(strlen($email) < 5 ){
         $formError[] = 'الحد الادني للبريد الإلكترونى 5 احرف';
        }
         if(strlen($pass) < 6 ){
         $formError[] = 'كلمة المرور ضعيفة يجب استخدام 6 أحرف علي الأقل ';
        }
        
        if($count > 0){
          $formError[] = 'هذا البريد الالكتروني مستخدم من قبل';
        }
        if($pass !== $pass2){
          $formError[] = 'كلمتان المرور غير متطابقتين '; 
        }
     
        if(empty($formError)){
     
        $stmt = $con->prepare("
        INSERT INTO `users` (`f_name`, `l_name`, `sex` , `email`, `pass` , `birthDay` ,`age` ) 
        VALUES (:fname,:lname , :sex ,:email,:pass,:bday,:age)");
        $stmt->execute(array(
          'fname' => $fname,
          'lname' => $lname,
          'sex'   => $sex,
          'email' => $email,
          'pass'  => $pass,
          'bday'  => $birth,
          'age'   => $age
         ));
         
         $stmt = $con->prepare("SELECT user_id , email , pass from users where email = ? and pass = ? ");
         $stmt->execute(array($email,$pass));
         $get = $stmt->fetch();
         
        if($stmt){
          $_SESSION['email'] = $email;
          $_SESSION['uid'] = $get['user_id'];
           
          // the message
          $msg = "First line of text\nSecond line of text";

          // use wordwrap() if lines are longer than 70 characters
          $msg = wordwrap($msg,70);

          // send email
          mail($email,"My subject",$msg);

          header('location:index.php');

        }
       }
   
    } 

?>
 <section class="login-page" > 
 <div class="container " >

      <div class="col-sm-offset-3 col-sm-6" >
          <div class="login-form">
           <h2 style="color:#fff;" class="text-center margin-bottom-12"> انشاء حساب جديد </h2>
              <form aciton="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" class="form-horizontal">
                <div class="form-group" >  
                  <div  class="col-sm-6 margin-bottom-12">                
                      <input class="form-control" type="text" name="fname" placeholder="الأسم الأول " reqired >
                  </div>
                   <div  class="col-sm-6 margin-bottom-12">                
                      <input class="form-control" type="text" name="lname" placeholder="الأسم الثاني" reqired >
                  </div> 
                   <div  class="col-sm-12 margin-bottom-12">                
                      <input class="form-control" type="email" name="email" placeholder="البريد الإلكترونى" reqired >
                  </div>
                   <div  class="col-sm-12 margin-bottom-12">                
                      <input class="form-control" type="password" name="pass" placeholder="كلمة المرور" reqired>
                  </div>
                   <div  class="col-sm-12 margin-bottom-12">                
                      <input class="form-control" type="password" name="conf-pass" placeholder="تأكيد كلمة المرور" reqired >
                   </div>
                
                    <div  class="col-sm-6 margin-bottom-12">                
                      <input class="form-control" type="date" name="bitrhDay" reqired >
                   </div>
                   
                   <div  class="col-sm-6 margin-bottom-12">                
                     <select class="form-control" name="sex" >
                       <?php 
                         $male  = 'ذكر';
                         $fmale = 'أنثى'; 
                       ?>
                        <option value="<?php echo $male ?>" > ذكر </option>
                        <option value="<?php echo $fmale ?>" > أنثى </option>
                     </select>
                   </div>
                 
                  <div class="col-sm-12  margin-bottom-12" >
                     <button class="form-control sign-up-btn" type="submit" > انشاء حساب </button>
                  </div>
                
               </div>
              </form>
           
             <div class="form-group" >
                    <p class="text-center">
                     <a style="text-decoration:none" class="sign-up-link" href="login.php" > دخول من حسابي الحالي  </a>
                    </p>
             </div>
           
          </div>
      </div>
  </div>
</section>