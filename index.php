<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>HI EMR</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="fonts/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/myCss/overRide.css" rel="stylesheet">
    <link href="css/myCss/index.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--flat ui login-->
    <link rel="stylesheet" href="js/flat-ui-login/css/style.css">
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <!-- CSS -->
    <link rel="stylesheet" href="js/alertifyjs/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="js/alertifyjs/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="js/alertifyjs/css/themes/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="js/alertifyjs/css/themes/bootstrap.min.css"/>

    <!--
        RTL version
    -->
    <link rel="stylesheet" href="js/alertifyjs/css/alertify.rtl.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="js/alertifyjs/css/themes/default.rtl.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="js/alertifyjs/css/themes/semantic.rtl.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="js/alertifyjs/css/themes/bootstrap.rtl.min.css"/>
    <link rel="stylesheet" href="js/jquery-ui/jquery-ui.min.css"/>
</head>

<body>


<nav class="navbar navbar-inverse" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
<!--            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
-->         <img src="images/emr6.png" width="50" height="50">
            <!--   <span id="project_name" style="margin-right: 40px">
                                 <i class="fa fa-users"></i>  Patient EMR
                             </span>-->
        </div>

         <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">ระบบ <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="index.php?vaccation_main">******</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">ตั้งค่าระบบ <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">

                        <li><a href="#" onclick="setConfig();">Database</a></li>
                        <li><a href="index.php?officer">เพิ่มเจ้าหน้าที่</a></li>

                        <li role="separator" class="divider"></li>
                        <li><a href="#">Separated link</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">About Programe <span class="caret"></span></a>

                </li>


            </ul>
            <ul class="nav navbar-nav navbar-right">
                    <div id="regbar">
                        <div id="navthing">
<!--                            <h4><a href="#" id="loginform">Login</a> </h4>-->
                            <?php
                            if(!isset($_SESSION['fullname'])){
                            ?>
                            <button class="btn btn-default" id="loginform" type="button">Login</button>
                            <?php
                            }else{
                                ?>
                                <button class="btn btn" id="logoutform" type="button"><?php echo $_SESSION['fullname']; ?> </button>


                            <a href="logout.php"> <button class="btn btn-warning" id="logoutform" type="button">Logout</button></a>
                            <?php
                            }
                            ?>
                            <div class="login">
                                <div class="arrow-up"></div>
                                <div class="formholder">
                                    <div class="randompad">
                                        <fieldset>
                                            <form method="POST" action="check_login.php">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Username</label>
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputPassword1">Password</label>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="">
                                                </div>

                                                <button type="submit" class="btn btn-default">Submit</button>
                                            </form>

                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



            </ul>

        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<div class="row">
        <?php
        date_default_timezone_set("Asia/Bangkok");

        if(!isset($_SESSION["fullname"])){
            echo "<div class='container'><img src='images/emr.jpg'></div>";
            //exit(0);
        }else{

            include "pt_history_form.php";
        }

        ?>
</div>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--flat ui login-->

<script src="js/jquery-1.11.3.js"></script>

<script src="js/bootstrap.min.js"></script>
<script src="js/flat-ui-login/js/index.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="js/ie10-viewport-bug-workaround.js"></script>
<script src="js/alertifyjs/alertify.min.js"></script>
<script src="myFunction/pt_history_form.js"></script>
</body>
</html>
