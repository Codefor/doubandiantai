<?php
list($ROOT,) = explode($_SERVER['HTTP_APPNAME'],dirname(__FILE__));
include_once(sprintf("%s%s/%s/inc/function.php",$ROOT,$_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_APPVERSION']));

function login($doubanurl,$cookies,$postdata){
    $curl = doubanCurl($doubanurl);

    curl_setopt($curl, CURLOPT_HTTPHEADER,array('Content-Type: application/x-www-form-urlencoded')); 
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_COOKIE, $cookies);
    curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
    
    curl_setopt($curl, CURLOPT_REFERER, "http://douban.fm/html5_login");

    $raw_data = curl_exec($curl);

    curl_close($curl);
    return $raw_data;
}

if(isset($_POST) && !empty($_POST)){
    $postdata = "";
    foreach($_POST as $k=>$v){
       $postdata .= sprintf("%s=%s&",$k,urlencode($v));
   	}    
	$postdata = rtrim($postdata,'&');
    
    $raw_data = login(LOGIN_URL,formatCookie(),$postdata);
    
    list($header,$body) = explode("\r\n\r\n", $raw_data, 2);
    
    setDoubanCookie($header);
    
    $body = str_replace("\r","",$body);
    $body = str_replace("\n","",$body);
    $clean_body = preg_replace('/<script>var _check_hijack.*?<\/script>/','',$body);
    
    preg_match('/switchUser\((.*?)\)/',$clean_body,$match);
	$j = json_decode($match[1]);
    header(sprintf("Set-Cookie: username=%s; expires=%s; path=/; domain=.doubandiantai.sinaapp.com",$j->name,gmstrftime("%A, %d-%b-%Y %H:%M:%S GMT", time() + (86400 * 365))),false);
    
    echo $clean_body;
    exit();
}
?>

<!DOCTYPE HTML>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
    <style>
    
body,fieldset,label { padding:0;margin:0;  }
body { font:12px/1.5 arial,sans-serif;width:300px;padding-top:20px;margin:auto;background:#333; }
fieldset { border:none; }
input { -webkit-appearance:none;-webkit-border-radius:none;border:none;background:#fff; }
legend { font-size:16px;color:#999; }
label { display:block;color:#eee; }
.bn  { margin-top:10px;padding:5px 30px; }
.basic-input { width:280px;padding:10px;font-size:14px;  }
.item { margin-top:10px; }
.submit-item { overflow:hidden;text-align:right; }
.submit-item .bn-submit { float:left;background:#a5e0ca; }
.item-error { color:#eee; }
.item-error li { list-style-position:outside; }
#register_text { color: #EEE; }
#register_text a { color: #43B694; text-decoration: none; }

    </style>
</head>
<body>
  <form action="/html5_login" method="POST"><div style="display:none;"><input type="hidden" name="ck" value="rNnK"/></div>
    <fieldset>
        <legend>登录豆瓣</legend>


        <input type="hidden" value="y" name="remember" id="remember">

        <div class="item">
          <label for="alias">邮箱/用户名</label>
          <input type="text" value="" maxlength="60" class="basic-input" name="alias" id="email">
        </div>

        <div class="item">
          <label for="password">密码</label>
          <input type="password" maxlength="20" class="basic-input" name="form_password" id="password">
        </div>

        <div class="item submit-item">
          <input type="submit" class="bn bn-submit" name="user_login" value="登录">
          <input type="button" class="bn bn-cancel" id="bn-cancel" value="取消">
        </div>
        <input type="hidden" value="" name="from">
    </fieldset>
  </form>

  <p id="register_text">还没有豆瓣帐号？<a href="http://douban.fm/mobile/register" target="_blank">立即注册</a></p>
  <script>
      document.getElementById('bn-cancel').onclick = function() {
          parent.$.ui.switchUser();
      };
  </script>

</body>
</html>



