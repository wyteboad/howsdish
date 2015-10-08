<?php
session_start();



require_once realpath(dirname(__FILE__)) . '/functions.php';

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

$query = 'SELECT * FROM lunch_menu WHERE menu_id like \''.$sel_date.'_%\' ORDER BY menu_id ASC';
$result = mysqli_query($conn, $query);

$item_cnt = 1;
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>How's Dish?</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap-dist.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="css/slidemenu.css">
    <link rel="stylesheet" type="text/css" href="css/custom.css">

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
					<li class="active"><a href="index.php">Lunch Menu</a></li>

					<li><a href="vote_result.php">Vote Results</a></li>

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
		<div class="container">
<div class="row">
<div class="col-md-5 col-sm-12">
			<div id="smallCalendar" class="col-md-12 col-sm-12">
				<button id="show-dtp-btn" class="btn btn-warning btn-justified btn-lg btn-block"></button>
				<br>
			</div><!-- #smallCalendar -->
			<div id="dtp" class="well well col-md-12 col-sm-12">
				<div class="form-group">
	        		<div class="row">
			            <div>
			                <div id="datetimepicker1"></div>
			            </div>
		        	</div>
		    	</div><!-- .form-group -->
			</div><!-- .col-sm-12 -->
</div><!-- .col-md-4 -->
		<!-- </div> --><!-- .container -->

		<!-- <div class="container"> -->
<div class="col-md-7 col-sm-12">
			<div id="accordion" class="panel-group" role="tablist" aria-multiselectable="true">
				


<?php
while($row = mysqli_fetch_assoc($result)) {
?>

				<div class="panel panel-white">
				    <div class="panel-heading" role="tab" id="heading<?php echo $item_cnt; ?>">
				        <div class="row">
					      	<div class="col-xs-9 col-sm-10 col-md-10">
					      		<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $item_cnt; ?>" aria-expanded="<?php echo ($item_cnt == 1) ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $item_cnt; ?>">
						      		<h4 class="panel-title" style="line-height: 30px;">
						      			<span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;
										<?php echo $row['category'].' - '.$row['title']; ?>
								    </h4>
						      	</a>
						    </div>
					      	<div class="col-xs-3 col-sm-2 col-md-2" style="line-height: 30px; text-align: right;">
					      		<em class="vote-indicator"></em>
					      	</div><!-- .col-xs-3 -->
				        </div>
				    </div><!-- #heading<?php echo $item_cnt; ?> -->
				    <div id="collapse<?php echo $item_cnt; ?>" class="panel-collapse collapse <?php if(endswith($_GET['menu_id'], sprintf('_%02d', $item_cnt))) {echo 'in';} ?>" role="tabpanel" aria-labelledby="heading<?php echo $item_cnt; ?>">
				        <div class="panel-body">
							<!-- Menu Start { -->
					        <div class="row">
								<div id="imagespace" class="col-xs-12">
									<div class="thumbnail">
										<!-- img file depending on the menu -->
										<img src="<?php echo $row['img_link']; ?>" id="foodimage" style="width: 100%;">
									</div>
								</div> <!-- #imagespace -->




<?php 
	if (isset($authUrl)) {
    	//print "<a class='login' href='$authUrl'>Login</a>";
?>




								<div class="col-xs-12">
									<div class="votable-area row">
										<div class="votingspace col-xs-12">
											<div class="panel panel-danger">
											    <div class="panel-heading">
													<a href="<?php echo $authUrl.'&state='.$row['menu_id']; ?>" class="login btn btn-danger btn-justified btn-lg btn-block">Login with Google</a>

													<br>

												    <p class="text-center"><span class="glyphicon glyphicon-screenshot" aria-hidden="true"></span> You can vote after log in with your school email.<br>You wanna enjoy more delicious lunch? <strong>Vote Now!!</strong></p>
											    </div>
											</div>
										</div> <!-- #votingspace -->
									</div><!-- .row -->
								</div><!-- .col-xs-12 -->



<?php

	} else {
	    print "<a class='logout' href='https://www.google.com/accounts/Logout?continue=https://appengine.google.com/_ah/logout?continue=".$redirect_uri."?logout'>Logout</a>";
	} // end if

	if (isset($_SESSION['access_token'])) {
	    $me = $plus->people->get("me");
	    $myEmail = ($me['emails'][0]['value']);

	    if(validateEmail($myEmail)) {

	    	// check vote history
	    	$query2 = 'SELECT COUNT(*) AS count FROM vote WHERE email=\''.$myEmail.'\' and menu_id like \''.$sel_date.'_%\'';
	    	$result2 = mysqli_query($conn, $query2);
			$row2 = mysqli_fetch_assoc($result2);
			$alreadyVoted = $row2['count'];

	    	if(!$alreadyVoted) {
?>



								<div class="col-xs-12 col-md-12">
									<div class="votable-area row">
										<!-- <div id="up" class="col-xs-6">
											<p class="text-center" style="margin:0;line-height: 1.5; font-size: 3em;"><span id="thumb-up" class="glyphicon glyphicon-thumbs-up" aria-hidden="true" ></span></p>
										</div>
										<div id="down" class="col-xs-6">
											<p class="text-center" style="margin:0;line-height: 1.5; font-size: 3em;"><span id="thumb-down" class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></p>
										</div> -->
										<div class="votingspace col-xs-12">
											<div class="btn-group btn-group-justified" data-toggle="buttons">
											    <label class="vote-option-label <?php echo $row['menu_id']; ?> btn btn-vote btn-lg">
											    	<input type="radio" name="vote_options" data-select="up" autocomplete="off"><p class="text-center" style="margin:0;line-height: 1.5; font-size: 2em;"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true" ></span></p>
											    </label>
											  	<label class="vote-option-label <?php echo $row['menu_id']; ?> btn btn-vote btn-lg">
											   		<input type="radio" name="vote_options" data-select="down" autocomplete="off"><p class="text-center" style="margin:0;line-height: 1.5; font-size: 2em;"><span class="glyphicon glyphicon-thumbs-down" aria-hidden="true"></span></p>
											  	</label>
											</div>
										</div>

										<div class="votingspace col-xs-12">
											<button class="vote-btn btn btn-success btn-justified btn-lg btn-block" data-menu-id="<?php echo $row['menu_id']; ?>">VOTE!</button>
										</div> <!-- #votingspace -->
									</div><!-- .row -->
								</div><!-- .col-xs-12 -->

		

<?php
			} else {
?>

								<div class="col-xs-12 col-md-12">
									<div class="votable-area row">
										<div class="votingspace col-xs-12">
											<button class="voteresult-btn btn btn-info btn-justified btn-lg btn-block" data-menu-id="<?php echo $row['menu_id']; ?>" style="font-size: 1em;"><span class="glyphicon glyphicon-sunglasses" aria-hidden="true"></span> You'd already voted. Click to see result.</button>
										</div> <!-- #votingspace -->
									</div><!-- .row -->
								</div><!-- .col-xs-12 -->

<?php
			} // end if


    	} else {
?>



								<div class="col-xs-12 col-md-12">
									<div class="votable-area row">
										<div class="votingspace col-xs-12">
											<div class="panel panel-danger">
											    <div class="panel-heading">
												    <p class="text-center"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Your email is not school email. You cannot vote.</p>
											    </div>
											</div>
										</div> <!-- #votingspace -->
									</div><!-- .row -->
								</div><!-- .col-xs-12 -->



<?php
	    } // end if
	}// end if
?>



							</div><!-- .row -->

							<div class="row">
								<div class="menu-desc col-xs-12">
									<h3><?php echo $row['title']; ?></h3>

									<p><?php echo $row['description']; ?></p>
								</div>
							</div>
							<!-- } Menu End -->

				      </div><!-- .panel-body -->
				    </div><!-- #collapse<?php echo $item_cnt; ?> -->
				</div><!-- .panel .panel-danger -->



<?php
	$item_cnt++;
} // end while

mysqli_close($conn);
?>



			</div><!-- #accordion -->
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
		currentPageName = 'index';
	</script>
</body>
</html>

















