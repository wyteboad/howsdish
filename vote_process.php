<?php
session_start();

$menuId = (isset($_GET['menu_id']) && $_GET['menu_id']) ? $_GET['menu_id'] : NULL;
$voteOption = (isset($_GET['vote_option']) && $_GET['vote_option']) ? $_GET['vote_option'] : NULL;

if(!$menuId || !$voteOption) {
	header('Location: ./index.php');
}

$ip=$_SERVER['REMOTE_ADDR'];
$localhost = ($ip == '::1') ? true : false;

if (!$localhost) {
	require_once realpath(dirname(__FILE__)) . '/../src/Google/autoload.php';
} else {
	require_once realpath(dirname(__FILE__)) . '/../src/Google/autoload.php';
}

function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

require_once realpath(dirname(__FILE__)) . '/../config.php';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("https://www.googleapis.com/auth/userinfo.profile");
$client->addScope("https://www.googleapis.com/auth/userinfo.email");

$plus = new Google_Service_Plus($client);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    $client->setAccessToken($_SESSION['access_token']);
    $_SESSION['token'] = $client->getAccessToken();

    // evaluate email 
    $me = $plus->people->get("me");
	$myEmail = ($me['emails'][0]['value']);

    if(!endsWith($myEmail, '@chadwickschool.org') && !endsWith($myEmail,'dztal@naver.com')) { // when email failed
    	header('Location: ./index.php');
    }

    // test print
    // echo 'menu id : '.$menuId.'<br>';
    // echo 'selected vote option : '.$voteOption.'<br>';
    // echo $myEmail.'<br>';

    // change voteOption string
    $voteOption = ($voteOption == 'up'  ) ? 'true' :
    			  ($voteOption == 'down') ? 'false' : NULL;

	if (!$conn) {
		die('database connection failed');
	}

	// 
	/* query example

	INSERT INTO vote(email, menu_id, vote_result) SELECT * FROM (SELECT 'dztal@naver.com', '20150824_01', 'false') AS tmp WHERE NOT EXISTS (SELECT * FROM vote WHERE email = 'dztal@naver.com' and menu_id LIKE '20150824_%') 

	*/

	// insert vote result to db (when  not existed)
	$query = 'INSERT INTO vote(email, menu_id, vote_result) SELECT * FROM (SELECT \''.$myEmail.'\', \''.$menuId.'\', \''.$voteOption.'\') AS tmp WHERE NOT EXISTS (SELECT * FROM vote WHERE email = \''.$myEmail.'\' and menu_id LIKE \''.substr($menuId, 0, 8).'_%\')';
	// echo $query.'<br>';
	$result = mysqli_query($conn, $query);

	// disconnect database
	mysqli_close($conn);

	// go to vote result
	header('Location: ./vote_result.php?menu_id='.$menuId);

} else { // when access_token doesn't exist
	// go to index.php
	header('Location: ./index.php');
}

?>