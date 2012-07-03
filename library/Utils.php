<?php




function debug($object, $label = '') {
    Boilerplate_Controller_Plugin_Debug::debug($object, $label);
}

function logger($message, $type = Zend_Log::INFO) {
    Boilerplate_Controller_Plugin_Debug::logger($message, $type);
}


/**
 * Get Real IP address
 * @author http://roshanbh.com.np/2007/12/getting-real-ip-address-in-php.html
 * @param string $email
 *
 * @return bool | integer
 */
function getRealIpAddr() {
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}



 /*
  * Function creates random hash, which is used for password recovery
  */
 function createRandomHash($length = 8)
{
	// Define supported characters in the unique string
	$seeds = 'abcdefghijklmnopqrstuvwqyz0123456789';
	$code = '';
	$count = strlen($seeds);
	for ($i = 0; $i < $length; $i++)
	{
	$code .= $seeds[mt_rand(0, $count - 1)];
	}

	return $code;
}


function array_key_exists_recursive($needle, $haystack) {
    foreach ($haystack as $key => $val) {
        if (is_array($val)) {
            if (array_key_exists_recursive($needle, $val)) {
                return TRUE;
            }
        } elseif ($val == $needle) {
            return TRUE;
        }
    }
    return FALSE;
}

function is_multidimensional_array($a) {
    $rv = array_filter($a, 'is_array');
    if (count($rv) > 0) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function array_equal($a, $b) {
    return (is_array($a) && is_array($b) && array_diff($a, $b) === array_diff($b, $a));
}

function array_identical($a, $b) {
    return (is_array($a) && is_array($b) && array_diff_assoc($a, $b) === array_diff_assoc($b, $a));
}

function pr($val) {
    $debug_backtrace = debug_backtrace();
    echo 'Debug called from ' . $debug_backtrace[1]['file'] . ' (line ' . $debug_backtrace[1]['line'] . ')';
    echo "<pre>";
    print_r($val);
    echo "</pre>";
}

function debug_redirect($url) {
    $debug_backtrace = debug_backtrace();
    $file = '<strong> ' . $debug_backtrace[0]['file'] . '</strong>';
    $line = '<strong>' . $debug_backtrace[0]['line'] . '</strong>';
    
	    echo '<div style="padding:15px 30px; margin:0px; text-align:center; font-size:16px; background-color:#ccc; ">Should redirect to: <a href="' . $url . '">' . $url . '</a>< /div>';
	    echo '<div style="padding:15px 30px; margin:0px; text-align:center; font-size:16px; background-color:#ccc; ">Called from ' . $file . ', line ' . $line . '< /div>';

    echo '<div style="background-color:yellow; border:1px solid red; padding:5px 10px; margin:20px 0px">';
    echo ' <pre>COOKIES:';
    print_r($_COOKIES);
    echo '</pre>';

    echo '<pre>SESSION:';
    print_r($_SESSION);
    echo '</pre>';

    echo '<pre>SERVER:';
    print_r($_SERVER);
    echo '</pre>';

    echo '</div>';
    exit();
}

/*
 * Odstrani mezery na zacatku a na konci slov ulozenych v poli.
 */
 function trimArray( $array )
    {
        return array_map( 'trim', $array );
    }

 	/**
     * Funkce, ktera odstrani z textu diakritiku a nepovolene znaky
     * @param string $string  retezec
     * @return string $s  upraveny retezec
     */
     function convert_nocz($string) {
        $tbl = array(
            "." => "-",
            " " => "-",
            "§" => "",
            "'" => "",
            "\"" => "",
            "_" => "-",
            "?" => "",
            "!" => "",
            ":" => "",
            "/" => "-",
            "=" => "",
            "´" => "",
            "&" => "",
            "(" => "",
            ")" => "",
            "\xc3\xa1" => "a",
            "\xc3\xa4" => "a",
            "\xc4\x8d" => "c",
            "\xc4\x8f" => "d",
            "\xc3\xa9" => "e",
            "\xc4\x9b" => "e",
            "\xc3\xad" => "i",
            "\xc4\xbe" => "l",
            "\xc4\xba" => "l",
            "\xc5\x88" => "n",
            "\xc3\xb3" => "o", "\xc3\xb6" => "o", "\xc5\x91" => "o", "\xc3\xb4" => "o", "\xc5\x99" => "r", "\xc5\x95" => "r", "\xc5\xa1" => "s", "\xc5\xa5" => "t", "\xc3\xba" => "u", "\xc5\xaf" => "u", "\xc3\xbc" => "u", "\xc5\xb1" => "u", "\xc3\xbd" => "y", "\xc5\xbe" => "z", "\xc3\x81" => "a", "\xc3\x84" => "a", "\xc4\x8c" => "c", "\xc4\x8e" => "d", "\xc3\x89" => "e", "\xc4\x9a" => "e", "\xc3\x8d" => "i", "\xc4\xbd" => "l", "\xc4\xb9" => "l", "\xc5\x87" => "n", "\xc3\x93" => "o", "\xc3\x96" => "o", "\xc5\x90" => "o", "\xc3\x94" => "o", "\xc5\x98" => "r", "\xc5\x94" => "r", "\xc5\xa0" => "s", "\xc5\xa4" => "t", "\xc3\x9a" => "u", "\xc5\xae" => "u", "\xc3\x9c" => "u", "\xc5\xb0" => "u", "\xc3\x9d" => "y", "\xc5\xbd" => "z");
        $string = strtr($string, $tbl);
        $string = mb_strtolower($string);


        return $string;
    }

//http://php.net/manual/en/function.rmdir.php
//holger1 at NOSPAMzentralplan dot de 26-Jun-2010 09:00
   function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }


function parseTagsToArray($string){
	if(strlen($string) > 0){
	   $array = explode(',', $string);
	   $array = trimArray($array);
	   $array = array_filter($array);
	   return    array_unique($array);
	}
	return array(); // empty array have to be return, because of work in facade with this
}

 /*
  * Get current url adress
  * source : http://www.webcheatsheet.com/PHP/get_current_page_url.php
  */

function currentServerURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"];
 }
 return $pageURL;
}

?>
