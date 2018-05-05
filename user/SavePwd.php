<?PHP  include('isUser.php');
  ?>
<html>
<head>
<title>修改用户密码</title>
</head>
<body>
<?PHP 
  //session_start();
  $OriPwd=$_POST["oldpassword"];
  $Pwd=$_POST["password"];
  //判断是否存在此用户
  include_once('..\Class\Users.php');
  $obj = new Users();
  $obj->UserId=$_SESSION["user_id"];
  $obj->UserPwd=$OriPwd;
  if($obj->CheckUser()==false)
  {
    print "<h2>不存在此用户名或密码错误！</h2>"
?>
  <Script> 
      setTimeout("history.go(-1)",1600);        
    </Script>
<?PHP 
  }
  else
  {
    $obj->UserPwd=$Pwd;
    $obj->setpwd($obj->UserId);
    $_SESSION["UserPwd"]=trim($Pwd);
    print "<h2>更改密码成功！</h2>"
?>                
<Script>
      setTimeout("history.go(-2)",1600);
    </Script>
<?PHP
}

 ?>  
</body>
</html>