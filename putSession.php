<?PHP
  session_start();
  //取输入的用户名和密码
  $UID=$_POST["loginname"];
  $PSWD=$_POST["password"];

  include('Class\Users.php');
  $objUser = new Users();
  $objUser->UserId=$UID;
  $objUser->UserPwd=$PSWD;
  // 把用户名和密码放入Session
  $objUser->GetUsersInfo($UID);
  $_SESSION["user_id"]=$UID;
  $_SESSION["user_pwd"]=$PSWD;
  $_SESSION["user_type"]=$objUser->UserType;
  header("Location: "."index.php");
?>