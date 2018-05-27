<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<?PHP 
  include('isUser.php'); 
?>
<html>
<head>
<title>保存商品信息</title>
</head>
<body>
<?PHP 
  //得到动作参数，如果为add则表示添加操作，如果为edit则表示更改操作
  $StrAction=$_GET["action"];
  // 定义Goods对象，保存商品数据
  include('..\Class\Goods.php');
  $obj = new Goods();
  $obj->GoodsName=$_POST["goodname"];
  $obj->TypeId=$_POST["typeid"];
  //$obj->SaleOrBuy=intval($_POST["flag"])+1;//$_POST["flag"]获取不到数据
  //http://zhidao.baidu.com/link?url=-yIyAt8Px6a9g9YN42dG__GHssnJhYg9LoG3JTJnfDMxyJzyHlolIxZMDZYHqLQ_zGnU8_8Z5oK7mB_gU0UNBU_fDNHo4KLuT04KiPATrSu
  //http://www.cnblogs.com/fengzheng126/archive/2012/04/21/2461376.html
  $obj->GoodsDetail=$_POST["detail"];
  $obj->Price=$_POST["price"];
  $obj->StartTime=$_POST["addtime"];
  $obj->OldNew=$_POST["old"];
  $obj->Invoice=$_POST["Amount"];
  // $obj->Repaired=$_POST["repaired"];
  // $obj->Carriage=$_POST["carriage"];
  // $obj->PayMode=$_POST["pmode"];
  // $obj->DeliverMode=$_POST["dmode"];
  $obj->OwnerId=$_SESSION["user_id"];
  if ($StrAction=="edit")
  {
    $gid=$_GET["gid"];
    $obj->update($gid);
  }
  else
  {
    $obj->ImageUrl=$_POST["goodimage"];
    $obj->SaleOrBuy=intval($_POST["saleorbuy"]);
    $obj->insert();
  } 
  print "<h3>商品信息成功保存</h3>";
?>
</body>
<script language="javascript">
  // 刷新父级窗口，延迟此关闭
  opener.location.reload();
  setTimeout("window.close()",600);
</script>
</html>