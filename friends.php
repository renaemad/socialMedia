<?php

session_start();
if (!isset($_SESSION['email'])) {
  header('location:login.php');
}
//$nonav = '';
include 'init.php';
?>
<div class="container">
    <div class="row">
        <div class="col-lg-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <p> الأعضاء </p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="thumbnail">
                                <img src="upload/avatar/169_images.jpg" style="height: 198px;">
                                <div class="caption">
                                    <h5 class="text-center"><strong>ali luay</strong>
                                    </h5>
                                    <p class="text-center"><span></span> |
                                        <span>21</span>
                                    </p>
                                    <div>
                                        <a href="#" class="btn btn-default" role="button"><i
                                                class="fa fa-comments"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" col-md-3">
                            <div class="thumbnail">
                                <img src="upload/avatar/595_rana.jpg" alt="...">
                                <div class="caption">
                                    <h5 class="text-center"><strong>fatima alobaidi </strong>
                                    </h5>
                                    <p class="text-center"><span></span> |
                                        <span>21</span>
                                    </p>
                                    <div>
                                        <a href="#" class="btn btn-default" role="button"><i
                                                class="fa fa-comments"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="col-lg-3">

                <div class="">
                    <?php include $tmbl . 'buttons.php'; ?>
                </div>
            </div>
        </div>
    </div>






    <script>
    function sendFriendRequest(page, postId) {
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