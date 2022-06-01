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
div.error { float: right; color : red; }

.pagecontent{
  position: relative;
}

.menubtn {
  
  /* float: right; */
  position: absolute; 
  font-size: 12px;
  /* top:-40px; */
  top:0;
  right:0;
  height:40px; 
  width:40px;
  margin: 0;
  padding:0;
}
</style>


</head>

<body>


<?php

session_start();
if(!isset($_SESSION['username']))
{   
    session_unset();
    session_destroy();
    header('Location:startpage.html');
    exit;
}
else      
    $user_id=$_SESSION["username"];

//-----------connect資料庫-----------------//
$db=mysqli_connect("localhost","root","@567-ygv-bnm@");
if(!$db)
    die("無法連線伺服器".mysqli_connect_errno());
$db_select=mysqli_select_db($db,"ordering_system"); 
if(!$db_select)
    die("無法選擇資料庫".mysqli_connect_errno());      
mysqli_query( $db, "SET NAMES 'utf8'");// 設定連線編碼
?>

<div class="pagecontent" data-role="page">
    <div data-role="header" >
      <h1>請先填寫取餐資訊</h1>
     </div>
     
     <!-- <div class="button">
     <a href="#popupNested" data-rel="popup" class="ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-bars button"  data-transition="slidefade"></a>
    </div> -->

    
     <a href="#popupNested" data-rel="popup" class="menubtn ui-btn ui-shadow ui-corner-all ui-btn-icon-left ui-icon-bars button"  data-transition="slidefade"></a>
    

    <div data-role="popup" id="popupNested" data-theme="none">
            <ul data-role="listview"  data-inset="true">
                <li><a href="searchmain.php"  data-ajax="false">查詢訂單</a></li>
                <li><a href="enterpwpage.php"  data-ajax="false">個人資料修改</a></li>
                <li><a href="logout.php"  data-ajax="false">登出</a></li>
            </ul>   
    </div>

<!--     <div data-role="fieldcontain">
            <a href="searchmain.php" data-role="button" id="search" name="search" data-ajax="false">查詢訂單</a>
    </div>-->

    <div  style='width:200px;padding-top:20px;padding-left:20px;'>
        <ul data-role="listview" data-inset="true" data-theme="c">
            <li data-role="list-divider">Guest</li>
            <li><?php echo $user_id ?></li>
          </ul>
    </div>
  <div data-role="content">

          <div data-role="fieldcontain" data-inset="true">
              <div>取餐時間日期</div>
             <input type="date" name="pdate" id="pdate" min="2019-03-04"/>
              <div id='err1' class="error">
             </div> 
          </div>
          
          <div data-role="fieldcontain" data-inset="true">
              <div>取餐時間</div>
              <label for="add"></label>
              <select name=ptime id="ptime">
                  <option value="" selected='selected'>請選擇</option>
                  <option value="11:00">11:00</option>
                  <option value="11:30">11:30</option>
                  <option value="12:00">12:00</option>
                  <option value="12:30">12:30</option>
                  <option value="13:00">13:00</option>
                  <option value="13:30">13:30</option>
                  <option value="14:00">14:00</option>
                  <option value="14:30">14:30</option>
                  <option value="15:00">15:00</option>
                  <option value="15:30">15:30</option>
              </select>
              <div id='err2' class="error">
              </div> 
          </div>
            
            <?php
                $sql= "SELECT guest_phone FROM guest WHERE guest_id='".$user_id."'";                        
                $result=mysqli_query($db,$sql);
                if(mysqli_num_rows($result)>0)
                {
                    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
                    //substr_replace($row["guest_address"],'',-1);
                    $d_phone=$row["guest_phone"];
                }
                else
                    $d_phone='請輸入聯絡電話';
            ?>
          
            <div data-role="fieldcontain" data-inset="true">
              <div>取餐方式</div>  
               
            
              <fieldset data-role="controlgroup" data-type="horizontal" >
                <label for="ups">外送</label>
                <input type="radio" name="delivery" id="ups" value="1" />
                <label for="self">外帶</label>
                <input type="radio" name="delivery" id="self" value="2" checked/>
                </fieldset>
              <div id='err3' class="error"></div>
                                          
              <div data-role="fieldcontain" id='d_info'>
                 <div id=upuser>請確認手機號碼</div>
                 <input type="text" style="font-size:20px" id="userphone" size="33" value="<?php echo $d_phone ?>"/>
              </div>             
              
              </div>   
    


      

          <div data-role="fieldcontain">
          <div id='err4' class="error"></div>
          <button id="send" name="send">開始選餐</button>
          </div>
          <input type="hidden" id="foruser" name="foruser" value="<?php echo $user_id ?>" />

  </div>

  <script>



$(document).ready(function(){
  

   var newdata,newtime,newpickway;
   var phonenumber='';
   $('input[name="pdate"]').change(function(){
           newdata=$(this).val();
          
          $('div#err1').html('');
          event.stopPropagation();
     });


     $( 'select#ptime' ).change(function() {

         newtime=$(this).val();
        
        $('div#err2').html('');
        event.stopPropagation();
     });

     $(document).on('change','input[name="delivery"]',function() {

         newpickway=$('input[name="delivery"]:checked').val();
         user_id=$('input[name=foruser]').val();
         $('div#err3').html('');
        
          
          if(newpickway=='1')
            {
              newpickway='外送';

                //透過ajax取出guest資料表中使用者的通訊地址資訊,讓使用者確認是否送往該處
                $.ajax({
                  type: 'post',
                  url:  'getDBaddress.php',
                  dataType: 'json',
                  data: { username : user_id
                            },
                            
                  success: function(data) {
                    var i=0;
                 
                      $.each(data, function(key,value) {

                          if(value!='請確認外送地址')
                          {
                            
                            $('div#d_info').append('<div id=upuser2>請確認外送地址</div><input type="text" style="font-size:20px" id="useraddress" size="33" value="'+value+'"/>' ).enhanceWithin();
                            //$('div#d_address').append('<div id=upuseraddress>請確認外送地址</div><input type="text" style="font-size:20px" id="useraddress" size="33" value="'+element+'"/>' );
                          
                            
                          }
                          else
                            {
                              $('div#d_info').append('<input type="text" id="useraddress" placeholder="請確認外送地址"/>' ).enhanceWithin();
                            } 
                                                       
                            i++;
                      });
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                    console.warn(jqXHR.responseText);
                  }
                  
                });
          
            }
            if(newpickway=='2')
            {

              
              newpickway='外帶';
              $('input#useraddress').remove();
              $('div#upuser2').remove();
             
            
            }

        
       


            event.stopPropagation();
        });


  $(document).on('blur','input#userphone',function(){

        function Iscellphone(phone) { 
        var regex = /^09\d{8}$/;
        if(!regex.test(phone)) {
          return false;
        }
        else{
          return true;
        }
        }

        $phonechecking=Iscellphone($(this).val());

       if($phonechecking==false)
        $('input#userphone').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">請填寫正確格式</span>').enhanceWithin();  


        event.stopPropagation();
        });

    $(document).on('focus','input#userphone', function() {
       // 取得表單欄位值
     
       $('input#userphone').parent().next('span').remove();

       event.stopPropagation();
    });


  $(document).on('blur','input#useraddress',function(){

          if($('input#useraddress').val().length<10)
             $('input#useraddress').after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">請填寫詳細地址</span>').enhanceWithin();

             event.stopPropagation();
        });

  $(document).on('focus','input#useraddress', function() {
       // 取得表單欄位值
     
       $('input#useraddress').next('span').remove();

       event.stopPropagation();
    });

  // 點選button行為
  $(document).on('click','button#send',function() {


    if( $('#pdate').val().length==0){ 
    
       $('div#err1').html('取餐日期未選取 ');
    }
     if($('select#ptime').val().length==0){
     
       $('div#err2').html('取餐時間未選取 ');
      }

      if(!$('input[name="delivery"]:checked').val()){
     
     $('div#err3').html('取餐方式未選取 ');
    }
      
  



    if($('input[name="delivery"]:checked').val()=='1'){

      if($('#pdate').val().length!=0  && $('select#ptime').val().length!=0 && $('input#useraddress').val().length>=10 && $('input#userphone').val().length==10)
          {
            
              newpickway='外送';
              var myAry = [$('#pdate').val(), $('select#ptime').val(), newpickway];
              //createCookie('userpickway', JSON.stringify(myAry),1);
              Cookies.set('userpickway', JSON.stringify(myAry), { expires: 1 });
              Cookies.set('currentphone', $('input#userphone').val(), { expires: 1 }); 
              Cookies.set('currentaddress', $('input#useraddress').val(), { expires: 1 });
              var arr= JSON.parse(Cookies.get('userpickway'));
          


              window.location.href="orderstep2.php";
              }
      else
      {
       
        $('div#err4').html('請確認格式是否有誤');
      
      }
    }

    if($('input[name="delivery"]:checked').val()=='2'){

    if($('#pdate').val().length!=0  && $('select#ptime').val().length!=0 &&  $('input#userphone').val().length==10)
    {
    
      newpickway='外帶';
      var myAry = [$('#pdate').val(), $('select#ptime').val(), newpickway];
      //createCookie('userpickway', JSON.stringify(myAry),1);
      Cookies.set('userpickway', JSON.stringify(myAry), { expires: 1 });
      Cookies.set('currentphone', $('input#userphone').val(), { expires: 1 }); 
        var arr= JSON.parse(Cookies.get('userpickway'));


    
      window.location.href="orderstep2.php";

    }
     
    else
      $('div#err4').html('請確認格式是否有誤');
    }
   
    event.stopPropagation();

  });



});

</script>




</div>





</body>

</html>


