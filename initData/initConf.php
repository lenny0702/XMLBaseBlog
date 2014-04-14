<?php 
define("DB_PATH","./");
include "xmlDB.php";
$row = Database::factory("logs",NULL,"configuration");
//-----------------------------------------------for iPhone-----------------------------------
$row->key = "isSpecified";
$row->value = "0";
$row->save();
$row->key = "lang";
$row->value = array('en', 'zh_TW', 'pt', 'th', 'id', 'vi', 'es', 'ru', 'ar', 'he', 'pl', 'hi', 'ja', 'it', 'ko', 'ms', 'tr');
$row->save();
$row->key = "platform";
$row->value = array('iPhone', 'Android', 'Windows Phone', 'S40', 'Symbian V5', 'Symbian V3', 'BlackBerry', 'BlackBerry 10');
$row->save();
?>

