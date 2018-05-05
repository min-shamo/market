<?PHP
/*
从Session中获取注册用户信息，判断用户是否已登录且用户类型为管理员（UserType等于 1），若果不是，跳转到login.php
*/
  session_start();
  if ($_SESSION["user_type"]!=1)
  {
    header("Location: "."login.php");
  } 
?>