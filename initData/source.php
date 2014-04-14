<?php
    
define("DB_PATH","./");
include "xmlDB.php";
include "generateLogs.php";

$file = './source.xml';
$desFile = './des.xml';
$rootXml = simplexml_load_file($file);
$file_content = file_get_contents($file);
$row = Database::factory("des",NULL,"Logs");


foreach ($rootXml->Logs as $logs){
    $row->platform = (String)$logs->attributes()->platform;
   foreach ($logs->Publish as $publish){
       $row->date = (String)$publish->attributes()->date;
       $row->version = explode(" ", (String)$publish->attributes()->title)[1];
       foreach ($publish->Version as $log){
           $row->title = (String)$log->attributes()->title;
           $row->lang = (String)$log->attributes()->lang;
           $row->description = (String)$log->Description;
           $row->indexDescription = (String)$log->IndexDescription;
           foreach ($log->Features as $feature){
               if(!isset($features)){
                   $features = array();
               }
               if(!isset($featuresNum)){
                   $featuresNum = array();
               }
               $features[] = (String)$feature;
               $featuresNum[] = (String)$feature->attributes()->images;
           }
           if(isset($features)){
               $row->features = $features;
           }
           if(isset($featuresNum)){
               $row->featuresNum = $featuresNum;
           }

           $row->save();
           unset($row->features);
           unset($row->featuresNum);
           unset($features);
           unset($featuresNum);
       }
       
       
   }
    
}
?>

