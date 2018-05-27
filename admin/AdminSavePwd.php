<?PHP include('isAdmin.php'); ?>
<html>
<head>
<title>修改管理员密码</title>
</head>
<body>
<?PHP 
  //session_start();
  $OriPwd=$_POST["oldpassword"];
  $Pwd=$_POST["password"];
  //判断是否存在此用户
  include('..\Class\Users.php');
  $obj = new Users();
  $obj->UserId=$_SESSION["user_id"];
  $obj->UserPwd=$OriPwd;
  if($obj->CheckUser()==false)
  {
?>
    <Script Language="JavaScript">    
      alert("不存在此用户名或密码错误！");
      history.go(-1)         
      </Script>
<?PHP 
  }
  else
  {
    $obj->UserPwd=$Pwd;
    $obj->setpwd($obj->UserId);
    $_SESSION["user_pwd"]=trim($Pwd);
    ?>
    <Script Language="JavaScript">    
      alert("更改密码成功！");
      location.href = "BulletinList.php";           
      </Script>
  <?PHP
  } 
?>    
</body>
</html>