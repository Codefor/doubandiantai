<?php

function getMp3Url($sid,$ssid){
    $url = sprintf("http://music.douban.com/j/songlist/get_song_url?sid=%s&ssid=%s",$sid,$ssid);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    
    curl_setopt($curl, CURLOPT_REFERER, "http://douban.fm/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 4);
    $raw_data = curl_exec($curl);
    
	curl_close($curl);  
    
    $j = json_decode($raw_data,true);
    
    if($j !== NULL){
    	return $j['r'];        
    }
    return "";
}

function getMp3($url){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);

    curl_setopt($curl, CURLOPT_REFERER, "http://douban.fm/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
    
    $raw_data = curl_exec($curl);
    
	curl_close($curl);  
    return $raw_data;
}

$mysql = new SaeMysql();

$sql = "SELECT sid,ssid,url FROM songs WHERE syncmp3 = 0 ORDER BY RAND() DESC LIMIT 100";
//$sql = "SELECT sid,ssid,url FROM songs WHERE syncmp3 = 0 ORDER BY RAND() DESC";
$songs = $mysql->getData( $sql );

require_once("qiuniu/io.php");
require_once("qiuniu/rs.php");
$bucket = "doubandiantai";


Qiniu_SetKeys($QINIU_ACCESS_KEY, $QINIU_SECRET_KEY);
$client = new Qiniu_MacHttpClient(null);

$ok_songs = array();
foreach($songs as $song){
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
        echo "$key,OK<br>";
    }else{
        echo "$key,ERROR<br>";
    }
}

if(count($ok_songs) > 0){
	$sql = sprintf("UPDATE songs SET syncmp3 = 1 WHERE sid in (%s)",join(",",$ok_songs));
	$mysql->runSql( $sql );
}

$mysql->closeDb();