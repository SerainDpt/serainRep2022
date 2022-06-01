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

//返回前一個page,先取得前一個page網址並存入session中

//密碼輸入錯誤返回原page
if( $_SERVER['HTTP_REFERER']=='http://localhost:8080/project1/enterpwpage.php' )
    {
      $pre_url=$_SESSION["pre_url"];
    }
//從revisedata.php進入
else if( $_SERVER['HTTP_REFERER']=='http://localhost:8080/project1/revisedata.php')
    {

        $pre_url=$_SESSION["pre_url"]; 
    }
//從其他page進入
else
{
    $pre_url=$_SERVER['HTTP_REFERER'];
    $_SESSION["pre_url"]=$_SERVER['HTTP_REFERER'];
  }

$user_id=$_SESSION["username"];
if(!isset($_SESSION['username']))
{
    session_unset();
    session_destroy();
    header('Location:startpage.html');
    exit;
}

$error = ""; $sqlerr="";
if(isset($_POST["send"]))
{
    $pw=$_POST["user_pw"];
    if (empty($pw)) 
    {     
        $error = "請輸入密碼<br/>";// 欄位沒填
    }
    else 
    { 
          // 表單處理
        //-----------connect資料庫-----------------//
        $db=mysqli_connect("localhost","root","@567-ygv-bnm@");
        if(!$db)
            die("無法連線伺服器".mysqli_connect_errno());
        $db_select=mysqli_select_db($db,"ordering_system"); 
        if(!$db_select)
            die("無法選擇資料庫".mysqli_connect_errno());      
        mysqli_query( $db, "SET NAMES 'utf8'");// 設定連線編碼

        $sql= "SELECT * FROM guest WHERE  guest_id='".$user_id." '";
        if(!mysqli_query($db,$sql))
            $sqlerr.="FAIL".mysqli_connect_errno();
        
        $result=mysqli_query($db,$sql);
        $num=mysqli_num_rows($result);
        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

        if($row["guset_password"] == $pw)
        {      
            mysqli_free_result($result);
            header("Location:revisedata.php");
            exit();
        }
        else
        { 
            echo '<script language="javascript">';
            echo 'alert("密碼錯誤")';
            echo '</script>'; 
        } 
    }
    mysqli_free_result($db);
    mysqli_close($db);

}

?>

<div data-role="page" id="loginpage" class="ui-page ui-body-c">
  <div data-role="header">
  <a href="<?php echo $pre_url?>" data-role="button" id="search" name="search" data-ajax="false">返回</a>
  <h1>請先輸入密碼</h1>
  
  </div>
  <div data-role="content">
  <div style="color: red"><?php echo $error ?></div>
    <form method="post" action="" data-ajax="false">

      <div data-role="fieldcontain">
        <label for="user_pw">密碼:</label>    
        <input type="password" name="user_pw" id="user_pw" data-inline="true"/>
      </div>
      <div data-role="fieldcontain">  
      <input type="submit" name="send" value="送出" >
      </div>  
    </form>
    
  </div>
</div>
</body>

</html>