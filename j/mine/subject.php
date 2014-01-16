<?php
list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
include_once(sprintf("%s%s/%s/inc/function.php",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION']));

header("Content-Type:application/json");

$ret = array("r"=> -1,"c"=> 0,"needfetch"=>false);

if(isset($_GET['id'])){
    $ret["r"] = 0;
    $subjectid = trim($_GET['id']);
    
    list($songinfo,$needfetch) = _fetchSubjectinfo($subjectid);
    $ret["needfetch"] = $needfetch;
    
    $json = json_decode($songinfo,true);
    
    if($json !== NULL){
        if($json['r'] === 0 && isset($json['song'])){
            $ret["c"] = count($json["song"]);
        }
    }
}
        
die(json_encode($ret));