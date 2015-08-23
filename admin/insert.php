
<!-- header template start -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>School Food</title>

    <link rel="stylesheet" type="text/css" href="../css/bootstrap-dist.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="../css/slidemenu.css">
    <link rel="stylesheet" type="text/css" href="../css/custom.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jquery -->
    <script type="text/javascript" src="js/jquery-1.11.3.js"></script>
</head>
<body>
    <div id="slide-nav" class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <a class="navbar-brand" href="../index.php"><img src="../img/food_logo.png" style="max-height:51px; margin-top: -16px;"></a>
            </div><!-- .navbar-header -->
            <div id="slidemenu">
                <ul class="nav navbar-nav">
                    <li><a href="../index.php">Lunch Menu</a></li>

                    <li><a href="../vote_result.php">Vote Results</a></li>

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Game <b class="caret"></b></a>
                        
                        <ul class="dropdown-menu">

                            <li class="dropdown-header">Card Games</li>
                            <li><a href="#">Card 1-1</a></li>
                            <li><a href="#">Card 1-2</a></li>
                            <li><a href="#">Card 1-3</a></li>

                            <li class="divider"></li>

                            <li class="dropdown-header">Shooting Games</li>
                            <li><a href="#">Shooting 2-1</a></li>
                            <li><a href="#">Shooting 2-2</a></li>
                            <li><a href="#">Shooting 2-3</a></li>

                            <li class="divider"></li>

                            <li class="dropdown-header">Quiz Games</li>
                            <li><a href="#">Quiz 3-1</a></li>
                            <li><a href="#">Quiz 3-2</a></li>
                        </ul><!-- .dropdown-menu -->
                    </li><!-- .dropdown -->

                    <li><a href="../about.php">About US</a></li>
                </ul><!-- .nav -->
            </div><!-- #slidemenu -->
        </div><!-- .container -->
    </div><!-- #slide-nav -->
    
    <div id="page-content">
        <div class="container">
<!-- header template end -->






<?php
require_once realpath(dirname(__FILE__)) . '/../../config.php';

if ($_POST['pass'] !== 'test1234') {
    
    header('Location: ./?menu_id='.$_POST['menu-id']);
    die();   
}


if (isset($_FILES['image'])) {
    $errors = array();
    $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $_FILES['image']['name'];
    $file_set = strtolower(end(explode('.', $file_name)));
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    if (in_array($file_set, $allowed_ext) === false) {
        $errors[] = 'Extension not allowed';
    }
    if ($file_size > 2099752) {
        $errors[] = 'File size must be under 2mb';
    }
    if (empty($errors)) {
        $new_file_name = $_POST['menu-id'].'.'.$file_set;

        if (move_uploaded_file($file_tmp, '../img/' . $new_file_name)) {
            echo 'File uploaded';
            echo '<p>menu-id : '.$_POST['menu-id'].'</p>';
            echo '<p>category : '.$_POST['category'].'</p>';
            echo '<p>title : '.$_POST['title'].'</p>';
            echo '<p>description : '.$_POST['description'].'</p>';
            echo '<p><img src="../img/'.$new_file_name.'"></p>';
            echo '<p>password : '.$_POST['pass'].'</p>';
        } else {
            foreach ($errors as $error) {
            echo $error. '<br>';    
            }
        }
    }
}
?>








<!-- footer template start -->

        </div> <!-- .container -->
    </div><!-- #page-content -->


    <!-- moment.js -->
    <script type="text/javascript" src="js/moment.js"></script>
    <!-- transition.js in bootstrap full version -->
    <script type="text/javascript" src="js/transition.js"></script>
    <!-- collapse.js in bootstrap full version -->
    <script type="text/javascript" src="js/collapse.js"></script>
    <!-- bootstrap.js -->
    <script type="text/javascript" src="js/bootstrap-dist.js"></script>
    <!-- bootstrap-datetimepicker.js -->
    <script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
    <!-- slidemenu.js -->
    <script type="text/javascript" src="js/slidemenu.js"></script>
    <!-- custom.js -->
    <script type="text/javascript" src="js/custom.js"></script>
</body>
</html>
<!-- footer template end -->