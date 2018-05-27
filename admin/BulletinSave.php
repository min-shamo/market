<?PHP include('isAdmin.php'); ?>
<html>
<head>
<title>保存公告</title>
</head>
<body>
<?PHP 
  date_default_timezone_set("PRC");
  include('..\Class\Users.php');
  include('..\Class\Bulletin.php');
  //session_start();
  //得到动作参数，如果为add则表示创建公告，如果为update则表示更改公告
  $StrAction=$_GET["action"];
  // 读取当前用户信息
  $objUser = new Users();
  $objUser->GetUsersInfo($_SESSION["user_id"]);
  // 设置公告信息
  $objBul = new Bulletin();
  //取得公告题目和内容和提交人用户名
  $objBul->Title=$_POST["title"];
  $objBul->Content=$_POST["content"];
  $objBul->Poster=$objUser->UserId;
  $objBul->PostTime=strftime("%Y-%m-%d %H:%M:%S");

  if ($StrAction=="add")
  {
    //在数据库表Board中插入新公告信息
    $objBul->insert();
  }
  else
  {
    //更改此公告信息
    $id=$_GET["id"];
    $objBul->update($id);
  } 
?>
</body>
<script language="javascript">
  alert("公告成功保存！");
  location.href = "BulletinList.php";
</script>
</html>