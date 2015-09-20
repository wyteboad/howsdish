<?php 

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

function base64UrlEncode($inputStr)
{
    return strtr(base64_encode($inputStr), '+/=', '-_,');
}

function base64UrlDecode($inputStr)
{
    return base64_decode(strtr($inputStr, '-_,', '+/='));
}

/**
 * Function that confirm authorized email address. 
 * 
 * @param string $myEmail	User email address.
 * @return bool 			Return true if email is authorized and false if email is not authorized.
 * 
 */
function validateEmail($myEmail)
{
	if(endsWith($myEmail, 'dztal@naver.com') || endsWith($myEmail, '@chadwickschool.org')){
		return true;
	} else{
		return false;
	}
}


?>