<?php
session_start();

date_default_timezone_set("Asia/Seoul");
$sel_date = (isset($_GET['menu_id']) && !empty($_GET['menu_id'])) ? substr($_GET['menu_id'], 0, 8) : date('Ymd');

require_once realpath(dirname(__FILE__)) . '/../config.php';

if (!$localhost) {
	require_once realpath(dirname(__FILE__)) . '/../src/Google/autoload.php';
} else {
	require_once realpath(dirname(__FILE__)) . '/../src/Google/autoload.php';
}

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("https://www.googleapis.com/auth/userinfo.profile");
$client->addScope("https://www.googleapis.com/auth/userinfo.email");

$plus = new Google_Service_Plus($client);

if (isset($_REQUEST['logout'])) {
    unset($_SESSION['access_token']);
}

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL).'?menu_id='.$_GET['state']);
}

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
    $_SESSION['token'] = $client->getAccessToken();
} else {
    $authUrl = $client->createAuthUrl();
}
?>



<?php
//phpinfo();

if ($conn) {
	;
} else {
	die('database connection failed');
}

$query = 'SELECT COUNT(*) AS count FROM vote WHERE menu_id like \''.$sel_date.'_%\'';
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$totalVoteCnt = $row['count'];


$query = 'SELECT COUNT(DISTINCT menu_id) AS count FROM lunch_menu WHERE menu_id like \''.$sel_date.'_%\'';
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$menuItemCnt = $row['count'];

for ($itemIdx=1; $itemIdx <= $menuItemCnt; $itemIdx++) { 
	$query = 'SELECT COUNT(*) AS count FROM vote WHERE menu_id = \''.$sel_date.'_'.sprintf('%02d', $itemIdx).'\' and vote_result = \'up\'';
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	$itemVoteCnt[$itemIdx]['up'] = $row['count'];

	$query = 'SELECT COUNT(*) AS count FROM vote WHERE menu_id = \''.$sel_date.'_'.sprintf('%02d', $itemIdx).'\' and vote_result = \'down\'';
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	$itemVoteCnt[$itemIdx]['down'] = $row['count'];

	$query = 'SELECT * FROM lunch_menu WHERE menu_id = \''.$sel_date.'_'.sprintf('%02d', $itemIdx).'\'';
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	$itemVoteCnt[$itemIdx]['category'] = $row['category'];
	$itemVoteCnt[$itemIdx]['title'] = $row['title'];
}

mysqli_close($conn);
?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>School Food</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap-dist.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="css/slidemenu.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" type="text/css" href="css/vote.css">

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
				<a class="navbar-brand" href="index.php"><img src="img/food_logo.png" style="max-height:51px; margin-top: -16px;"></a>
			</div><!-- .navbar-header -->
			<div id="slidemenu">
				<ul class="nav navbar-nav">
					<li><a href="index.php">Lunch Menu</a></li>

					<li class="active"><a href="vote_result.php">Vote Results</a></li>

					<!-- <li class="dropdown">
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
						</ul> --><!-- .dropdown-menu -->
					<!-- </li> --><!-- .dropdown -->

					<li><a href="about.php">About US</a></li>
				</ul><!-- .nav -->
			</div><!-- #slidemenu -->
		</div><!-- .container -->
	</div><!-- #slide-nav -->

	<div id="page-content">

		<!-- datepicker -->
		<div class="container">
<div class="row">
<div class="col-md-5 col-sm-12">
			<div id="smallCalendar" class="col-md-12 col-sm-12">
				<button id="show-dtp-btn" class="btn btn-warning btn-justified btn-lg btn-block"></button>
				<br>
			</div><!-- #smallCalendar -->
			<div id="dtp" class="well well-lg col-md-12 col-sm-12">
				<div class="form-group">
			        <div class="row">
			            <div>
			                <div id="datetimepicker1"></div>
			            </div>
			        </div>
			    </div>
			</div><!-- .col-sm-12 -->
</div><!-- .col-md-4 -->
		<!-- </div> --><!-- .container -->

		<!-- <div class="container"> -->
<div class="col-md-7 col-sm-12">
			<div id="today">
				<div class="well well-lg" id="results_well">



<?php
for ($itemIdx=1; $itemIdx <= $menuItemCnt; $itemIdx++) { 
?>



					<div class="row">
						<div class="col-xs-12">
							<h3 id="food_title"><?php echo $itemVoteCnt[$itemIdx]['category'];?> - <?php echo $itemVoteCnt[$itemIdx]['title'];?></h3>
						</div><!-- .col-xs-12 -->
					</div><!-- .row -->
					<div class="row">
						<div class="col-xs-2 col-sm-1" style="text-align:right;color:#5CB85C;">
							<span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
						</div><!-- .col-xs-2 -->
						<div class="col-xs-10 col-sm-11">
							<div class="progress">
							  <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?php echo (($itemVoteCnt[$itemIdx]['up']/$totalVoteCnt)*100);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo (($itemVoteCnt[$itemIdx]['up']/$totalVoteCnt)*100);?>%"><?php echo $itemVoteCnt[$itemIdx]['up']; ?>
							  </div>
							</div><!-- .progress -->
						</div><!-- .col-xs-10 -->
					</div><!-- .row -->
					<div class="row">
						<div class="col-xs-2 col-sm-1" style="text-align:right;color:#D9534F;">
							<span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span>
						</div><!-- .col-xs-2 -->
						<div class="col-xs-10 col-sm-11">
							<div class="progress">
							  <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?php echo (($itemVoteCnt[$itemIdx]['down']/$totalVoteCnt)*100);?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo (($itemVoteCnt[$itemIdx]['down']/$totalVoteCnt)*100);?>%"><?php echo $itemVoteCnt[$itemIdx]['down']; ?>
							  </div>
							</div><!-- .progress -->
						</div><!-- .col-xs-10 -->
					</div><!-- .row -->



<?php
}
?>



				</div><!-- .well .well-lg -->
			</div><!-- #today -->
</div><!-- .col-md-8 -->
</div><!-- .row -->
		</div><!-- .container -->
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
	<!-- addition script -->
	<script type="text/javascript">
		currentPageName = 'vote_result';
	</script>
</body>
</html>

















