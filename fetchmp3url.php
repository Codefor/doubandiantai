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
if($limit > 1000){
    $limit = 1000;
}

$mysql = new SaeMysql();

$sql = "SELECT sid,ssid,url FROM songs WHERE syncmp3 = 0 LIMIT $start,$limit";

$splitor = "<br />";
if(isset($_GET['n'])){
    $splitor = "\n";
}

$songs = $mysql->getData( $sql );
$mysql->closeDb();


require_once("qiuniu/io.php");
require_once("qiuniu/rs.php");
$bucket = "doubandiantai";


Qiniu_SetKeys($QINIU_ACCESS_KEY, $QINIU_SECRET_KEY);
$client = new Qiniu_MacHttpClient(null);

$ok_songs = array();
$counter = 0;

foreach($songs as $song){
    $counter += 1;
    
    $url = $song['url'];
    $items = explode("/",$url);
    $key = $items[count($items) - 1];
    
    list(, $err) = Qiniu_RS_Stat($client, $bucket, $key);
    if($err !== null){
    	echo sprintf("http://music.douban.com/j/songlist/get_song_url?sid=%s&ssid=%s%s",$song['sid'],$song['ssid'],$splitor);
    }else{
        $ok_songs[] = $song['sid'];
    }
    
    if(count($ok_songs) >= 100 || ( count($ok_songs) > 0 && $counter >= 500) ){
		$sql = sprintf("UPDATE songs SET syncmp3 = 1 WHERE sid in (%s)",join(",",$ok_songs));
		$mysql->runSql( $sql );
        $ok_songs = array();
	}
}

