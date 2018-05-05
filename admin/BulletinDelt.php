<?PHP include('isAdmin.php'); ?>
<html>
<head>
<link href=../style.css rel=STYLESHEET type=text/css>
</head>
<body>
<?PHP 
  //从数据库中批量删除公告信息
  //读取要删除的公告编号
  $id=$_GET["id"];
  include('..\Class\Bulletin.php');
  $obj = new Bulletin();
  $obj->delete($id);
?>
</form>
</body>
<script language="javascript">
  alert("成功删除！");
  location.href = "BulletinList.php";
</script>
</html>