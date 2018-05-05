<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>分类修改</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">  
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>

<body>
<?php 
//处理添加、修改和删除操作
  $Soperate=$_GET["Oper"];
  $Operid=$_GET["tid"];
  //删除
  if($Soperate=="delete")
  {
    //判断商品表中是否存在此分类
    if ($objGoods->HaveGoodsType($Operid))
    {
      exit("此分类包含商品信息，不能删除！");
    } 

    $objType->delete($Operid);
    echo '<script type="text/javascript">alert("分类已经成功删除！");window.parent.frames.contents.location.reload();document.location="TypeList.php";</script>';
    //window.parent.frames.contents.location.reload();刷新框架内容，contents为框架名称name（index.php里面有定义）
    //exit("分类已经成功删除！");
   // header("Location: TypeList.php");
  }
  elseif ($Soperate=="add")   //添加
  {
    $Name=$_POST["txttitle"];
    //判断是否已经存在此分类名称
    if($objType->HaveGoodsType($Name))
    {
      echo("已经存在此分类名称！");
    }
    else
    {
      $objType->TypeName=$Name;
      $objType->insert();
      echo '<script type="text/javascript">window.parent.frames.contents.location.reload();document.location="TypeList.php";</script>';
    } 

  }
  elseif ($Soperate=="edit")
  {
    $Name=$_POST["txttitle"];
    //判断是否已经存在此分类名称
    if ($objType->HaveGoodsType($Name))
    {
      echo("已经存在此分类名称！");
    }
    else
    {
      $objType->TypeName=$Name;
      $objType->update($Operid);
      echo '<script type="text/javascript">window.parent.frames.contents.location.reload();document.location="TypeList.php";</script>';
    } 
  } 
?>
</body>
<!-- <script language="javascript">
  setTimeout("history.go(-1)",800);
</script> -->
</html>