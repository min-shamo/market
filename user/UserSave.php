<html>
<head>
<title>保存用户信息</title>
</head>
<body>
<?PHP 
  include('..\Class\Users.php');
  $objUser = new Users(); //创建User对象，用于访问个人信息表
  $uid=$_POST["userid"]; // 用户名
  $objUser->UserId=$uid; // 用户名
  $objUser->UserPwd=$_POST["password"]; // 密码
  //$objUser->Name=$_POST["username"]; // 姓名
  $objUser->Sex=intval($_POST["sex"]); // 性别 
  // $objUser->Address=$_POST["address"]; // 地址
  // $objUser->Postcode=$_POST["telephone"]; // 邮编
  $objUser->Email=$_POST["email"]; // 电子邮件
  // $objUser->Telephone=$_POST["telephone"]; // 电话
  $objUser->Mobile=$_POST["mobile"]; // 手机
  if ($_POST["isadd"]=="new")
  {
    //判断此用户是否存在
    if($objUser->HaveUsers($uid))
    {
?>
            <script language="javascript">
                alert("已经存在此用户名！");
                history.go(-1);
            </script>
<?PHP 
    }
    else
    {
      $objUser->UserType=0;
      $objUser->getpasstime=0; // 用户类型
      $objUser->insert();
    } 
  }
  else
  {
    //更新用户信息
    $objUser->update($objUser->UserId);
  } 
  print "<h2>用户信息已成功保存！</h2>";
?>
</body>
<script>
    opener.location.reload();
    setTimeout("window.close()",800);
</script>
</html>