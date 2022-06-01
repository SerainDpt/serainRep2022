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

</style>
<?php

session_start();
$user_id=$_SESSION["username"];

if(empty($_SESSION['username'])){
        
  session_unset();
  session_destroy();
  header('Location: startpage.html');
  exit;
      }

$result = "";


//-----------存入資料庫-----------------//
$sqlerr="";
$db=mysqli_connect("localhost","root","@567-ygv-bnm@");
if(!$db)
{die("無法連線伺服器".mysqli_error());}

$db_select=mysqli_select_db($db,"ordering_system"); 
if(!$db_select)
{die("無法選擇資料庫".mysqli_error());}
// 設定連線編碼
mysqli_query( $db, "SET NAMES 'utf8'");

//產生新的訂單流水編號
$sql= "SELECT order_id FROM takeinfomation ORDER BY order_id DESC";
$result=mysqli_query($db,$sql);
$row=mysqli_fetch_array($result,MYSQLI_NUM);

$newitemnumber=0;

if(empty($row[0]))
{
    $lastitemnumber=0;
    $t=time();
    $today=(int)date("Ymd",$t);
    $newitemnumber= $today*10000 + $lastitemnumber +1;
}
else
{
    $t=time();
    $today=(int)date("Ymd",$t);
    $tmpnmuber=(int)substr($row[0] , 8 , 4 );
    $newitemnumber=  $today*10000 +$tmpnmuber+1;
}


       //cookie中取出取餐資訊
       $arr1= json_decode($_COOKIE['userpickway'], true);
       $userdata=$arr1[0];
       $usertime=$arr1[1];
       $newpickway=$arr1[2];
       $sum= (int)$_COOKIE['currentsum'];

       if(isset($_COOKIE['currentphone']))
          $currentphone= $_COOKIE['currentphone'];
      
        //有地址有電話
       if(isset($_COOKIE['currentaddress']) && !empty($_COOKIE['currentaddress']) && isset($_COOKIE['currentphone']) && !empty($_COOKIE['currentphone']))
       {
         $currentaddress= $_COOKIE['currentaddress'];
         $currentphone= $_COOKIE['currentphone'];
         $sql_takeinfomation="INSERT INTO takeinfomation (takeway,takedate,taketime,totalsum,order_id,delivery_add,delivery_pho,guest_id)
         VALUES ('".$newpickway."','".$userdata."', '".$usertime."','$sum','$newitemnumber','$currentaddress','$currentphone','".$user_id."')";
        }
        
      //有電話沒有地址
       if(isset($_COOKIE['currentphone']) && !empty($_COOKIE['currentphone']) && !isset($_COOKIE['currentaddress']))
       { 
         $sql_takeinfomation="INSERT INTO takeinfomation (takeway,takedate,taketime,totalsum,order_id,delivery_add,delivery_pho,guest_id)
         VALUES ('".$newpickway."','".$userdata."', '".$usertime."','$sum','$newitemnumber','-','$currentphone','".$user_id."')";
       }
       

       mysqli_query($db,$sql_takeinfomation)
       or die(mysqli_error($db));




//取出當前選購商品數量的cookie
if(isset($_COOKIE['currentnumitem']))
{

//取出選購商品數量數值
$numitem=$_COOKIE['currentnumitem'];

 //建立迴圈,依序從選購商品順序:1,開始列印出detail,直到超出當前商品數量時,結束迴圈
for($a=1 ; $a<=$numitem ;$a++)
 {
      
      if(isset($_COOKIE[$a]))
      { 
            $arr= json_decode($_COOKIE[$a], true);           
            //若arr[0]!=0的狀況是該筆項目沒有被刪除,因若刪除的話,改筆cookie值的$arr[0]=0
            if($arr[0]!='0')
            {
              $stack_item=(int)$arr[0];
              $mealid=(int)$arr[1];
              $quantity=(int)$arr[2];
              

              $sql_oderlist="INSERT INTO orderlist (ordernum,meal_id,order_id,stack_number)
              VALUES ('$quantity', '$mealid','$newitemnumber','$stack_item')";

               mysqli_query($db,$sql_oderlist)
               or die(mysqli_error($db));

                }
              
         }
        
         //清除cookie
         setcookie($a, null, -1,'/');
         unset($_COOKIE[$a]);
}
       

  }


 


  mysqli_close($db);

  setcookie("currentnumitem", null, -1,'/');
  unset($_COOKIE['currentnumitem']);
  setcookie("currentsum", null, -1,'/');
  unset($_COOKIE['currentsum']);
  setcookie("userpickway", null, -1,'/');
  unset($_COOKIE['userpickway']);
  setcookie("userpickway", null, -1,'/');
  unset($_COOKIE['userpickway']);
  setcookie("currentaddress", null, -1,'/');
  unset($_COOKIE['currentaddress']);
  setcookie("currentphone", null, -1,'/');
  unset($_COOKIE['currentphone']);

?>
</head>

<body>

    <!--首頁-->
<div data-role="page"  class="ui-page ui-body-c"> 
    <div data-role="header">
       <h1>Restaurant</h1> 
    </div>

    <div  data-role="content">
      <div class="ui-body ui-body-a ui-corner-all">
        <h3>訂購處理中</h3>
            <p >
                    處理中，請稍後····
            </p> 
      </div>     

    </div>

 <?php echo $sqlerr ?>



<script language="JavaScript">
function myrefresh()
{
  window.location.href="endpage.php";
}
setTimeout('myrefresh()',1000); //指定1秒刷新一次
</script>




</div>

</body>
</html>