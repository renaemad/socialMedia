<?php

session_start();
// if (!isset($_SESSION['email'])) {
//   header('location:login.php');
// }
//$nonav = '';
include 'init.php';
?>

<div class="container-fluid">
    <!-- <div class=" col-xs-12 col-sm-12 col-md-9 col-lg-9">
         include $tmbl . 'search-control.php'; 
    </div> -->
    <div class=" col-lg-9">
        <?php include $tmbl . 'view-users.php'; ?>
    </div>
    <div class=" col-lg-3">
        <?php include $tmbl . 'buttons.php'; ?>
    </div>
</div>
<script>
function getinfo(page, postId) {
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