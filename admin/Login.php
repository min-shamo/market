<?PHP
  //根据录入的用户信息查询数据
  session_start();
  include('../class/Users.php');
  @$AdminId=$_SESSION["user_id"];
  @$AdminPwd=$_SESSION["$UserPwd"];//加@避免提示
  if($AdminId!="")
  {
    $objUser = new Users();
    $objUser->GetUsersInfo($AdminId);
    if ($objUser->UserId!="" && $objUser->UserPwd==$AdminPwd && $objUser->UserType==1)
    {
      $_SESSION["UserType"]=1;
      header("Location: "."index.php");
    } 
  } 
?>
<html>
<head>
<title>管理员登录</title>
<link rel="stylesheet" href="../style.css">
</head>
<body>
<form name="myform" action="putSession.php" method="Post">
<br>
<table border="0" align="center">
<tr><td align=center><h2>管理员登录</h2></td></tr>
</table>
<table border="0" align="center">
     <tr>
      <td align="right">管理员账号:</td>
      <td><input maxLength="20" name="loginname" size="30"></td>
     </tr>
    <tr>
      <td align="right">管理员密码:</td>
      <td><input maxLength="20" name="password" size="30" type="password"></td>
    </tr>
    <tr>
     <td align="right">&nbsp;</td>
        <td align="center">&nbsp;</td>
    </tr>
    <tr>
     <td align="right">&nbsp;</td>
        <td align="center"><input type="submit" value=" 登 陆 "></td>
    </tr>

</table>
</form>
</body>
</html>