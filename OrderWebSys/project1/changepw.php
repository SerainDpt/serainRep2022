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
.error { float: right; color : red; }

</style>


</head>

<body>

<?php

session_start();


if(!isset($_SESSION['username'])){
        
  session_unset();
  session_destroy();
  header('Location:startpage.html');
  exit;
      }
else      
$user_id=$_SESSION["username"];

//回到最初進入page(跳過密碼輸入page)
$pre_url=$_SESSION["pre_url"];





$db=mysqli_connect("localhost","root","@567-ygv-bnm@");
if(!$db)
{die("無法連線伺服器".mysqli_error());}

$db_select=mysqli_select_db($db,"ordering_system"); 
if(!$db_select)
{die("無法選擇資料庫".mysqli_error());}
// 設定連線編碼
mysqli_query( $db, "SET NAMES 'utf8'");



$error = ""; $result =0 ; 
if(isset($_POST["send"])){

  $pw=$_POST["user_pw"];


$sql= "UPDATE guest SET guset_password ='".$pw."'WHERE guest_id='".$user_id."'";
        

mysqli_query($db,$sql)
or die(mysqli_error($db));

echo '<script language="javascript">';
echo 'alert("密碼已更改")';
echo '</script>'; 
        }


mysqli_close($db);
?>

<div data-role="page" id="changepage">
  <div data-role="header">
  <!-- <a href="javascript:history.back()" data-role="button" id="search" name="search" data-ajax="false">返回</a>-->
  <a href="<?php echo $pre_url?>" data-role="button" id="search" name="search" data-ajax="false">返回</a>
  
  <h1>個人資料修改</h1>
  </div>
  <div data-role="content">
  <div style="color: red"><?php echo $error ?></div>
    <form  method="post" action="" data-ajax="false">

      <div data-role="fieldcontain">
        <label for="user_pw">新密碼:</label>    
        <input type="password" name="user_pw" id="user_pw" placeholder="密碼長度須大於6個字元" />
      </div>
      <div data-role="fieldcontain">
        <label for="user_pw_2">再次輸入新密碼:</label>    
        <input type="password" name="user_pw_2" id="user_pw_2" />
      </div>
      <div data-role="fieldcontain"><br/><br/>     
      <button type="submit" disabled="" name="send" id="send" class="btn" >送出</button>
      </div>  
    </form>


  </div>

<script>
$(document).ready(function() {


  var flag_a,flag_b;
 



  /*-------------------------密碼處理-------------------------------------*/

  $('input[name=user_pw]').blur( function() {
       // 取得表單欄位值     
       if($(this).val().length <6 ){
       
        $('input[name=user_pw]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">密碼長度須大於6個字元</span>');
        flag_a=0;
    }   
        else{
          flag_a=1;
             pw=$(this).val();
             
        }

    
        event.stopPropagation();
    });

    $('input[name=user_pw]').focus( function() {
       // 取得表單欄位值
     
       $('input[name=user_pw]').parent().next('span').remove();

       event.stopPropagation();
    });

    $('input[name=user_pw_2]').blur( function() {
       // 取得表單欄位值     
       if($(this).val() != pw){ 
        $('input[name=user_pw_2]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">密碼不正確</span>');
        flag_b=0;
    }   
        else
        flag_b=1;
        
          if(flag_a==1 && flag_b==1)
                  $('button#send').removeAttr("disabled");
            else
                  $('button#send').attr('disabled', 'disabled');
    
          event.stopPropagation();
    });

    $('input[name=user_pw_2]').focus( function() {
       // 取得表單欄位值
     
       $('input[name=user_pw_2]').parent().next('span').remove();

       event.stopPropagation();
    });



 });

</script>

</div>

</body>

</html>