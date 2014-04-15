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

$row->date =$_POST["date"];
$row->version =$_POST["version"];
$row->lang =$_POST["lang"];
$row->title =$_POST["title"];
$row->platform =$_POST["platform"];
$row->description =$_POST["description"];
$row->indexDescription =$_POST["indexDescription"];
$row->features =$_POST["feature"];
$row->featuresNum =$_POST["featureNum"];

$tempFile = $srcPath.preg_replace("/\./","_",$row->platform."_".$row->version).".html";
$imgDir = $srcPath."/".$row->lang."/img/".preg_replace("/\./","_",$row->platform."_".$row->version);
if(!file_exists($tempFile)){
	file_put_contents($tempFile,file_get_contents($filename));
}
if(!file_exists($imgDir)){
	mkdir($imgDir, 0777);
}
$row->save();
?>
