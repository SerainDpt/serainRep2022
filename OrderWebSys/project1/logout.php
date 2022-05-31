<?php
  mysqli_close($db);
  session_unset($_SESSION['username']);
  session_unset($_SESSION["pre_url"]);
  session_destroy();
  //清除cookie
   $tmp=(int)($_COOKIE['currentnumitem']);
  for($i=1; $i<=$tmp; $i++)
  {
    setcookie($i, null, -1,'/');
    unset($_COOKIE[$i]);
  }
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

  //回到首頁
  if(empty($_SESSION['username']))
  {   
    session_unset();
    session_destroy();
    header('Location: startpage.html');
    exit;
  }

?>
