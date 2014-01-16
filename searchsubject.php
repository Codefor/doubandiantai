<?php
list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
include_once(sprintf("%s%s/%s/inc/function.php",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION']));

$songinfo = "";
if(isset($_POST['subjecturl'])){
    $url = trim($_POST['subjecturl']);
    $songinfo = fetchSubjectinfo($url);
}

if(isset($_POST['songinfo']) && !empty($_POST['songinfo']) && empty($songinfo)){
    //saveSonginfo($_POST['songinfo']);
}

?>
        
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="keywords" content="doubandiantai,doubanfm,电台,移动,app,音乐,智能,推荐,豆瓣FM,豆瓣,FM,豆瓣电台," />
	<meta name="description" content="doubandiantai是基于豆瓣FM的你专属的个性化音乐收听工具。它简单方便，打开就能收听。在收听过程中，你可以用“红心”、“垃圾桶”、“循环”
“重放”、“跳过”等操作 告诉doubandiantai你的喜好。豆瓣FM将根据你的操作和反馈，从海量曲库中自动发现并播出符合你音乐口味的歌曲。" />
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
      <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
        
          ga('create', 'UA-46670605-2', 'sinaapp.com');
          ga('send', 'pageview');

		</script>
        
        <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "//hm.baidu.com/hm.js?a7b3d67bafdcda2386e88e1afc5a357b";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
        })();
        </script>
  </head>

  <body>

    <div class="container">

      <form action="searchsubject.php" method="POST">
        <div class="control-group">
            <h3><label class="control-label">subject url</label></h3>
            <input type="text" name="subjecturl" style="width:30%;"/><input type="submit" class="btn btn-sm" value="获取"/>  
            <h2><label class="control-label" for="textarea">Song info</label></h2>
            <div class="controls">
                <textarea id="textarea" style="width:100%;height:100px"><?=$songinfo?></textarea>
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
