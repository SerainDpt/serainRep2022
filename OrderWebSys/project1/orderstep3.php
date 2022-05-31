<!DOCTYPE html>
<html> 
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Restaurant</title>
<link rel="stylesheet" href="jquery.mobile-1.4.5.min.css">
<link rel="stylesheet" href="css/themes/planBtheme.css">
<link rel="stylesheet" href="css/themes/jquery.mobile.icons.min.css">
<script src="jquery-1.x-git.min.js"></script>
<script src="jquery.mobile-1.4.5.min.js"></script>
<script src="js.cookie.js"></script>

<style>
.custom-select 
{
  position: relative;
  font-family: Arial;
  left: 20px;
}
.button 
{
  position: fixed;
  top: 0px;
  right: 0px;
  font-size: 12px; 
  padding: 0px 2px;
}
</style>
</head>
<body>


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
$result = "";
?>


<div data-role="page" id="reference" data-add-back-btn="true">
  <div data-role="header" data-theme="b" >
  <button onclick="goBack()">返回</button>
     <h1>結帳</h1>
     <a href="#popupNested" data-rel="popup" class="ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-bars" style="height:20px;" data-transition="slidefade"></a>
        <div data-role="popup" id="popupNested" data-theme="none">
                <ul data-role="listview"  data-inset="true">
                    <li><a href="searchmain.php"  data-ajax="false">查詢訂單</a></li>
                    <li><a href="enterpwpage.php"  data-ajax="false">個人資料修改</a></li>
                    <li><a href="logout.php"  data-ajax="false">登出</a></li>
                </ul>   
        </div>  

     </div>


     <div  style='width:200px;padding-top:20px;padding-left:20px;'>
      <ul data-role="listview" data-inset="true" data-theme="c">
          <li data-role="list-divider">Guest</li>
          <li><?php echo $user_id ?></li>
        </ul>
    </div>
  <div data-role="content">

    <ul data-role="listview" data-inset="true" data-theme="a">
        <!-- data-role="list-divider" 表示是一個分隔項目 -->
      <li data-role="list-divider">購買清單</li>
        
            
          
<?php

$db=mysqli_connect("localhost","root","@567-ygv-bnm@");
if(!$db)
{
  die("無法連線伺服器".mysqli_error());
}
$db_select=mysqli_select_db($db,"ordering_system"); 
if(!$db_select)
{
  die("無法選擇資料庫".mysqli_error());
}
// 設定連線編碼
mysqli_query( $db, "SET NAMES 'utf8'");
$arr="";$sqlerr="";

if(isset($_COOKIE['userpickway']))
{
    $arr= json_decode($_COOKIE['userpickway'],true);
    
    if(isset($_COOKIE['currentaddress']))
        $arr2= $_COOKIE['currentaddress'];

    if(isset($_COOKIE['currentphone']))
        $arr3= $_COOKIE['currentphone'];
        
    if($arr[2]=='外帶')
    {  
        echo "<li id='userdetail'>";                                                       
        echo "<h3>"."您的取餐方式: ".$arr[2]."</br>".
              "取餐時間: ".$arr[0]." / ".$arr[1]."</br>".
              "聯絡號碼: "."</br>".$arr3."</h3></li>";
    }  
    else
    {
      echo "<li id='userdetail'>";                                                       
      echo "<h3 >"."您的取餐方式: ".$arr[2]."</br>".
            "外送抵達時間: ".$arr[0]." / ".$arr[1]."</br>";
            
      if(strlen($arr2)<=17)   
        echo "外送地址: "."</br>".$arr2."</br>";
      else
        echo "外送地址: "."</br>".substr($arr2, 0, 18)."</br>".substr($arr2, 18, strlen($arr2)-17)."</br>".
              "聯絡號碼: "."</br>".$arr3."</h3></li>";
    }         
}

$arr2="";
//取出當前選購商品數量的cookie
if(isset($_COOKIE['currentnumitem']))
{

    //取出當前選購商品數量數值
    $numitem=$_COOKIE['currentnumitem'];
    //建立迴圈,依序從選購商品順序:1,開始列印出detail,直到超出當前商品數量時,結束迴圈
    for($a=1 ; $a<=$numitem ;$a++)
    {
        if(isset($_COOKIE[$a]))
            $arr2= json_decode($_COOKIE[$a], true);
        //若arr[0]!=0的狀況是該筆項目沒有被刪除,因若刪除的話,改筆cookie值的$arr[0]=0
        if(isset($arr2) && $arr2[0]!='0')
        {
          //meal資料表中查詢餐點名稱
          $tmp=$arr2[1];
          $sql= "SELECT meal_name FROM meal WHERE meal_id='".$tmp." '";
          if(!mysqli_query($db,$sql))
          {
            $sqlerr.="FAIL".mysqli_error();
          }

          $result=mysqli_query($db,$sql);
          $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
          $meal_name=$row["meal_name"];

      //$listid='listid'.$a;
        //開始一項list
        echo "<li id=".$a.">";              
        echo "<h3 >".$meal_name."</h3>";
        echo "<h3 style='background-color:yellow'>"."單價: ".$arr2[3]." 元  ".
              "選購份數: ".$arr2[2]." 份 </h3></li>";

      }
}
        
  }
  mysqli_close($db);
//setcookie("name", "", time()-3600);
?>
          <li id='sum'>
              <?php
              if(isset($_COOKIE['currentsum']))
              {
                $sum= $_COOKIE['currentsum'];
                echo "<h2>總金額</h2>";
                echo "<h3 style='background-color:yellow'>".$sum."元 </h3>";
              }
              ?>
          </li>
    </ul>

          <div data-role="fieldcontain" >
            <a href="#" data-role="button" id="send" name="send">確認送出</a>
          </div>
    <script>

function goBack() 
{
  window.history.back();
}
$(document).ready(
  function()
  {
      // 點選button行為
      $('a#send').click(
        function(event) 
        {
            window.location.href="saveorderlist.php";
        }
      );
  }
);



</script>

  </div>
</div>
</body>
</html>
