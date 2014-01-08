<?php
list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
include_once(sprintf("%s%s/%s/inc/function.php",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION']));

$ret = $kv->pkrget('', 100);     
while (true) {                    
    print_r($ret);                       
    end($ret); 
    
    $start_key = key($ret);
    $i = count($ret);
    if ($i < 100) break;
    
    $ret = $kv->pkrget('', 100, $start_key);
}