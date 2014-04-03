<?php
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

define("DB_PATH","./");
include "xmlDB.php";
$id =$_POST["id"];
$row = Database::factory("logs",$id,"Logs");
$row->delete();
echo json_encode(array('result' => 1));
?>

