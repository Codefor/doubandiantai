<?php
list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
include_once(sprintf("%s%s/%s/inc/function.php",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION']));

$doubanurl = sprintf("http://douban.fm/j/mine/playlist?%s",$_SERVER["QUERY_STRING"]);


$curl = doubanCurl($doubanurl);
curl_setopt($curl, CURLOPT_HEADER, true);
curl_setopt($curl, CURLOPT_COOKIE, formatCookie());
curl_setopt($curl, CURLOPT_REFERER, "http://douban.fm/partner/uc");
$raw_data = curl_exec($curl);
curl_close($curl);

list($header,$body) = explode("\r\n\r\n", $raw_data, 2);
setDoubanCookie($header);

$json = json_decode($body,true);
header("Content-Type:application/json; charset=utf-8");
if($json !== NULL){
    if($json['r'] === 0 && isset($json['song'])){
        $mysql = new SaeMysql();
        foreach($json['song'] as $song){
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
        $mysql->closeDb();
    }
        
    echo $body;
}else{
    echo '{"r":0}';
}