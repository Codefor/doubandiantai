<?php
$mp3url = isset($_GET['url']) ? $_GET['url']:false;
if($mp3url === false){
    exit();
}

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $mp3url);
curl_setopt($curl, CURLOPT_COOKIE, 'openExpPan=Y; bid="MKUJT7f5tg8"; dbcl2="4302982:6oiqDHi8lM4"; fmNlogin="y"; __utma=58778424.245919213.1384749879.1387688955.1387704209.34; __utmb=58778424.10.10.1387704209; __utmc=58778424; __utmz=58778424.1387704209.34.4.utmcsr=baidu|utmccn=(organic)|utmcmd=organic|utmctr=http%3A%2F%2Fdouban.fm%2Fpartner%2F; __utmv=58778424.430');

curl_setopt($curl, CURLOPT_REFERER, "http://douban.fm/");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 4);
$raw_data = curl_exec($curl);

header("Content-Type: audio/mpeg");
echo $raw_data;