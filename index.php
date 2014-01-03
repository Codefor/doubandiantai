<?php
$login = false;

if(isset($_COOKIE['ck']) && isset($_COOKIE['dbcl2'])){
	$login = true;
    
    list($id,) = explode(":",trim($_COOKIE['dbcl2'],' "'));
    $ck = trim($_COOKIE['ck'],' "');
    $username = $_COOKIE['username'];
}

?>
<!DOCTYPE HTML>
<html lang="zh-CN">
    <head>
        <meta charset="UTF-8">
        <meta name="keywords" content="doubandiantai,doubanfm,电台,移动,app,音乐,智能,推荐,豆瓣FM,豆瓣,FM,豆瓣电台," />
		<meta name="description" content="doubandiantai是基于豆瓣FM的你专属的个性化音乐收听工具。它简单方便，打开就能收听。在收听过程中，你可以用“红心”、“垃圾桶”、“循环”
“重放”、“跳过”等操作 告诉doubandiantai你的喜好。豆瓣FM将根据你的操作和反馈，从海量曲库中自动发现并播出符合你音乐口味的歌曲。" />
        <meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0, maximum-scale=1.0, user-scalable=1">
        <meta name="HandheldFriendly" content="True">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <title>豆瓣FM</title>
        <style type="text/css">
            html,body {
                height:100%
            }
            body {
                margin:0;
                font:12px/1.5 arial,sans-serif
            }
            #header {
                height:50px;
                padding:0 20px;
                color:#333;
                background:#f0f3f1 url(http://img3.douban.com/f/fm/cbfa0b8eb2021d04326b28a708045f932fa016c6/pics/fm/fm_logo_50x20.png) no-repeat 20px 20px;
                -webkit-background-size:auto 20px;
                background-size:auto 20px
            }
            #header .lnk-login {
                display:inline-block;
                margin-left:4px;
                font-size:16px;
                font-family:黑体
            }
            #header .lnk-login:link,#header .lnk-login:visited,#header .lnk-login:hover,#header .lnk-login:active {
                color:#333;
                text-decoration:none
            }
            #header .login {
                float:right;
                margin-top:40px;
                height:12px;
                font-size:12px
            }
            #header .login .bd {
                position:relative;
                top:-36px;
                margin-top:18px
            }
            #content {
                margin-bottom:30px
            }
            .lnk-logout {
                margin-left:1ex
            }
            a.lnk-logout:link,a.lnk-logout:visited,a.lnk-logout:hover,a.lnk-logout:active {
                color:#aaa;
                text-decoration:none
            }
            #adslot {
                width:100%;
                height:112px;
                overflow:hidden;
                text-align:center
            }
            #adslot img {
                height:112px
            }
            #promotion {
                bottom:0;
                height:42px;
                width:100%;
                line-height:42px;
                background:-webkit-gradient(linear,0 0,0 20%,from(#d6d8d6),to(#f0f3f1));
                text-align:right
            }
            #promotion span {
                font:12px;
                color:#333;
                display:inline-block;
                margin-right:12px;
                float:right
            }
            #promotion a {
                color:#43b694;
                text-decoration:none
            }
            .player-container {
                position:relative;
                clear:both;
                margin:0 20px;
                overflow:hidden;
                margin-top:10px
            }
            .player-container .loading {
                text-align:center;
                line-height:200px
            }
            .player-container .panel {
                padding-bottom:40px;
                overflow:hidden
            }
            .player-container .cover {
                float:left;
                position:relative;
                width:120px;
                height:120px;
                margin-right:12px;
                text-align:center;
                overflow:hidden
            }
            .player-container .cover img {
                height:100%
            }
            #pause_layer {
                background:url(http://img3.douban.com/f/fm/041ba380fbaad230dfd29c8b2e18ad1098c0e28e/pics/fm/dots.png) no-repeat 0 0;
                width:120px;
                height:120px;
                z-index:99;
                position:absolute
            }
            #pause_layer .bn-play {
                opacity:.8
            }
            #pause_layer .bn-play-icon {
                position:absolute;
                top:50%;
                left:50%;
                margin:-40px 0 0 -40px;
                width:80px;
                height:80px;
                background:url(http://img3.douban.com/f/fm/ce6bb15ff20de1f1fe688ad39a82c6029c408c50/pics/fm/fm_play_bg.png) no-repeat 0 0;
                -webkit-background-size:80px auto;
                background-size:80px auto;
                cursor:pointer
            }
            .player-container .info {
                padding-top:10px;
                overflow:hidden
            }
            .bn-play {
                cursor:pointer
            }
            .bn-ban,.bn-love,.bn-loop,.bn-skip,.bn-backward {
                position:absolute;
                top:0;
                width:34px;
                height:30px;
                overflow:hidden;
                line-height:25em;
                background:url(http://img3.douban.com/f/fm/928c0f341f6465be853dacc0e718d3aa66ed8128/pics/fm/fm_controls_320.png) no-repeat 0 0;
                -webkit-background-size:42px 300px;
                background-size:42px 300px
            }
            .bn-ban,.bn-ban-disable {
                width:28px;
                height:36px
            }
            .bn-loop,.bn-loop-active{
                width:20px;
                height:20px;   
            }
            .bn-loop-active {
                border: 5px #FD0000 solid !important;
            }
            .bn-skip,.bn-skip-disable,.bn-backward,.bn-backward-disable {
                width:42px;
                height:24px
            }
            .controls {
                position:relative;
                width:300px;
                height:40px;
                margin:auto
            }
            .bn-love {
                left:10%;
                margin:2px 0 0 -13px
            }
            .bn-loop {
                left:24%;
                margin:2px 0 0 2px;
                background-position:1000px 1000px;
                border: 5px #5E5C5C solid; 
                border-radius: 100px; 
                -webkit-border-radius: 100px; 
                -moz-border-radius: 100px; 
            }
            .bn-skip {
                right:10%;
                margin:6px -6px 0 0  
            }           
            .bn-backward {
                right:26%;
                margin:6px 3px 0 0
            }
            .bn-ban {
                left:48%;
                margin-left:-18px
            }
            .bn-love-disable{
                background-position:0 -45px
            }
            .bn-love-active {
                background-position:0 -91px
            }
            .bn-ban {
                background-position:-6px -137px
            }
            .bn-ban-disable {
                background-position:-6px -188px
            }
            .bn-skip {
                background-position:-1px -240px
            }
            .bn-backward {
                background-position:-1px -240px
            }
            .bn-skip-disable {
                background-position:-1px -278px
            }
            .process {
                position:relative;
                height:2px;
                background:#eee;
                margin-bottom:20px
            }
            .process .time {
                position:absolute;
                right:0;
                bottom:-20px;
                color:#a2a2a2
            }
            .process i {
                display:block;
                width:0;
                height:2px;
                background:#9dd6c5;
                -webkit-transition:width .5s;
                transition:width .5s
            }
            .artist {
                font-size:24px;
                line-height:1.2;
                display:block;
                margin-bottom:14px
            }
            .song {
                line-height:2;
                font-size:14px;
                color:#43b694;
                line-height:1.2
            }
            .loading-bar {
                position:absolute;
                top:0;
                left:50%;
                padding:2px 5px;
                margin-left:-50px;
                font-size:12px;
                color:#999;
                background:#fff999
            }
            #login-panel {
                height:0;
                overflow:hidden;
                background:#333;
                -webkit-transition:height .5s ease-out;
                transition:height .5s ease-out;
                -webkit-box-shadow:0 0 5px 2px #000;
                box-shadow:0 0 5px 2px #000
            }
            .landscape .player-container .panel {
                padding:10px 0 40px
            }
            @media screen and (-webkit-min-device-pixel-ratio:2) {
                #header {
                	background-image:url(http://img3.douban.com/f/fm/9290a15e6927217fcc576aea262f4059112cf16a/pics/fm/fm_logo_101x39.png)
                }
                .bn-ban,.bn-love,.bn-skip {
                    background-image:url(http://img3.douban.com/f/fm/b84df43184b966752f83fb1afe49b81cf97cb991/pics/fm/fm_controls_640.png)
                }
            }
            .flipx {
                -moz-transform:scaleX(-1);
                -webkit-transform:scaleX(-1);
                -o-transform:scaleX(-1);
                transform:scaleX(-1);                
                filter:FlipH;/*IE*/
            }            
            .flipy {
                -moz-transform:scaleY(-1);
                -webkit-transform:scaleY(-1);
                -o-transform:scaleY(-1);
                transform:scaleY(-1);                
                filter:FlipV;/*IE*/
            }
        </style>
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="http://img3.douban.com/pics/fm/fm_logo_114x114.png" />
        <link rel="apple-touch-icon-precomposed" href="http://img5.douban.com/pics/fm/fm_logo_57x57.png" />
        <link rel="shortcut icon" href="http://douban.fm/favicon.ico" type="image/x-icon">
    </head>

    <body>
        <div id="header">
            <div class="login">
                <div class="bd">                   
                    收听私人兆赫
                &gt;<a href="#" onClick="ga('send', 'event', 'User', 'click', 'login');" class="lnk-login">登录</a>                    
                </div>
            </div>
        </div>


        <div id="content">
            <audio id="player" autoplay>
              抱歉，目前不支持您的浏览器。
            </audio>
        </div>

        <div id="promotion">
            
            <span>豆瓣FM for Me Beta
            | <a href="http://m.douban.com/fm/download" target="_blank">关于我们</a>
            | <a href="/statement" target="_blank">免责声明</a>
            </span>
        </div>

        <script id="tmpl-player-loading" type="text/html">
        <div id="fm-player-container" class="player-container">
            <div class="loading">正在加载中....</div>
        </div>
        </script>

        <script id="tmpl-player" type="text/html">
          <div class="panel">
            <div class="cover">
              <a href="{%=album%}" target="_blank" class="bn-pause"><img src="{%=picture%}" title="{%=albumtitle%}"></a>
            </div>
            <div id="pause_layer">
              <div class="bn-play-icon"></div>
            </div>
            <div class="info">
              <span class="artist">{%=artist%}</span>
              <span class="song">{%=title%}</span>
              <div class="process">
                <span class="time">00:00</span><i></i>
              </div>
            </div>
          </div>
          <div class="controls">
              {% if(like == '1'){ %}
              <a href="#love" onClick="ga('send', 'event', 'Audio', 'click', 'love-off');" class="bn-love bn-love-active" title="喜欢">love</a>
              {% } else if (subtype == 'T') { %}
              <a href="#love" class="bn-love bn-love-disable" title="喜欢">love</a>
              {% } else { %}
              <a href="#love" onClick="ga('send', 'event', 'Audio', 'click', 'love-on');" class="bn-love" title="喜欢">love</a>
              {% } %}
              
              {% if(loop){ %}
              <a href="#loop" onClick="ga('send', 'event', 'Audio', 'click', 'loop-off');" class="bn-loop bn-loop-active" title="单曲循环">loop</a>
              {% } else { %}
              <a href="#loop" onClick="ga('send', 'event', 'Audio', 'click', 'loop-on');" class="bn-loop" title="单曲循环">loop</a>
              {% } %} 			  
              
              {% if(!login || subtype == 'T'){ %}
              <a href="#ban" class="bn-ban bn-ban-disable" title="">ban</a>
              {% } else { %}
              <a href="#ban" onClick="ga('send', 'event', 'Audio', 'click', 'ban');" class="bn-ban">ban</a>
              {% } %}
                            

			  <a href="#skip" onClick="ga('send', 'event', 'Audio', 'click', 'skip');" class="bn-skip" title="跳过">skip</a>    
              <a href="#backward" onClick="ga('send', 'event', 'Audio', 'click', 'backward');" class="bn-backward flipx" title="REPLAY">backward</a>
          </div>
        </script>


      <script id="tmpl-song-loading" type="text/html">
          <div id="song-loading" class="loading-bar">正在加载歌曲...</div>
      </script>

      <script id="tmpl-login" type="text/html">
          <div id="login-panel">
              <iframe src="html5_login" width="100%" height="100%" frameborder="0" scrolling="no" allowtransparency="true"></iframe>
          </div>
      </script>

      <script id="tmpl-user-name" type="text/html">
          <div class="login">
              <div class="bd">
              {%=name%}的私人兆赫
              <a href="/partner/logout?source=radio&ck={%=ck%}&no_login=y" onClick="ga('send', 'event', 'User', 'click', 'logout');" class="lnk-logout">退出</a>
              </div>
          </div>
      </script>

      <script type="text/javascript" src="http://doubandiantai.sinaapp.com/js/player.js?v=20140101"></script>
    <script>
        <?
        if($login){
            echo sprintf('$.user.set({id: %d,name: "%s",ck: "%s"});',$id,$username,$ck);
        }		
        ?>
        $.source.set("uc_html5");
        var p =[127, 119, 114, 131, 13, 129, 71, 156, 157, 16, 70, 81, 15, 22, 77, 52, 72, 133, 145, 27, 118, 146, 125, 137, 132, 141, 35, 138, 23, 4, 150, 140, 29, 78, 115, 169, 5, 164, 117, 170, 121, 128, 83, 147, 102, 113, 134, 130, 28, 136, 159, 98, 9, 10, 61, 106, 94, 17, 46, 69, 135, 110, 2, 160, 163, 161, 7, 126, 76, 66, 18, 3, 168, 20, 73, 82, 1, 124, 167, 149, 8, 162, 123, 6, 32, 85, 42, 116, 122, 120, 166, 14, 139];
        $.playlist.setChannelId(Math.random() < 0.9 ? 0:p[Math.round(Math.random()*p.length)]);
    </script>
        
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-46670605-2', 'sinaapp.com');
      ga('send', 'pageview');

	</script>
        
    <span style="display:none">
        <script type="text/javascript">
            
        </script>
    </span>
</body>
</html>
