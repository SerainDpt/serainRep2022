<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width ,initial-scale=1">
<title>Restaurant</title>
<link rel="stylesheet" href="jquery.mobile-1.4.5.min.css">
<link rel="stylesheet" href="css/themes/planBtheme.css">
<link rel="stylesheet" href="css/themes/jquery.mobile.icons.min.css">
<script src="jquery-1.x-git.min.js"></script>
<script src="jquery.mobile-1.4.5.min.js"></script>
<script src="js.cookie.js"></script>
<script>
//$.mobile.hidePageLoadingMsg();
//$('body').removeClass('ui-loading');
</script>

<style>
.ui-page.ui-body-c {
    background: url(picture/bg.jpg);
    background-repeat:no-repeat;
    background-position:center center;
    background-size:cover;  
}
.button {
  
  float: right;
  font-size: 12px;
  top:-40px;
  height:20px; 
  margin: 0px;

}
</style>
<?php

session_start();
$user_id=$_SESSION["username"];

if(empty($_SESSION['username']))
{    
  session_unset();
  session_destroy();
  header('Location: startpage.html');
  exit;
}

?>
</head>

<body>

    <!--首頁-->
<div data-role="page"  class="ui-page ui-body-c"> 
    <div data-role="header">
       <h1>Restaurant</h1> 
    </div>

    <div class="button">
     <a href="#popupNested" data-rel="popup" class="ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-bars button"  data-transition="slidefade"></a>
    </div>

    <div data-role="popup" id="popupNested" data-theme="none">
            <ul data-role="listview"  data-inset="true">
                <li><a href="searchmain.php"  data-ajax="false">查詢訂單</a></li>
                <li><a href="enterpwpage.php"  data-ajax="false">個人資料修改</a></li>
                <li><a href="logout.php"  data-ajax="false">登出</a></li>
            </ul>   
    </div>

    <div  data-role="content">
      <div class="ui-body ui-body-a ui-corner-all">
        <h3>感謝您的訂購</h3>
            <p >
                    使用會員訂購餐點，可享會員 專屬優惠
                    並可不定期收到最新優惠資訊！
            </p> 
      </div>     

    </div>
</div>

</body>
</html>