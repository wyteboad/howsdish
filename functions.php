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
	if(	endsWith($myEmail, 'dztal@naver.com') || endsWith($myEmail, '@chadwickschool.org')){
		if(	endsWith($myEmail, '2020@chadwickschool.org') ||
			endsWith($myEmail, '2021@chadwickschool.org') ||
			endsWith($myEmail, '2022@chadwickschool.org') ||
			endsWith($myEmail, '2023@chadwickschool.org') ||
			endsWith($myEmail, '2024@chadwickschool.org') ||
			endsWith($myEmail, '2025@chadwickschool.org') ||
			endsWith($myEmail, '2026@chadwickschool.org') ||
			endsWith($myEmail, '2027@chadwickschool.org') ||
			endsWith($myEmail, '2028@chadwickschool.org') ||
			endsWith($myEmail, '2029@chadwickschool.org') ||
			endsWith($myEmail, '2030@chadwickschool.org') ||
			endsWith($myEmail, '2031@chadwickschool.org') ||
			endsWith($myEmail, '2032@chadwickschool.org') ||
			endsWith($myEmail, '2033@chadwickschool.org') ||
			endsWith($myEmail, '2034@chadwickschool.org') ||
			endsWith($myEmail, '2035@chadwickschool.org') ||
			endsWith($myEmail, '2036@chadwickschool.org') ||
			endsWith($myEmail, '2037@chadwickschool.org') ||
			endsWith($myEmail, '2038@chadwickschool.org') ||
			endsWith($myEmail, '2039@chadwickschool.org') ||
			endsWith($myEmail, '2040@chadwickschool.org') ||
			endsWith($myEmail, '2041@chadwickschool.org') ||
			endsWith($myEmail, '2042@chadwickschool.org') ||
			endsWith($myEmail, '2043@chadwickschool.org') ||
			endsWith($myEmail, '2044@chadwickschool.org') ||
			endsWith($myEmail, '2045@chadwickschool.org') ||
			endsWith($myEmail, '2046@chadwickschool.org') ||
			endsWith($myEmail, '2047@chadwickschool.org') ||
			endsWith($myEmail, '2048@chadwickschool.org') ||
			endsWith($myEmail, '2049@chadwickschool.org') ||
			endsWith($myEmail, '2050@chadwickschool.org')
			){
			return false;
		}
		return true;
	} else{
		return false;
	}
}


?>