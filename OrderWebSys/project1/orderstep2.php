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

}

div.error { float: right; color : red; }


</style>

</head>

<body>


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

//-----------connect資料庫-----------------//


$db=mysqli_connect("localhost","root","@567-ygv-bnm@");
if(!$db)
{die("無法連線伺服器".mysqli_error());}

$db_select=mysqli_select_db($db,"ordering_system"); 
if(!$db_select)
{die("無法選擇資料庫".mysqli_error());}
// 設定連線編碼
mysqli_query( $db, "SET NAMES 'utf8'");

for($i=1; $i<=4;$i++){
$sql= "SELECT * FROM meal WHERE meal_id='".$i."'";
$result=mysqli_query($db,$sql);
//$num=mysqli_num_rows($result);
//echo $num;
$row = mysqli_fetch_array($result, MYSQLI_NUM);
$meal[$i] = array("meal_id"=>$row[0],"meal_name"=>$row[1] ,"price"=>$row[2]);

}

mysqli_close($db);
?>



<div data-role="page" id="reference"  data-fullscreen="true" >
    <div data-role="header" data-theme="b" >
        <a href="javascript:" onclick="self.location=document.referrer;">返回</a> 
        <h1>請點餐</h1>     
        <a href="#popupNested" data-rel="popup" class="ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-bars" style="height:20px;" data-transition="slidefade"></a>
        <div data-role="popup" id="popupNested" data-theme="none">
                <ul data-role="listview"  data-inset="true">
                    <li><a href="searchmain.php"  data-ajax="false">查詢訂單</a></li>
                    <li><a href="enterpwpage.php"  data-ajax="false">個人資料修改</a></li>
                    <li><a href="logout.php"  data-ajax="false">登出</a></li>
                </ul>   
        </div>  

     </div>
   
       <!-- <p id='op'></p> -->
    <div  style='width:200px;padding-top:20px;padding-left:20px;'>
      <ul data-role="listview" data-inset="true" data-theme="c">
          <li data-role="list-divider">Guest</li>
          <li><?php echo $user_id ?></li>
        </ul>
    </div>

    <div data-role="content">
    


        <div id="c1" data-role="collapsible-set">
            <div data-role="collapsible" data-collapsed="false">
        
              <h3 >漢堡    $50</h3>
                <div id="p1" class="ui-content">
                  <a href="#myPopup" data-rel="popup" data-position-to="window" data-transition="fade">
                  <img src="picture/bigmac.jpg" alt="bigmac" style="width:200px;"></a>
                </div> 
                <div data-role="popup" id="myPopup">
                <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
                  <img src="picture/bigmac.jpg" style="width:800px;height:400px;" alt="bigmac">
                </div>             
                
                  
              
              <!--<div class="ui-li-aside" name="m1" id="m1">$50</div> -->
              <div >   
                  <label for="addnum1"></label>
                  <select name="addnum" id="addnum1" data-mini="true" data-native-menu='false'>
                  <option value="1">1份</option>
                  <option value="2">2份</option>
                  <option value="3">3份</option>
                  <option value="4">4份</option>
                  <option value="5">5份</option>
                  <option value="6">6份</option>
                  <option value="7">7份</option>
                  <option value="8">8份</option>
                  <option value="9">9份</option>
                  <option value="10">10份</option>
                  </select>
                
                  <button name="<?php echo $meal[1]['meal_id'] ?>" id="sendbym1" data-mini="true" style="width:290px;font-size:20px;background-color:#FFE8BF">加入購物車</button>
                  <input type="hidden" id="price1" />
                </div>     
          
                </div> <!--end collapsible-->

            <div data-role="collapsible">  
          
              <h3>薯條   $30</h3>
              <div id="p2" class="ui-content">
                  <a href="#myPopup2" data-rel="popup" data-position-to="window" data-transition="fade">
                  <img src="picture/frenchfries.jpg" alt="fries" style="width:200px;"></a>
                  <div data-role="popup" id="myPopup2">
                  <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close
                  </a><img src="picture/frenchfries.jpg" style="width:800px;height:400px;" alt="fries">
                  </div>             
              </div>                      
              <div> 
                <label for="addnum2"></label>
                <select name=addnum id="addnum2"  data-mini="true" data-native-menu='false'>
                <option value="1">1份</option>
                <option value="2">2份</option>
                <option value="3">3份</option>
                <option value="4">4份</option>
                <option value="5">5份</option>
                <option value="6">6份</option>
                <option value="7">7份</option>
                <option value="8">8份</option>
                <option value="9">9份</option>
                <option value="10">10份</option>
                </select>
                
                <button name="<?php echo $meal[2]['meal_id'] ?>" id="sendbym2" data-mini="true" style="width:290px;font-size:20px;background-color:#FFE8BF">加入購物車</button>
                <input type="hidden" id="price2" />
                </div> 
            
                </div> <!--end collapsible-->


          <div data-role="collapsible">  
          
          <h3>霜淇淋   $25</h3>
          <div id="p3" class="ui-content">
              <a href="#myPopup3" data-rel="popup" data-position-to="window" data-transition="fade">
              <img src="picture/icecream.jpg" alt="icecream" style="width:200px;"></a>
              <div data-role="popup" id="myPopup3">
              <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close
              </a><img src="picture/icecream.jpg" style="width:800px;height:400px;" alt="icecream">
              </div>             
          </div>                      
          <div> 
            <label for="addnum3"></label>
            <select name=addnum id="addnum3"  data-mini="true" data-native-menu='false'>
            <option value="1">1份</option>
            <option value="2">2份</option>
            <option value="3">3份</option>
            <option value="4">4份</option>
            <option value="5">5份</option>
            <option value="6">6份</option>
            <option value="7">7份</option>
            <option value="8">8份</option>
            <option value="9">9份</option>
            <option value="10">10份</option>
            </select>
            
            <button name="<?php echo $meal[3]['meal_id'] ?>" id="sendbym3" data-mini="true" style="width:290px;font-size:20px;background-color:#FFE8BF">加入購物車</button>
            <input type="hidden" id="price3" />
            </div> 
        
            </div> <!--end collapsible-->

            <div data-role="collapsible">  
          
          <h3>仙草凍   $40</h3>
          <div id="p4" class="ui-content">
              <a href="#myPopup4" data-rel="popup" data-position-to="window" data-transition="fade">
              <img src="picture/Herbaljelly.JPG" alt="Herbaljelly" style="width:200px;"></a>
              <div data-role="popup" id="myPopup4">
              <a href="#" data-rel="back" class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close
              </a><img src="picture/Herbaljelly.JPG" style="width:800px;height:400px;" alt="Herbaljelly">
              </div>             
          </div>                      
          <div> 
            <label for="addnum4"></label>
            <select name=addnum id="addnum4"  data-mini="true" data-native-menu='false'>
            <option value="1">1份</option>
            <option value="2">2份</option>
            <option value="3">3份</option>
            <option value="4">4份</option>
            <option value="5">5份</option>
            <option value="6">6份</option>
            <option value="7">7份</option>
            <option value="8">8份</option>
            <option value="9">9份</option>
            <option value="10">10份</option>
            </select>
            
            <button name="<?php echo $meal[4]['meal_id'] ?>" id="sendbym4" data-mini="true" style="width:290px;font-size:20px;background-color:#FFE8BF">加入購物車</button>
            <input type="hidden" id="price4" />
            </div> 
        
            </div> <!--end collapsible-->
          </div>          
      
      

  </div>

 

  <div data-role="footer" data-position="fixed" >
      <div data-role="navbar" >
          <ul>
              <li>
              <a id="send" data-icon="shop" data-theme="b" data-ajax="false">購物車
              
              <?php
              
              if(isset($_COOKIE['currentsum']))
               $carmoney=$_COOKIE['currentsum'];
              else
              $carmoney='0';

              echo "<span class='ui-li-count'>".$carmoney."元</span>";
              ?>
              </a>
              </li>
          </ul>
      </div><!-- /navbar -->


  </div><!-- /footer -->




  <script>



//建立car物件,作為計算總額使用
  var car={
   total:0,
   numitem:0

  };
  
$(document).ready(function(){
 // var username =<%= Session["TEST_SESSION"].ToString() %>; 
  
 var price;
  $(document).on('click','button',function() {
   
 
    //$(this).removeAttr('data-role');
    var str="";
    var meal=$(this).prop('name'); 
    //var meal=event.target.name; 

    
    var q=$(this).parent().find('select option:selected').val();
    var iq=parseInt(q);
    


    $.ajax({
         type: 'post',
         url:  'getDBmeal.php',
         dataType: 'json',
         data: { mealid : meal
                  },
                   
         success: function(data) {
           
            $.each(data, function(index, element) {
             
                if(element!='error')
                  price=element;
                
                var iprice=parseInt(price);
                var sum=iq*iprice;
                  


              //計算每筆item 編號,若cookie('currentnumitem')不存在,代表第一次進行購物；
              //若存在,代表可能是從購物車返回到此頁的情況,這時再把cookie('currentnumitem')值取出作為item編號,避免蓋過原本的cookie
                if(!parseInt(Cookies.get('currentnumitem')))
              { car.numitem++;
                
              }
                else
                {
                  car.numitem=parseInt(Cookies.get('currentnumitem'));
                  car.numitem++;
                
                }



                //建立當前選購商品總金額的cookie
                if(car.numitem ==1){
                    //createCookie('currentsum', sum,1);
                    Cookies.set('currentsum', sum, { expires: 1 });
                    $('span.ui-li-count').html(sum+'元');
                  }
                else{
                    var tmp= parseInt(Cookies.get('currentsum'));
                    currentsum= sum+tmp;
                    
                    //createCookie('currentsum', currentsum,1);
                    Cookies.set('currentsum', currentsum, { expires: 1 });
                    $('span.ui-li-count').html(currentsum+'元');
                }

                
                  //建立當前選購商品cookie
                  var myAry = [car.numitem, meal, iq,iprice];
                  Cookies.set(car.numitem, JSON.stringify(myAry), { expires: 1 });
                  //createCookie(car.numitem, JSON.stringify(myAry),1);

                  //建立當前選購商品總次數的cookie
                  Cookies.set('currentnumitem', car.numitem, { expires: 1 });
                  //createCookie('currentnumitem', car.numitem,1);

                  //createCookie('currentotal', car.total,1);
                        });
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    console.warn(jqXHR.responseText);
                  }
                  
                });
       
 




     event.stopPropagation();


   });
   
   
  $(document).on('click','a#send',function(){
    window.location.href="showcar.php";

  });




  });  



</script>
</div>









</body>
</html>