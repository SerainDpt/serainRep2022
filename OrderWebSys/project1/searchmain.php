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

<?php

session_start();

$user_id=$_SESSION["username"];
if(!isset($_SESSION['username']))
{
  session_unset();
  session_destroy();
  header('Location: startpage.html');
  exit;
}
 
//返回前一個page
if( $_SERVER['HTTP_REFERER']!='http://localhost:8080/project1/searchmain.php' )
{
    $pre_url=$_SERVER['HTTP_REFERER'];
    $_SESSION["pre_url"]=$_SERVER['HTTP_REFERER'];
}
else
    $pre_url= $_SESSION["pre_url"];
$result = "";
//-----------connect資料庫-----------------//
$db=mysqli_connect("localhost","root","@567-ygv-bnm@");
if(!$db)
    die("無法連線伺服器".mysqli_connect_errno());
$db_select=mysqli_select_db($db,"ordering_system"); 
if(!$db_select)
    die("無法選擇資料庫".mysqli_connect_errno());      
mysqli_query( $db, "SET NAMES 'utf8'");// 設定連線編碼

?>
</head>

<body>

    <!--首頁-->
<div data-role="page" id="home" >
    <div data-role="header" data-add-back-btn="true">
    <a href="<?php echo $pre_url?>" data-role="button" id="search" name="search" data-ajax="false">返回</a>
       <h1>您的訂單</h1> 
  
    </div>
    <div  style='width:200px;padding-top:20px;padding-left:20px;padding-bottom:20px;'>
      <ul data-role="listview" data-inset="true" data-theme="c">
          <li data-role="list-divider">Guest</li>
          <li><?php echo $user_id ?></li>

        </ul>
    </div>
    
    <div class="ui-body ui-body-a ui-corner-all">
   
        
            
                <?php
                    //搜尋取餐資訊
                    $sql_a= "SELECT O.order_id, M.meal_name, M.price, O.ordernum
                                FROM orderlist O,meal M ,takeinfomation T 
                                WHERE T.guest_id='".$user_id."' AND T.order_id=O.order_id AND O.meal_id = M.meal_id 
                                ORDER BY O.order_id ASC";   
                     
                    $result=mysqli_query($db,$sql_a);
                    $num=mysqli_num_rows($result);

                    $sql_b= "SELECT O.order_id ,T.takeway ,T.takedate ,T.taketime ,T.totalsum
                    FROM orderlist O,takeinfomation T  
                    WHERE T.guest_id='".$user_id."' AND O.order_id = T.order_id ";   
         
                    $result_b=mysqli_query($db,$sql_b);
                    $num_b=mysqli_num_rows($result_b);

                 
                    echo  "<ul data-role='listview' data-inset='true' data-theme='a'>";

                    $temp="";$row_b="";$count=0;
                    if($num>0)
                    {  
                        //依次调用 mysql_fetch_row() 将返回结果集中的下一行，如果没有更多行则返回 FALSE
                        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) 
                        {
                            $row_b = mysqli_fetch_array($result_b, MYSQLI_NUM);

                            if($count==0)
                            {
                                echo "<li data-role='list-divider'>訂單編號: ".$row[0]."</li>";
                                echo "<li><h3>取餐時間: ".$row_b[2]." / ".$row_b[3]."</h3>";
                                echo "<h3>取餐方式: ".$row_b[1]."</h3>";
                                echo "<h3>總計: ".$row_b[4]." 元</h3><hr />"; 
                                echo "<h3>餐點: ".$row[1]."</h3>";
                                echo "<p>單價: ".$row[2]."元"." / 選購份數: ".$row[3]." 份</p>";
                            }
                            else
                            {
                                if($row[0]==$temp)
                                {
                                    echo "<h3>餐點: ".$row[1]."</h3>";
                                    echo "<p>單價: ".$row[2]."元"." / 選購份數: ".$row[3]." 份</p>";
                                }
                                else
                                {
                                    echo "<button data-theme='b' data-icon='delete' data-iconshadow='true' id='".$temp."'>取消訂單</button></li>";
                                    echo "<li data-role='list-divider'>訂單編號: ".$row[0]."</li>";
                                    echo "<li><h3>取餐時間: ".$row_b[2]." / ".$row_b[3]."</h3>";
                                    echo "<h3>取餐方式: ".$row_b[1]."</h3>";
                                    echo "<h3>總計: ".$row_b[4]." 元</h3><hr />"; 
                                    echo "<h3>餐點: ".$row[1]."</h3>";
                                    echo "<p>單價: ".$row[2]."元"." / 選購份數: ".$row[3]." 份</p>";
                                }
                            }
                            $temp=$row[0];
                            $count=1;
                        } 
                        echo  "<button data-theme='b' data-icon='delete' data-iconshadow='true' id='".$temp."' >取消訂單</button></li></ul>"; 
                    }
                    else      
                        echo  "<li data-role='list-divider'>查無訂單</li></ul>";


                    if(!mysqli_query($db,$sql_a))
                    {
                        $sqlerr.="FAIL".mysqli_connect_errno();
                    }                                                     
                      mysqli_close($db);
                ?>
           
        </div>     

    </div>

 <?php echo $sqlerr ?>



<script>



$(document).on('click','button',function(event){

 var orderid=event.target.id;
 

 $.ajax({

    type:'post',
    url:'deleteorderlist.php',
    datatype:'json',
    data:{order_id: orderid},
    success: function(data){

      $.each(data,function(index,element){       
          if(element=='訂單已刪除')
              location.reload();
          else if(element=='訂單未刪除')
              console.log('FAIL');    
      });

    },
    error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
           console.warn(jqXHR.responseText);
        }

 });


});



</script>



</div>

</body>
</html>