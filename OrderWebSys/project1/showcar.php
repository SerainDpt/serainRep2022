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
.custom-select {
  position: relative;
  font-family: Arial;
  left: 20px;
  border-color: #8c673e
  
}

.button {
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


if(empty($_SESSION['username'])){
        
  session_unset();
  session_destroy();
  header('Location: startpage.html');
  exit;
      }
else
$user_id=$_SESSION["username"];


$result = "";



?>


<div data-role="page" id="reference" >
  <div data-role="header" data-theme="b" >
  <button onclick="goBack()">返回</button>
     <h1>購物車</h1>
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
      <li data-role="list-divider">選購項目</li>
        
            <?php
                $db=mysqli_connect("localhost","root","@567-ygv-bnm@");
                if(!$db)
                {die("無法連線伺服器".mysqli_error());}

                $db_select=mysqli_select_db($db,"ordering_system"); 
                if(!$db_select)
                {die("無法選擇資料庫".mysqli_error());}
                // 設定連線編碼
                mysqli_query( $db, "SET NAMES 'utf8'");


                $arr="";$sqlerr="";
                //取出當前選購商品數量的cookie
               if(isset($_COOKIE['currentnumitem']))
               {
                
                //取出當前選購商品數量數值
                $numitem=$_COOKIE['currentnumitem'];
                
                 //建立迴圈,依序從選購商品順序:1,開始列印出detail,直到超出當前商品數量時,結束迴圈
                 for($a=1 ; $a<=$numitem ;$a++)
                  {

                      if(isset($_COOKIE[$a]))
                      $arr= json_decode($_COOKIE[$a], true);
                      
                      //若arr[0]!=0的狀況是該筆項目沒有被刪除,因若刪除的話,改筆cookie值的$arr[0]=0
                      if(isset($arr) && $arr[0]!='0')
                      {
                        //meal資料表中查詢餐點名稱
                        $tmp=$arr[1];
                        $sql= "SELECT meal_name FROM meal WHERE meal_id='".$tmp." '";
                        if(!mysqli_query($db,$sql)){

                          $sqlerr.="FAIL".mysqli_error();
                        }
                      
                        $result=mysqli_query($db,$sql);
                        //$num=mysqli_num_rows($result);
                        $row=mysqli_fetch_array($result,MYSQLI_ASSOC);

                        $meal_name=$row["meal_name"];

                    //$listid='listid'.$a;
                      //開始一項list
                      echo "<li id=".$a."><a>";
                      
                                           
                          echo "<h3 >".$meal_name."</h3>";
                          echo "<p>"."單價: ".$arr[3]." 元  ".
                                "選購份數: ".$arr[2]." 份 </p></a>";
                      
                      /*
                      for($j=0 ; $j<$i ; $j++){
                        echo $arr[$j]." ";
                      }
                      */

  
                      //每次迴圈所產生的delete BUT id編號
                      $dbt='dbt'.$a ;
                      echo "<a  id='$dbt' class='button' data-icon='delete'>移除</a>";

 
                      //每次迴圈所產生的select id編號
                      $reselect='reselect'.' '.$a ;
                      //宣告q=選購份數
                      $q=(int)$arr[2];                         
                      echo "<div class='custom-select' style='width:200px;padding-bottom:5px;padding-top:0px; ' data-role='fieldcontain'>"; 
                      echo"<label for='$reselect' ></label>";
                      echo"<select name='select-native-8' id='$reselect'  data-mini='true'>";

                        for($i=1; $i<=10; $i++){

                          if($i==$q)
                             echo"<option value='" .$i. "' selected='selected'>" .$i. " 份</option>";            
                          else
                             echo"<option value='" .$i. "'>" .$i. " 份</option>"  ;

                        }
                      
                       //結束一項list
                      echo "</select></div></li>";

                    }
                    

                  }
                          
                 
                  
                  }

                 mysqli_close($db);


               //setcookie("name", "", time()-3600);
            ?>
          

          <li id='sum'>
          
          <?php
          if(isset($_COOKIE['currentsum']) && !empty($_COOKIE['currentsum']))
          {
            $sum= $_COOKIE['currentsum'];
          
             echo "<h2 id='sumtitle'>總金額</h2>";
             echo "<h3 id='sum'style='background-color:yellow'>".$sum."元 </h3>";

          }
          else{
            echo "<h2>尚無項目</h2>";
            

          }

          ?>

          </li>




    </ul>
          <?php
             echo "<div data-role='fieldcontain' >";
             
             if(isset($_COOKIE['currentsum']) && !empty($_COOKIE['currentsum']))
             echo "<button id='send' name='send' >結帳</button>";
             
              echo"</div>";
          ?>

    <script>

function goBack() {
  window.history.back();
}


$(document).ready(function(){


  //點選刪除button行為
  $(document).on('click','a.button',function(event) {

      var buttonid =event.target.id;
      //找出a button 父節點<li>的id,再與字串'li#'合併成'li#listid1',即成為選擇器條件字串
      var n=$(this).parent().prop('id');
      var liid='li#'+n;


      
      //取出該筆項目cookie,將該筆單價和購買項目取出並計算金額,用來扣除總金額
      var arr= JSON.parse(Cookies.get(n));
      var quantity=arr[2];
      var price=arr[3];
      
      //取出原本紀錄'購買總金額'的cookie,並扣除刪除的金額
      var tmp= Cookies.get('currentsum');
      var sum= tmp - quantity*price;

      //存回到'購買總筆數'的cookie中
      Cookies.set('currentsum', sum, { expires: 1 });
      //createCookie('currentsum',  sum,1);

  

      //將該筆項目cookie值皆設為0
      var myAry = [0, 0, 0,0,0];
      Cookies.set(n, JSON.stringify(myAry), { expires: 1 });
      //createCookie(n,  JSON.stringify(myAry),1);


      //移除該list項目
      $(liid).remove();
      if(sum!=0)
      $('h3#sum').html(sum);
      else
      {
        $('h3#sum').html('尚無項目').removeAttr("style");
        $('h2#sumtitle').html('');
        $('button#send').attr('disabled','""');
      }

      //$('ul').listview('refresh');
      //location.reload();

      event.stopPropagation();
    

  });

  //重新選擇數量, .change()綁定select事件
  $(document).on('change','select',function() {
    var reselectid =event.target.id;
    var words = reselectid.split(' ');
    var item =words[1];
  

      //取出該筆項目cookie,將該筆單價和購買項目取出並計算金額,用來重新計算總金額
      var arr= JSON.parse(Cookies.get(item));
      var oldquantity=parseInt(arr[2]);
      var newquantity=parseInt(this.value);
      var meal=arr[1];
      var price=parseInt(arr[3]);


      //$(this).children().filter(function(){return this.value==arr[2]}).attr('selected','selected');
      
          
      
      //取出原本紀錄'購買總金額'的cookie,並重新計算總金額
      var tmp= Cookies.get('currentsum');
      var sum= tmp - oldquantity*price + newquantity*price;

      //存回到'購買總額'以及'該筆購物項目'的cookie中
      //createCookie('currentsum',  sum,1);
      Cookies.set('currentsum', sum, { expires: 1 });
      var myAry = [item, meal, newquantity,price];
      Cookies.set(item, JSON.stringify(myAry), { expires: 1 });
      //createCookie(item, JSON.stringify(myAry),1); 
    
      //$(this).selectmenu("refresh", true);

    location.reload();
    //alert( "Handler for .change() called." );
    event.stopPropagation();

  });


// 點選button行為
$(document).on('click','button#send',function(event) {

  window.location.href="orderstep3.php";
}



);


      });



</script>
  </div>

  


</div>






</body>
</html>
