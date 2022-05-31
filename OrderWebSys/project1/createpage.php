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
.error { float: right; color : red; }
.ui-page {
    background: url(picture/bg.jpg);
    background-repeat:no-repeat;
    background-position:center center;
    background-size:cover;  
}
</style>


</head>

<body>

<?php


$error = ""; $result =0 ; 
if(isset($_POST["send"]))
{
    $id=$_POST["user_id"];
    $pw=$_POST["user_pw"];
    $email=$_POST["email"];  
    $phone=$_POST["phone"];
    $name=$_POST["user_name"];
    $address_1=$_POST["address_1"];
    $address_2=$_POST["address_2"];
    $address_3=$_POST["address_3"];
    $address=$address_1.$address_2.$address_3;

    if (empty($id)) 
    { // 欄位沒填
      $error = "帳號為必填欄位<br/>";
    }
    else 
    { 
        if (empty($pw)) 
        { // 欄位沒填
          $error .= "密碼為必填欄位<br/>";
        } 
        else 
        { // 表單處理
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
            $sql= "INSERT INTO guest (guest_id,guset_password,guest_email,guest_phone,guest_address,guest_name) VALUES ('$id','$pw','$email','$phone','$address','$name')";

            if(!mysqli_query($db,$sql))
            {
              $result="FAIL".mysqli_error();
            }
            else 
              $result=1;
            mysqli_close($db);

        }
    }
}
else
{
  $id="";$pw="";$email="";$phone="";$address="";
}
?>

<div data-role="page" id="createpage" class="ui-page">
  <div data-role="header">
  
    <a href="startpage.html" data-role="button"  data-ajax="false">返回</a>
   
  <h1>用戶註冊</h1>
  </div>
  <div data-role="content">
  <div style="color: red"><?php echo $error ?></div>
    <form  method="post" action="" data-ajax="false">
      <div data-role="fieldcontain">
        <label for="user_id">註冊帳號:</label>
        <input type="text" name="user_id" id="user_id" />
      </div>
      <div data-role="fieldcontain">
        <label for="user_pw">密碼:</label>    
        <input type="password" name="user_pw" id="user_pw" placeholder="密碼長度須大於6個字元" />
      </div>
      <div data-role="fieldcontain">
        <label for="user_pw_2">再次輸入密碼:</label>    
        <input type="password" name="user_pw_2" id="user_pw_2" />
      </div>
      <div data-role="fieldcontain">
          <label for="user_name">用戶姓名:</label>    
          <input type="text" name="user_name" id="user_name" />
      </div>
      <div data-role="fieldcontain">
          <label for="email">信箱:</label>    
          <input type="email" name="email" id="email" />
      </div>
      <div data-role="fieldcontain">
          <label for="phone">手機號碼:</label>    
          <input type="text" name="phone" id="phone" placeholder="範例:0912345678" />
      </div> 
      <div  class="ui-grid-b" data-role="fieldcontain" >
              <div>常用地址</div>
      
              <div style='width:150px;padding-bottom:2px;padding-top:5px;' class="ui-block-a">  
                <label for="address"></label>
                <select name="address_1" id="address_1" >
                <option value="請選擇縣市" select='select'>請選擇縣市</option>
                <option value="台北市">台北市</option>
                <option value="桃園市">桃園市</option>
                </select>
              </div>   

             <div style="width:150px;padding-bottom:2px;padding-top:5px;" class="ui-block-b">

              </div> 

              <div style='width:380px;padding-bottom:2px;padding-top:5px;' class="ui-block-c"> 
              
              </div> 
      </div>
      <div data-role="fieldcontain">  
      <button type="submit" name="send" id="send" class="btn" disabled="">註冊</button>
      </div>  
    </form>
    
    <?php  
        
    if ($result==1)
      echo " <div data-role='fieldcontain' ><a href='loginpage.php' data-role='button' id='send' name='send' >登入</a></div>";
    ?>
  </div>

<script>

$(document).ready(
  function() 
  {

      var count=0;//作為計算欄位是否有填的次數用,等於7時,表示都有填寫
      var pw;
      var flag_a,flag_b,flag_c,flag_d,flag_e,flag_f,flag_g;

      /*-------------------------帳號處理-------------------------------------*/

      $('input[name=user_id]').blur( 
        function() 
        {
            // 取得表單欄位值            
            if($(this).val().length >0 )
            {         
                var user_id = $(this).val();
                $.ajax(
                    {
                        type: 'post',
                        url:  'getDBaccount.php',
                        dataType: 'json',
                        data: { username : user_id },
                        success: function(data) 
                        {
                            $.each(data, 
                                function(index, element) 
                                {
                                    if(element=='可以使用')
                                    {
                                      $('input[name=user_id]').parent().after('<span style="color:#00D600;padding-left:10px;font-family:Microsoft JhengHei;">'+element+'</span>');
                                      flag_a=1;
                                    }
                                    if(element=='此帳號已有人使用')
                                    {
                                      $('input[name=user_id]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">'+element+'</span>');
                                      flag_a=0;
                                    }
                                }                           
                            );
                        },
                        error: function(jqXHR, textStatus, errorThrown) 
                        {
                          console.log(textStatus, errorThrown);
                          console.warn(jqXHR.responseText);
                        }
                        
                    }
                  );

          }
          else
              $('input[name=user_id]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">帳號為必填項目</span>');

          if(flag_a==1 && flag_b==1 && flag_c==1 && flag_d==1 && flag_e==1 && flag_f==1 && flag_g==1)
                $('button#send').removeAttr("disabled");
          else
                $('button#send').attr('disabled', 'disabled');

          console.log(flag_a,flag_b,flag_c,flag_d,flag_e,flag_f,flag_g)
          event.stopPropagation();
          }
      );

        $('input[name=user_id]').focus( 
          function() 
          {
              // 取得表單欄位值
              $('input[name=user_id]').parent().next('span').remove();
              event.stopPropagation();
          }
        );

      /*-------------------------密碼處理-------------------------------------*/

      $('input[name=user_pw]').blur( 
          function() 
          {
            // 取得表單欄位值     
            if($(this).val().length <6 )
            {         
                $('input[name=user_pw]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">密碼長度須大於6個字元</span>');
                flag_b=0;
            }   
            else 
            {
                pw=$(this).val();   
                flag_b=1;
            }
            
            if(flag_a==1 && flag_b==1 && flag_c==1 && flag_d==1 && flag_e==1 && flag_f==1 && flag_g==1)
                  $('button#send').removeAttr("disabled");
            else
                  $('button#send').attr('disabled', 'disabled');

            console.log(flag_a,flag_b,flag_c,flag_d,flag_e,flag_f,flag_g)  
            event.stopPropagation();
          }
        );

      $('input[name=user_pw]').focus( 
          function() 
            {
                // 取得表單欄位值         
                $('input[name=user_pw]').parent().next('span').remove();
                event.stopPropagation();
            }
        );

      $('input[name=user_pw_2]').blur( 
          function() 
          {
              // 取得表單欄位值     
              if($(this).val() != pw)
              { 
                  $('input[name=user_pw_2]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">密碼不正確</span>');
                  flag_c=0;
              }   
              else
                  flag_c=1;
                
              if(flag_a==1 && flag_b==1 && flag_c==1 && flag_d==1 && flag_e==1 && flag_f==1 && flag_g==1)
                  $('button#send').removeAttr("disabled");
              else
                  $('button#send').attr('disabled', 'disabled');

              console.log(flag_a,flag_b,flag_c,flag_d,flag_e,flag_f,flag_g)       
              event.stopPropagation();
          }
        );

      $('input[name=user_pw_2]').focus( 
          function() 
          {
            // 取得表單欄位值
            $('input[name=user_pw_2]').parent().next('span').remove();
            event.stopPropagation();
          }
        );

    /*-------------------------處理用戶姓名-------------------------------------*/

      $('input[name=user_name]').blur( 
          function() 
          {
            // 取得表單欄位值     
            if($(this).val().length <= 0)
            { 
                $('input[name=user_name]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">請填入姓名</span>');
                flag_d=0;
            }   
            else
                flag_d=1;

            if(flag_a==1 && flag_b==1 && flag_c==1 && flag_d==1 && flag_e==1 && flag_f==1 && flag_g==1)
                $('button#send').removeAttr("disabled");
            else
                $('button#send').attr('disabled', 'disabled');
            console.log(flag_a,flag_b,flag_c,flag_d,flag_e,flag_f,flag_g)
            event.stopPropagation();
          }
        );

        $('input[name=user_name]').focus( 
          function() 
          {
            // 取得表單欄位值
            $('input[name=user_name]').parent().next('span').remove();
            event.stopPropagation();
          }
        );


        /*-------------------------處理mail-------------------------------------*/
        function IsEmail(email) 
        { 
          var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if(!regex.test(email)) 
          {
            return false;
          }
          else
          {
            return true;
          }
        }

      $('input[name=email]').blur( 
        function() 
        {
            var currentemail=$(this).val();
            $Emailchecking=IsEmail(currentemail);

            if($Emailchecking==false)
              $('input[name=email]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">請填寫正確的E-MAIL格式</span>');  
            else
            {             
                  $.ajax({
                  type: 'post',
                  url:  'getDBmail.php',
                  dataType: 'json',
                  data: {usermail : currentemail},      
                  success: function(data) 
                  {
                      $.each(data, 
                      function(index, element) 
                        {
                            if(element=='可以使用')
                                flag_e=1;                  
                            else if(element=='此信箱已使用過')
                            {
                                $('input[name=email]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">'+element+'</span>');
                                flag_e=0;
                            }
                        }
                      );
                  },
                  error: function(jqXHR, textStatus, errorThrown) 
                  {
                    console.log(textStatus, errorThrown);
                    console.warn(jqXHR.responseText);
                  }
                });
            }   
        
            if(flag_a==1 && flag_b==1 && flag_c==1 && flag_d==1 && flag_e==1 && flag_f==1 && flag_g==1)
                $('button#send').removeAttr("disabled");
            else
                $('button#send').attr('disabled', 'disabled');

            console.log(flag_a,flag_b,flag_c,flag_d,flag_e,flag_f,flag_g)
            event.stopPropagation();
         }
        );
        
        $('input[name=email]').focus( 
          function() 
          {
            // 取得表單欄位值
            $('input[name=email]').parent().next('span').remove();
            event.stopPropagation();
          }
         );
        

      /*-------------------------處理手機電話-------------------------------------*/
      
      function Iscellphone(phone) 
      { 
        var regex = /^09\d{8}$/;
        if(!regex.test(phone)) 
        {
          return false;
        }
        else
        {
          return true;
        }
      }

      $('input[name=phone]').blur( 
        function() 
        {
          $phonechecking=Iscellphone($(this).val());
          if($phonechecking==false)
          { 
              $('input[name=phone]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">請填寫正確格式</span>');  
              flag_f=0; 
          }
          else
              flag_f=1;
        
          if(flag_a==1 && flag_b==1 && flag_c==1 && flag_d==1 && flag_e==1 && flag_f==1 && flag_g==1)
              $('button#send').removeAttr("disabled");
          else
              $('button#send').attr('disabled', 'disabled');

          console.log(flag_a,flag_b,flag_c,flag_d,flag_e,flag_f,flag_g)
          event.stopPropagation();
        }
      );

      $('input[name=phone]').focus( 
        function() 
        {
            // 取得表單欄位值
            $('input[name=phone]').parent().next('span').remove();
            event.stopPropagation();
        }
      );

      /*-------------------------處理地址-------------------------------------*/
      
      //動態產生的element,使用$(document).on做綁定
      $(document).on('change','select#address_1',
          function() 
          {       
              var Taoyuan=["中壢區","平鎮區","龍潭區","楊梅區","新屋區",
                            "觀音區","桃園區",	"龜山區",	"八德區",	"大溪區",	
                            "復興區","大園區","蘆竹區" ];

              var Taipei=["中正區","大同區","松山區","大安區","萬華區",
                            "信義區","台北市",	"士林區",	"北投區",	"內湖區",	
                            "南港區","文山區"];

              if($(this).val()=='台北市')
              {
                  $("div.ui-block-b").append('<label for="address_2"></label>'+
                                '<select name="address_2" id="address_2" >'+
                                  '<option value="non" select="select">請選擇縣市</option>'+
                                  '<option value="中正區">中正區</option>'+
                                  '<option value="大同區">大同區</option>'+
                                  '<option value="松山區">松山區</option>'+
                                  '<option value="大安區">大安區</option>'+
                                  '<option value="萬華區">萬華區</option>'+
                                  '<option value="信義區">信義區</option>'+
                                  '<option value="中山區">中山區</option>'+
                                  '<option value="士林區">士林區</option>'+
                                  '<option value="北投區">北投區</option>'+
                                  '<option value="內湖區">內湖區</option>'+
                                  '<option value="南港區">南港區</option>'+
                                  '<option value="文山區">文山區</option>'+
                                '</select>').enhanceWithin();
                                //$("div.ui-block-c").append('<input type="text" name="address_3" id="address_3" />').enhanceWithin(); 

              }

              if($(this).val()=='桃園市')
              {
                  $("div.ui-block-b").append('<label for="address_2"></label>'+
                                '<select name="address_2" id="address_2" >'+
                                  '<option value="non" select="select">請選擇行政區</option>'+
                                  '<option value="中壢區">中壢區</option>'+
                                  '<option value="平鎮區">平鎮區</option>'+
                                  '<option value="龍潭區">龍潭區</option>'+
                                  '<option value="楊梅區">楊梅區</option>'+
                                  '<option value="新屋區">新屋區</option>'+
                                  '<option value="觀音區">觀音區</option>'+
                                  '<option value="桃園區">桃園區</option>'+
                                  '<option value="龜山區">龜山區</option>'+
                                  '<option value="八德區">八德區</option>'+
                                  '<option value="大溪區">大溪區</option>'+
                                  '<option value="復興區">復興區</option>'+
                                  '<option value="大園區">大園區</option>'+
                                  '<option value="蘆竹區">蘆竹區</option>'+
                                '</select>').enhanceWithin();
                              // $("div.ui-block-c").append('<input type="text" name="address_3" id="address_3" />').enhanceWithin();        
              }

              event.stopPropagation();
          }
      
      );


      $(document).on('focus','select#address_1',
          function()
          {               
                $('select#address_2').remove();
                $('input#address_3').remove();
                event.stopPropagation();
          }
      );

      $(document).on('change','select#address_2',
          function()
          {
            if($('select#address_2').val()!='non')
            $("div.ui-block-c").append('<input type="text" name="address_3" id="address_3" />').enhanceWithin();       
            event.stopPropagation();
          }
      );

      $(document).on('focus','select#address_2',
          function()
          {       
            $('input#address_3').remove();
            event.stopPropagation();  
          }
      );

      $(document).on('blur','input[name=address_3]',
          function()
          {

              if($('input[name=address_3]').val().length>5)
                  flag_g=1;
              else
              { 
                  flag_g=0;
                  $('input[name=address_3]').parent().after('<span style="color:red;padding-left:10px;font-family:Microsoft JhengHei;">請詳細填寫地址資訊</span>');  
              } 

              if(flag_a==1 && flag_b==1 && flag_c==1 && flag_d==1 && flag_e==1 && flag_f==1 && flag_g==1)
                $('button#send').removeAttr("disabled");
              else
                $('button#send').attr('disabled', 'disabled');

              console.log(flag_a,flag_b,flag_c,flag_d,flag_e,flag_f,flag_g)
              event.stopPropagation();
          
          }
      );

      $(document).on('focus','input[name=address_3]',
        function()
          {
            $('input[name=address_3]').parent().next('span').remove();
            event.stopPropagation();
          }
      );
}
 
 );

</script>

</div>

</body>

</html>