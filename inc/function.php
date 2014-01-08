<?php
define("LOGIN_URL","http://douban.fm/html5_login");

define("NEW_SUBJECTIDS","new_subjectids");

$kv = new SaeKV();
$kv->init();

function doubanCurl($url){
    $curl = curl_init();
    
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 4);
    
    return $curl;
}

function setDoubanCookie($header){
    foreach(explode("\r\n",$header) as $item){
        if(strpos($item,"Set-Cookie") !== false){
        	//just replace douban.* to doubandiantai.sinaapp.com
            $item = str_replace("douban.fm","doubandiantai.sinaapp.com",$item);
            $item = str_replace("douban.com","doubandiantai.sinaapp.com",$item);

            //do NOT replace because we want to sent multi Set-Cookie
            header($item,false);
        }
	}
}

function formatCookie(){ 
    $cookies = "";
    foreach($_COOKIE as $key=>$value){
        if($key != "saeut" && $key != "_ga" && $key != "username" && $key != "ue"){
        	$cookies .= "$key=$value; ";
        }
    }
    $cookies = rtrim($cookies,"; ");
    return $cookies;
}

function fetchSonginfo($subjectid){
    $url = sprintf("http://douban.fm/j/mine/playlist?type=n&sid=&pt=0.0&channel=0&context=tags:|channel:0|subject_id:%s&from=mainsite&r=4bd54e2850",$subjectid);
    $curl = doubanCurl($url);
    curl_setopt($curl, CURLOPT_REFERER, sprintf("http://music.douban.com/subject/%s/",$subjectid));
    $raw_data = curl_exec($curl);
	curl_close($curl);
    
    return $raw_data;
}

function saveSonginfo($songinfo){
    $json = json_decode($songinfo,true);
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
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}