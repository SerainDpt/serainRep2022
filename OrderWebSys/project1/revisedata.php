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


  
  $email=$_POST["email"];  
  $phone=$_POST["phone"];
  $name=$_POST["user_name"];
  $address=$_POST["address"];



$sql= "UPDATE guest SET guest_email='". $email."',guest_phone='".$phone."',guest_address='".$address."',guest_name='".$name."'
        WHERE guest_id='".$user_id."'";

mysqli_query($db,$sql)
or die(mysqli_error($db));


echo '<script language="javascript">';
echo 'alert("已更新")';
echo '</script>'; 
        }


$sql2= "SELECT * FROM guest WHERE guest_id='".$user_id."'";

$result=mysqli_query($db,$sql2);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
   

$oldname=$row['guest_name'];
$oldmail=$row['guest_email'];
$oldphone=$row['guest_phone'];
$oldaddress=$row['guest_address']; 

mysqli_close($db);
?>

<div data-role="page" id="revisepage">
  <div data-role="header">
  <!-- <a href="javascript:history.back()" data-role="button" id="search" name="search" data-ajax="false">返回</a>-->
  <a href="<?php echo $pre_url?>" data-role="button" id="search" name="search" data-ajax="false">返回</a>
  
  <h1>個人資料修改</h1>
  </div>
  <div data-role="content">
  <div style="color: red"><?php echo $error ?></div>
    <form  method="post" action="" data-ajax="false">

      <div data-role="fieldcontain">  
       <a href='changepw.php' data-role='button' id='send' name='send' >更改密碼</a>
      </div> 

      <div data-role="fieldcontain">
          <label for="user_name">用戶姓名:</label>    
          <input type="text" name="user_name" id="user_name" value="<?php echo $oldname ?>" />
      </div>
      <div data-role="fieldcontain">
          <label for="email">信箱:</label>    
          <input type="email" name="email" id="email" value="<?php echo $oldmail ?>" />
      </div>
      <div data-role="fieldcontain">
          <label for="phone">手機號碼:</label>    
          <input type="text" name="phone" id="phone" value="<?php echo $oldphone ?>"  />
      </div> 
      <div data-role="fieldcontain">
          <label for="phone">常用地址:</label>    
          <input type="text" name="address" id="address" value="<?php echo $oldaddress ?>"  />
      </div> 
      <div data-role="fieldcontain">  
      <button type="submit" disabled="" name="send" id="send" class="btn" >修改</button>
      </div>  
    </form>


  </div>

<script>
$(document).ready(function() {


  var pw;
  var flag_c,flag_d,flag_e,flag_f;


/*-------------------------處理用戶姓名-------------------------------------*/

    $('input[name=user_name]').blur( function() {
       // 取得表單欄位值     
       if($(this).val().length <= 0){ 
        $('input[name=user_name]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">請填入姓名</span>');
        flag_c=0;
    }   
      else
      flag_c=1;  
           event.stopPropagation();

           if(flag_c==0 || flag_d==0 || flag_e==0)
               $('button#send').attr('disabled', 'disabled');   
            else
                  $('button#send').removeAttr("disabled");

    });

    $('input[name=user_name]').focus( function() {
       // 取得表單欄位值
     
       $('input[name=user_name]').parent().next('span').remove();

       event.stopPropagation();
    });


   /*-------------------------處理mail-------------------------------------*/
   function IsEmail(email) { 
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
      return false;
    }
    else{
      return true;
    }
    }

   $('input[name=email]').blur( function() {
       
       $Emailchecking=IsEmail($(this).val());
       if($Emailchecking==false)
        {
          $('input[name=email]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">請填寫正確的E-MAIL格式</span>');  
          flag_d=0;
        }
        else
        flag_d=1;

        if(flag_c==0 || flag_d==0 || flag_e==0)
               $('button#send').attr('disabled', 'disabled');   
            else
                  $('button#send').removeAttr("disabled");
        event.stopPropagation();
    });
    $('input[name=email]').focus( function() {
       // 取得表單欄位值
     
       $('input[name=email]').parent().next('span').remove();

       event.stopPropagation();
    });
    

   /*-------------------------處理手機電話-------------------------------------*/
   
   function Iscellphone(phone) { 
    var regex = /^09\d{8}$/;
    if(!regex.test(phone)) {
      return false;
    }
    else{
      return true;
    }
    }

    $('input[name=phone]').blur( function() {
       
       $phonechecking=Iscellphone($(this).val());
       if($phonechecking==false)
        {$('input[name=phone]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">請填寫正確格式</span>');  
          flag_e=0;
        }
        else
         flag_e=1;
        
         if(flag_c==0 || flag_d==0 || flag_e==0)
               $('button#send').attr('disabled', 'disabled');   
            else
                  $('button#send').removeAttr("disabled");

        event.stopPropagation();
    });
    $('input[name=phone]').focus( function() {
       // 取得表單欄位值
     
       $('input[name=phone]').parent().next('span').remove();

       event.stopPropagation();
    });

  /*------------------------處理地址--------------------------------- */
    $('input[name=address]').blur( function() {
       
       $address=$(this).val();
       if($address<10)
        {$('input[name=address]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">請詳細填寫常用地址</span>');  
          flag_f=0;
        }
        else
         flag_f=1;
        
         if(flag_c==0 || flag_d==0 || flag_e==0 ||flag_f==0)
               $('button#send').attr('disabled', 'disabled');   
            else
                  $('button#send').removeAttr("disabled");

        event.stopPropagation();
    });
    $('input[name=address]').focus( function() {
       // 取得表單欄位值
     
       $('input[name=address]').parent().next('span').remove();

       event.stopPropagation();
    });


 });

</script>

</div>

</body>

</html>