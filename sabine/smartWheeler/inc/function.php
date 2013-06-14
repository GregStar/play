<?php
function check_name($name){ #prüft auf Länge und erlaubte Zeichen
    if(strlen($name)>=2 && strlen($name) < 25 && check_wort($name)){
        return true;
    }else{
        return false;
    }
}

function check_wort($wort){ #prüft auf erlaubte Buchstaben (incl. Umlaute, - und .)
    $wort = strtolower($wort);
    $erlaubt = "abcdefghijklmnopqrstuvwxyzßäöü -."; 
    for($i=0; $i<strlen($wort); $i++){
        $position = strpos ($erlaubt, $wort[$i]);
            if($position === false){
                return false;
                break;
            }
    }
    return true;
}

function check_email($email){
    if(is_bool(filter_var($email, FILTER_VALIDATE_EMAIL))){
	return false;
    }else{
        return true;
    }
}


function check_zahl($var){
    if(ctype_digit($var)){
        return true;
    }else{
        return false;
    }
}

function check_rights($rights){ #prüft auf erlaubte Buchstaben (incl. Umlaute, - und .)
    if($rights == '1' || $rights == '2' || $rights == '3' ){
        return true;
    }else{
        return false;
    }
}
?>
