<?php
list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
include_once(sprintf("%s%s/%s/inc/function.php",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION']));

$login = false;

if(isset($_COOKIE['ck']) && isset($_COOKIE['dbcl2'])){
	$login = true;
    
    list($id,) = explode(":",trim($_COOKIE['dbcl2'],' "'));
    $ck = trim($_COOKIE['ck'],' "');
    $username = $_COOKIE['username'];
}

$mysql = new SaeMysql();
$sql = "SELECT COUNT(*) as c FROM songs";
$ret = $mysql->getData( $sql );
$song_count = $ret[0]['c'];

$sql = "SELECT COUNT(DISTINCT(album)) as c FROM songs";
$ret = $mysql->getData( $sql );
$album_count = $ret[0]['c'];

$sql = "SELECT COUNT(DISTINCT(artist)) as c FROM songs";
$ret = $mysql->getData( $sql );
$artist_count = $ret[0]['c'];

$sql = "SELECT COUNT(*) as c FROM songs where syncmp3 = 0";
$ret = $mysql->getData( $sql );
$to_syncmp3_count = $ret[0]['c'];

$mysql->closeDb();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta name="author" content="Codefor">
    <meta name="keywords" content="doubandiantai,doubanfm,电台,移动,app,音乐,智能,推荐,豆瓣FM,豆瓣,FM,豆瓣电台," />
	<meta name="description" content="豆瓣7台 是基于豆瓣FM的你专属的个性化音乐收听工具。它简单方便，打开就能收听。在收听过程中，你可以用“红心”、“垃圾桶”、“循环”、
“重放”、“跳过”等操作 告诉 豆瓣7台 你的喜好。豆瓣7台 将在豆瓣FM的基础上，根据你的操作和反馈，从海量曲库中自动发现并播出符合你音乐口味的歌曲。" />
    <link rel="shortcut icon" href="http://douban.fm/favicon.ico" type="image/x-icon">

    <title>数据统计 - 豆瓣7台</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
	<style type="text/css">
        /* Move down content because we have a fixed navbar that is 50px tall */
        body {
          padding-top: 50px;
          padding-bottom: 20px;
        }
    </style>
      
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

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">豆瓣7台</a>
        </div>
        <div class="navbar-collapse collapse">
          <form class="navbar-form navbar-right" role="form" action="#" method="POST">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control" name="alias">
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control" name="form_password">
            </div>
            <button type="submit" class="btn btn-success" name="user_login">Sign in</button>
          </form>
        </div><!--/.navbar-collapse -->
        <?=$username?>
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Hello, 豆瓣7台!</h1>
          <p>豆瓣7台 是基于豆瓣FM的你专属的个性化音乐收听工具。它简单方便，打开就能收听。在收听过程中，你可以用“红心”、“垃圾桶”、<b>“循环”</b>、
              <b>“重放”</b>、“跳过”等操作 告诉 豆瓣7台 你的喜好。豆瓣7台 将在豆瓣FM的基础上，根据你的操作和反馈，从海量曲库中自动发现并播出符合你音乐口味的歌曲。</p>
          <p><a class="btn btn-primary btn-lg" role="button" href="/">Start &raquo;</a></p>
      </div>
    </div>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-md-4">
          <h2>歌曲总数</h2>
          <p><?=$song_count?></p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>专辑总数</h2>
          <p><?=$album_count?></p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>歌手总数</h2>
          <p><?=$artist_count?></p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>待同步总数</h2>
          <p><?=$to_syncmp3_count?></p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
      </div>

      <hr>

      <footer>
        <p>&copy; Codefor 2013</p>
      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>