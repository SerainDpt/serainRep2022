<?php
//header('Content-Type: application/json; charset=utf-8');
$name = $_POST["username"]; // 取得欄位值

//-----------connect資料庫-----------------//
$db=mysqli_connect("localhost","root","@567-ygv-bnm@");
if(!$db)
    die("無法連線伺服器".mysqli_connect_errno());
$db_select=mysqli_select_db($db,"ordering_system"); 
if(!$db_select)
    die("無法選擇資料庫".mysqli_connect_errno());      
mysqli_query( $db, "SET NAMES 'utf8'");// 設定連線編碼


$sql = "SELECT guest_id FROM guest WHERE guest_id = '".$name."'";
$result=mysqli_query($db,$sql);
$num=mysqli_num_rows($result); // 取得記錄數 
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
  
if ($num == 0) {  // 是否有此記錄
  $check = "可以使用";
} 
else {
  $check = "此帳號已有人使用";
}

echo json_encode(array('returned_val' => $check));



mysqli_close($db);
?> 
