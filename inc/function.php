<?php
define("LOGIN_URL","http://douban.fm/html5_login");

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