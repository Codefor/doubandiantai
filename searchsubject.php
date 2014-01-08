<?php
list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
include_once(sprintf("%s%s/%s/inc/function.php",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION']));

$songinfo = "";
if(isset($_POST['subjecturl'])){
    $url = trim($_POST['subjecturl']);
    if(preg_match("/http:\/\/music.douban.com\/subject\/(\d+)\//",$url,$match) > 0){
        $subjectid = $match[1];
        $key = "subject_info_$subjectid";
        $songinfo = $kv->get($key);
        if(!$songinfo){
        	$songinfo = fetchSonginfo($subjectid);
            $kv->set($key,$songinfo);
        }
    }
}

if(isset($_POST['songinfo']) && !empty($_POST['songinfo']) && empty($songinfo)){
	saveSonginfo($_POST['songinfo']);
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="http://douban.fm/favicon.ico" type="image/x-icon">

    <title>Save Song Info - doubandiantai</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <!--<link href="bootstrap/signin.css" rel="stylesheet">-->

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../docs-assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form action="searchsubject.php" method="POST">
        <div class="control-group">
            <h3><label class="control-label">subject url</label></h3>
            <input type="text" name="subjecturl" style="width:30%;"/><input type="submit" class="btn btn-sm" value="获取"/>  
            <h2><label class="control-label" for="textarea">Song info</label></h2>
            <div class="controls">
                <textarea id="textarea" name="songinfo" style="width:100%;height:100px"><?=$songinfo?></textarea>
            </div>
          </div>
          <input type="submit" class="btn btn-lg btn-primary btn-block" value="保存"/>               
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
