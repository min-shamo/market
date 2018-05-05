<?PHP include('isUser.php'); ?>
<html>
<head>
<link href=../style.css rel=STYLESHEET type=text/css>
</head>
<body>
<?PHP 
  //从数据库中批量删除商品信息
  //读取要删除的公告编号
  include('..\Class\Goods.php');
  $gid=$_GET["gid"];
  $obj = new Goods();
  $obj->SetOver($gid);
  print("商品交易已结束!");
?>
</form>
</body>
<script language="javascript">
  opener.location.reload();
  setTimeout("window.close()",600);
</script>
</html>