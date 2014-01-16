<?php
list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
include_once(sprintf("%s%s/%s/inc/function.php",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION']));

$doubanurl = sprintf("http://douban.fm/j/mine/playlist?%s",$_SERVER["QUERY_STRING"]);


$curl = doubanCurl($doubanurl);
curl_setopt($curl, CURLOPT_REFERER, "http://douban.fm/partner/uc");
$raw_data = curl_exec($curl);
curl_close($curl);

$body = doubanContent($raw_data);

function filter_song($song){
    //if we should filter the song,we return true
    $filter_artist = array("豆瓣同城购票","豆瓣电影");
    if(isset($song["artist"]) && in_array($song["artist"],$filter_artist,true)){
        return true;
    }
    return false;
}

$json = json_decode($body,true);
header("Content-Type:application/json; charset=utf-8");
if($json !== NULL){
    if($json['r'] === 0 && isset($json['song'])){
        $mysql = new SaeMysql();
        $clean_song = array();
        
        foreach($json['song'] as $song){
            if(filter_song($song)){
                continue;
            }
            
            $clean_song[] = $song;
            $sql = sprintf('INSERT INTO songs VALUES (%s,"%s","%s","%s","%s","%s","%s","%s",%s,"%s","%s",%s,%s,"%s",%s,"%s",%s,0,NULL)',
                           $song['sid'],$song['ssid'],
                           mysql_escape_string($song['title']),
                           mysql_escape_string($song['artist']),
                           mysql_escape_string($song['album']),
                           $song['picture'],$song['url'],
                           mysql_escape_string($song['company']),
                           $song['rating_avg'],$song['public_time'],
                           $song['sub_type'],$song['length'],
                           $song['aid'],$song['sha256'],$song['kbps'],
                           mysql_escape_string($song['albumtitle']),
                           $song['like']);
            $mysql->runSql( $sql );
        }
        $json['song'] = $clean_song;
        $mysql->closeDb();
    }
        
    echo json_encode($json);
}else{
    echo '{"r":0}';
}
