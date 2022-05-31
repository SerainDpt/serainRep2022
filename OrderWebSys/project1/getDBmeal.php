<?php


//-----------connect資料庫-----------------//

header('Content-Type: application/json; charset=utf-8');
$mealid = $_POST["mealid"]; // 取得欄位值
$sqlerr="";
$db=mysqli_connect("localhost","root","@567-ygv-bnm@");
if(!$db)
{die("無法連線伺服器".mysqli_error());}

$db_select=mysqli_select_db($db,"ordering_system"); 
if(!$db_select)
{die("無法選擇資料庫".mysqli_error());}
// 設定連線編碼
mysqli_query( $db, "SET NAMES 'utf8'");

//搜尋取餐資訊


$sql= "SELECT * FROM meal WHERE meal_id='".$mealid."'";
$result=mysqli_query($db,$sql);
//$num=mysqli_num_rows($result);
//echo $num;
//$row = mysqli_fetch_array($result, MYSQLI_NUM);
//$meal[$i] = array("meal_id"=>$row[0],"meal_name"=>$row[1] ,"price"=>$row[2]);


if(mysqli_num_rows($result)>0)
{ 
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
//substr_replace($row["guest_address"],'',-1);
$price=$row["price"];
//$d_phone=$row["guest_phone"];                     
}
else
$price='error';


echo json_encode(array('price' => $price));



mysqli_close($db);

?>