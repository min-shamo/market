<?PHP
  session_start();
?>
<?PHP 
  //从Session变量中读取注册用户信息，并连接到数据库验证
  include('..\Class\Users.php');
  $UserName=trim($_SESSION["user_id"]);
  $Pwd=trim($_SESSION["user_pwd"]);
  //如果用户名为空，则显示提示信息
  if($UserName=="")
  {
    exit("请登录后再使用！");
  }
  else
  {
    //连接数据库，进行身份验证
    $obj = new Users();
    $obj->UserId=trim($_SESSION["user_id"]);
    $obj->UserPwd=trim($_SESSION["user_pwd"]);
    if (!$obj->CheckUser())
    {
      exit("请登录后使用本系统！");
    } 
  } 
?>