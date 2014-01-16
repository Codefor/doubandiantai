<?php
define("LOGIN_URL","http://douban.fm/html5_login");

define("NEW_SUBJECTIDS","new_subjectids");

define("BUCKET","doubandiantai");

$kv = new SaeKV();
$kv->init();

function _require_once($path){
    list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
    require_once(sprintf("%s%s/%s/%s",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION'],$path));
}


function doubanCurl($url){
    $curl = curl_init();
    
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.63 Safari/537.36");
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_COOKIE, formatCookie());
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 4);
    
    return $curl;
}

function doubanContent($curl){
    $raw_data = curl_exec($curl);
    curl_close($curl);

    list($header,$body) = explode("\r\n\r\n", $raw_data, 2);
    setDoubanCookie($header);
    return $body;
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
    
    $raw_data = doubanContent($curl);
    
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

function fetchSubjectinfo($url){
    if(preg_match("/http:\/\/music.douban.com\/subject\/(\d+)\//",$url,$match) > 0){
        $subjectid = $match[1];
        list($songinfo,) = _fetchSubjectinfo($subjectid);
        return $songinfo;
    }
    return false;
}

function _fetchSubjectinfo($subjectid){
    global $kv;
    $key = "subject_info_$subjectid";
    $songinfo = $kv->get($key);
    
    $needfetch = false;
    if(!$songinfo){
        $needfetch = true;
        $songinfo = fetchSonginfo($subjectid);
        $kv->set($key,$songinfo);
        saveSonginfo($songinfo);
    }
    
    return array($songinfo,$needfetch);
}

function login($doubanurl,$cookies,$postdata){
    $curl = doubanCurl($doubanurl);

    curl_setopt($curl, CURLOPT_HTTPHEADER,array('Content-Type: application/x-www-form-urlencoded')); 
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_COOKIE, $cookies);
    curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    
    curl_setopt($curl, CURLOPT_REFERER, "http://douban.fm/html5_login");

    $raw_data = curl_exec($curl);

    curl_close($curl);
    return $raw_data;
}

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
