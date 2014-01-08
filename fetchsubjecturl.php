<?php
list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
include_once(sprintf("%s%s/%s/inc/function.php",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION']));

$subjects = $kv->get(NEW_SUBJECTIDS);

$subjects =trim($subjects,"");
if($subjects == "" ){
    die('everything is ok');
}

$subjects = explode("_",$subjects);
foreach($subjects as $subject){
    echo sprintf("http://music.douban.com/subject/%s/<br/>",$subject);
}