<?php


//-----------connect資料庫-----------------//

header('Content-Type: application/json; charset=utf-8');
$name = $_POST["username"]; // 取得欄位值
$sqlerr="";
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

//搜尋取餐資訊
$sql= "SELECT guest_address,guest_phone FROM guest WHERE guest_id='".$name."'";                        
$result=mysqli_query($db,$sql);

if(mysqli_num_rows($result)>0)
{ 
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    //substr_replace($row["guest_address"],'',-1);
    $d_address=$row["guest_address"];
    $d_phone=$row["guest_phone"];                     
}
else
    $d_address='請確認外送地址';
echo json_encode(array('外送地址' => $d_address));
mysqli_close($db);

?>