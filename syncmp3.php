<?php
$start = 0;
$limit = 100;

if(isset($_GET["s"])){
    $start = (int)$_GET["s"];
}

if($start < 0){
    $start = 0;
}


if(isset($_GET["l"])){
    $limit = (int)$_GET["l"];
}

if($limit < 10){
    $limit = 10;
}
if($limit > 10000){
    $limit = 10000;
}


$mysql = new SaeMysql();

$splitor = "<br />";
#$sql = "SELECT sid,ssid,url FROM songs WHERE syncmp3 = 0 ORDER BY RAND() DESC LIMIT 100";
$sql = "SELECT sid,ssid,url FROM songs WHERE syncmp3 = 0 LIMIT $start,$limit";
if(isset($_GET['a'])){
    $sql = "SELECT sid,ssid,url FROM songs WHERE syncmp3 = 0";
    $splitor = "\n";
}

$songs = $mysql->getData( $sql );

if($songs === NULL){
    die('everything is ok.');
}

require_once("qiuniu/io.php");
require_once("qiuniu/rs.php");
$bucket = "doubandiantai";


Qiniu_SetKeys($QINIU_ACCESS_KEY, $QINIU_SECRET_KEY);
$client = new Qiniu_MacHttpClient(null);

$ok_songs = array();
$counter = 0;
foreach($songs as $song){
    $counter += 1;
    //$url = getMp3Url($song['sid'],$song['ssid']);
    $url = $song['url'];
    $items = explode("/",$url);
    $key = $items[count($items) - 1];
    
    list(, $err) = Qiniu_RS_Stat($client, $bucket, $key);
    
    /**
    if($err !== null){
        //we fetch and store to qiniu
        $putPolicy = new Qiniu_RS_PutPolicy($bucket);
        $upToken = $putPolicy->Token(null);		
        $mp3 = getMp3($url);   

        Qiniu_Put($upToken, $key, $mp3, null);
    }
    */
        
    if($err === null){
        $ok_songs[] = $song['sid'];
        echo "$key,OK$splitor";
    }else{
        echo "$key,ERROR$splitor";
    }
    
    //if the ok_songs >= 500 or counter exceed 1000,we save to db
    //and clear the ok_songs array
    if(count($ok_songs) >= 100 || ( count($ok_songs) > 0 && $counter >= 500) ){
		$sql = sprintf("UPDATE songs SET syncmp3 = 1 WHERE sid in (%s)",join(",",$ok_songs));
		$mysql->runSql( $sql );
        $ok_songs = array();
	}
}

if(count($ok_songs) > 0){
	$sql = sprintf("UPDATE songs SET syncmp3 = 1 WHERE sid in (%s)",join(",",$ok_songs));
	$mysql->runSql( $sql );
}

$mysql->closeDb();