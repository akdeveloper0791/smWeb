<?php
$whitelist = array(
    'localhost','::1');

if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
    echo "not valid" ;
}else{
    echo " valid" ;
}
?>