<?php

$key = isset($_GET["key"])? $_GET["key"] : false;

header("Content-type:application/json");

if($key === false){
    die('{"exist":false}');
}

require_once("qiuniu/rs.php");

$bucket = "doubandiantai";

Qiniu_SetKeys($QINIU_ACCESS_KEY, $QINIU_SECRET_KEY);
$client = new Qiniu_MacHttpClient(null);

list(, $err) = Qiniu_RS_Stat($client, $bucket, $key);

if ($err !== null) {
    echo '{"exist":false}';
}else{
    echo '{"exist":true}';
}
