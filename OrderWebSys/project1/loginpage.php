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

.ui-page.ui-body-c {
    background: url(picture/bg.jpg);
    background-repeat:no-repeat;
    background-position:center center;
    background-size:cover;  
}
</style>


</head>

<body>

<?php
session_start();

$error = ""; $sqlerr="";
if(isset($_POST["send"])){

  $id=$_POST["user_id"];
  $pw=$_POST["user_pw"];


if(empty($id)) 
{ // 欄位沒填
    $error = "帳號為必填欄位<br/>";
}
else if(empty($pw))  
{ 
    // 欄位沒填
    $error .= "密碼為必填欄位<br/>";
} 
else 
{ 
    // 表單處理
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

    $sql= "SELECT * FROM guest WHERE  guest_id='".$id." '";
    if(!mysqli_query($db,$sql))
    {
      $sqlerr.="FAIL".mysqli_error();
    }

    $result=mysqli_query($db,$sql);
    $num=mysqli_num_rows($result);
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

    if($num>0)
    {
        if($row["guset_password"] == $pw)
        {    
            $sqlerr.="success";
            $_SESSION["username"]=$id;
            mysqli_free_result($db);
            header("Location:orderstep1.php");
            exit();
        }
        else
        { 
          echo '<script language="javascript">';
          echo 'alert("密碼錯誤")';
          echo '</script>'; 
        } 
    }
    else 
    {
      
      echo '<script>';
      echo 'alert("帳號不存在")';
      echo '</script>';
    
    }

    mysqli_free_result($db);
    mysqli_close($db);

}
}


else
{
    $id="";$pw="";
}

?>

<div data-role="page" id="loginpage" class="ui-page ui-body-c">
  <div data-role="header">
  <a href="startpage.html" data-role="button"  data-ajax="false">返回</a>
  <h1>會員登入</h1>
  </div>
  <div data-role="content">
  <div style="color: red"><?php echo $error ?></div>
    <form method="post" action="" data-ajax="false">
      <div data-role="fieldcontain">
        <label for="user_id">帳號:</label>
        <input type="text" name="user_id" id="user_id" value="<?php echo $id ?>"/>
      </div>
      <div data-role="fieldcontain">
        <label for="user_pw">密碼:</label>    
        <input type="password" name="user_pw" id="user_pw" data-inline="true"/>
      </div>
      <div data-role="fieldcontain">  
      <input type="submit" name="send" value="登入" >
      </div>  
    </form>
  </div>
</div>
</body>

</html>