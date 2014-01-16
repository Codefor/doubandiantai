<?php
list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
include_once(sprintf("%s%s/%s/inc/function.php",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION']));

_require_once("qiuniu/rs.php");

header("Content-Type:application/json");

if(isset($_GET['k'])){
    $key = trim($_GET['k']);
    
    Qiniu_SetKeys($QINIU_ACCESS_KEY, $QINIU_SECRET_KEY);
   
    $baseUrl = Qiniu_RS_MakeBaseUrl("doubandiantai.u.qiniudn.com", $key);
    $getPolicy = new Qiniu_RS_GetPolicy();
    //10分钟后过期
    $getPolicy->SetExpires(600);
    $privateUrl = $getPolicy->MakeRequest($baseUrl, null);
    
    die(json_encode(array('r'=>0,'url'=>$privateUrl)));
}else{
    die('{"r":-1}');
}


