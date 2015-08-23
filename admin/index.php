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
$menu_id = $_GET['menu_id'];

if(!isset($menu_id) || $menu_id == NULL || $menu_id == '') {
?>

<form action="">
    <div class="form-group">
        <label for="menu-id">Menu ID</label>
        <input type="text" class="form-control" id="menu-id" name="menu_id" placeholder="Insert Menu ID">
    </div>

    <br>
    <button type="submit" class="btn btn-info btn-block">Go</button>
</form>

<?php
    die();
}
?>








<form action="insert.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="category"><h3><?php echo $menu_id; ?><h3></label>
        <input type="hidden" name="menu-id" value=
        "<?php echo $menu_id; ?>">
    </div>


    <div class="form-group">
        <label for="category">Category</label>
        <input type="text" class="form-control" id="category" name="category" placeholder="Write Category ...">
    </div>

    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Write Title ...">
    </div>

    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" rows="4" id="description" name="description" placeholder="Write Description ..."></textarea>
    </div>

    <div class="form-group">
        <label for="image">Selct Menu Image</label>
        <input type="file" id="image" name="image">
    </div>

    <div class="form-group">
        <label for="pass">Password</label>
        <input type="password" class="form-control" id="pass" name="pass" placeholder="Write Password ...">
    </div>
    
    <button type="submit" class="btn btn-info btn-block">Add New Menu</button>
</form>












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