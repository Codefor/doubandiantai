<?php
list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
include_once(sprintf("%s%s/%s/inc/function.php",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION']));

$topSubjectUrl = "http://music.douban.com/chart";
$curl = doubanCurl($topSubjectUrl);
curl_setopt($curl, CURLOPT_REFERER, "http://music.douban.com");
$raw_data = doubanContent($curl);

$raw_data = str_replace("\n","",$raw_data);
$raw_data = str_replace("\r","",$raw_data);

preg_match_all('/http:\/\/music.douban.com\/subject\/(\d+)\//',$raw_data,$matches);

$subjects = $kv->get(NEW_SUBJECTIDS);

if($subjects !== false){
	$subjects = explode("_",$subjects);
}else{
    $subjects = array();
}

foreach($matches[1] as $subject){
    if(!in_array($subject,$subjects)){
        $subjects[] = $subject;
    }
}

$subjects = join("_",$subjects);
$kv->set(NEW_SUBJECTIDS,$subjects);

echo $subjects;
