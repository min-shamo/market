<?PHP include('isAdmin.php'); ?>
<html>
<head>
<title>删除用户信息</title>
</head>
<body>
<?PHP
  //只有管理员有强制删除商品的权限
  include('..\class\Users.php');
  $UserId=$_GET["userid"];
  $obj = new Users();
  $obj->delete($UserId);
  print("<h3>用户信息成功删除</h3>");
?>
</body>
<script language="javascript">
  // 刷新父级窗口，延迟此关闭
  opener.location.reload();
  setTimeout("window.close()",600);
</script>
</html>