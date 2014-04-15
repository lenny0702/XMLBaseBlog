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

$tempFile = $srcPath.preg_replace("/\./","_",$row->platform."_".$row->version).".html";
$imgDir = $srcPath."/".$row->lang."/img/".preg_replace("/\./","_",$row->platform."_".$row->version);

if(file_exists($tempFile)){
	unlink($tempFile);
}

if(file_exists($imgDir)){
	delete_dir($imgDir);
}


$row->delete();

echo json_encode(array('result' => 1));

function delete_dir($src) { 
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                delete_dir($src . '/' . $file); 
            } 
            else { 
                unlink($src . '/' . $file); 
            } 
        } 
    } 
    rmdir($src);
    closedir($dir); 
}
?>

