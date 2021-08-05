<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <form action="search-name.php" method="POST" class="navbar-form navbar-left">
                <div class="form-group">
                    <input name ='phrase' type="text" class="form-control" placeholder=" بحث ">
                </div>
                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> بحث </button>
            </form>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a href="frindRequests.php" class="dropdown-toggle" data-toggle="dropdown" role="button"
                        aria-haspopup="true" aria-expanded="false"><i class="fa fa-users"></i> </a>
                    <ul class="dropdown-menu" style="width:205px;">
                        <?php
                        $stmt = $con->prepare("SELECT * FROM friend_request WHERE second_user = " . $_SESSION['uid'] . " AND status = 0 ");
                        $stmt->execute();
                        $reqCount = $stmt->rowCount();
                        $requests = $stmt->fetchAll();
                        if ($reqCount > 0) {
                            foreach ($requests as $req) {
                                $stmt = $con->prepare("SELECT * FROM users WHERE user_id = " . $req['first_user'] . " ");
                                $stmt->execute();
                                $userInfo = $stmt->fetch();
                        ?>
                        <li id="" style="margin: 0 15px;text-align: center;">
                            <h5><b><?php echo ucfirst($userInfo['f_name']) . ' ' . ucfirst($userInfo['l_name']); ?></b>
                            </h5>
                            <div class="btn-group" role="group" aria-label="...">
                                <button type="button" onclick="getinfo('inc/friend/action.php?action=1&user=','')"
                                    class="btn btn-success"> accept </button>
                                <button type="button" onclick="getinfo('inc/friend/action.php?action=2&user=','')"
                                    class="btn btn-danger"> Reject </button>
                            </div>
                        </li>
                        <?php }
                        } else { ?>

                        <li style="margin: 15px;text-align: center;">لاتوجد طلبات صداقه حتى الآن</li>
                        <?php } ?>
                    </ul>
                </li>
                <li><a href="inbox.php"><i class="fa fa-comments"></i> الرسائل </a></li>
                <li><a href="index.php"><i class="fa fa-home"></i> الرئيسية </a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        اشعارات
                    </a>
                    <ul class="dropdown-menu">
                        <?php
                        $stmt = $con->prepare("SELECT * FROM notification WHERE user = " . $_SESSION['uid'] . " ");
                        $stmt->execute();
                        $Count = $stmt->rowCount();
                        $rows = $stmt->fetchAll();

                        if ($Count > 0) {
                            foreach ($rows as $row) { ?>
                        <li><a href=" <?php echo $row['url'] ?>"> <?php echo $row['content'] ?> </a></li>
                        <?php }
                        } else { ?>
                        <li>لاتوجد اشعارات حتى الآن</li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <?php

                    $myId =  $_SESSION['uid'];

                    $stmt = $con->prepare("SELECT * FROM users where user_id = $myId ");
                    $stmt->execute();
                    $info = $stmt->fetch();

                    $stmt = $con->prepare("SELECT * FROM avatars WHERE user_id = $myId order by avatar_id desc");
                    $stmt->execute();
                    $avatar = $stmt->fetch();
                    ?>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false">
                        <?php echo ucfirst($info['f_name']) . ' ' . ucfirst($info['l_name']);
                        if (empty($avatar['avatar'])) {
                            echo ' <img style="height:30px;width:30px;border-radius:30px;"   src="upload/avatar/default-user-image.png" >';
                        } else {
                            echo ' <img style="height:30px;width:30px;border-radius:30px;"  src="upload/avatar//' . $avatar['avatar'] . ' " >';
                        }

                        ?>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="edit.php"><i class="fa fa-edit"></i> تعديل الحساب </a></li>
                        <li><a href="my-profile.php"><i class="fa fa-user"></i> الصفحة الشخصية </a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out"></i> الخروج </a></li>
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>