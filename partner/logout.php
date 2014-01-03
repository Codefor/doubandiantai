<?php
list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
include_once(sprintf("%s%s/%s/inc/function.php",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION']));


$LOGOUT_URl = sprintf("http://douban.fm/partner/logout?%s",$_SERVER["QUERY_STRING"]);

function logout($doubanurl,$cookies){
    $curl = doubanCurl($doubanurl);
    
    curl_setopt($curl, CURLOPT_COOKIE, $cookies);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_REFERER, "http://douban.fm/partner/uc");
    $raw_data = curl_exec($curl);
    curl_close($curl);
    
    list($header,) = explode("\r\n\r\n",$raw_data);
    setDoubanCookie($header);
}

logout($LOGOUT_URl,formatCookie());
header("Location:http://doubandiantai.sinaapp.com");
