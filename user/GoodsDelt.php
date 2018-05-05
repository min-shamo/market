<?PHP include('isUser.php'); ?>
<html>
<head>
<link href=../style.css rel=STYLESHEET type=text/css>
</head>
<body>
<?php 
  //从数据库中批量删除信息
  //读取要删除的编号
  include('..\Class\Goods.php');
  $gid=$_GET["gid"];
  $obj = new Goods();
  $obj->delete($gid);
  print "删除成功!";
?>
</form>
</body>
<script language="javascript">
  opener.location.reload();
  setTimeout("window.close()",600);
</script>
</html>