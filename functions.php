<?php


error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );


function filter_int(int $int){
	if (filter_var($int, FILTER_VALIDATE_INT) === 0 || filter_var($int, FILTER_VALIDATE_INT )){
		return $int;
    }
}


function filter_email($email=""){
	$email=filter_text($email);
	$email = filter_var($email, FILTER_SANITIZE_EMAIL);
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		return $email;
	}
}

function filter_url($url){
	$url=filter_text($url);
	$url = filter_var($url, FILTER_SANITIZE_URL);
	if(filter_var($url, FILTER_VALIDATE_URL)){
		  return $url;
    }
}

function filter_name($name=""){
	$name=filter_text($name);
	if (preg_match("/^[a-zA-Z ]*$/",$name)){
		return $name;
    }
}

function filter_text($text=""){
	$text = trim($text);
	$text = stripslashes($text);
	$text = strip_tags($text);
	$text = htmlspecialchars($text);
	return $text;
}

function get_num_of_string(string $string,int $num_of_words=200)
{
    $string = preg_replace('/\s+/', ' ', trim($string));
    $string=strip_tags($string);
    $words = explode(" ", $string);
    $new_words=[];
    $new_string = "";
    for ($i = 0; $i < count($words); $i++) {
    	if($words[$i] !== "&nbsp;"){
    		$new_words[] = $words[$i];
    	}
    }
    // if number of words you want to get is greater than number of words in the string
    if ($num_of_words > count($new_words)) {
        $num_of_words = count($new_words);
    }
    for ($j=0; $j < $num_of_words; $j++) { 
    			$new_string .= $new_words[$j] . " ";
    		}

    return trim($new_string);
}


if (! function_exists("include_view")) {
	/*
	* all views for application,
	* present in resources/view,
	* to include one view file into another view..
	* use function include_view..
	*/
	function include_view(string $path)
	{
		try {
			$path = preg_replace("/\./", "/", $path);
		    if (!file_exists("../resources/views/".ltrim($path,"/").".php"))
		        throw new Exception ('file could not include here!!');
		    else
		        include_once "../resources/views/".ltrim($path,"/").".php";
		}
		catch(Exception $e) {    
		    echo "Error Message: {$e->getMessage()}<br>In file: function.php <br> line number: {$e->getline()}";
		}
	}
}
