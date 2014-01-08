<?php
list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
include_once(sprintf("%s%s/%s/inc/function.php",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION']));

if(isset($_GET['key'])){
    $k = trim($_GET['key']);
    $kv->delete($k);
    echo "delete key $k<br/>";
}else{
    $ret = $kv->pkrget('', 100);     
	while (true) {
        foreach($ret as $k=>$v){
            $kv->delete($k);
            echo "delete key $k<br/>";
        }                       
        end($ret); 
        
        $start_key = key($ret);
        $i = count($ret);
        if ($i < 100) break;
        
        $ret = $kv->pkrget('', 100, $start_key);
    }
}
