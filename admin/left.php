<html>

<head>
<title>后台管理</title>
<link href="../style.css" rel="stylesheet">
<base target="main">
</head>

<body topmargin="4" leftmargin="4" bgcolor="#B8B8B8 ">       <!--bgcolor="#eeeeee":设置左边那部分的颜色-->
<div align="center">
  <center>
<table border="0" width="90%" height="300">
  <tr>
    <td width="100%" height="6"></td>
  </tr>
  <tr>
    <td width="100%" height="6"><font color="#000080">系统设置</font></td>
  </tr>
  <tr>
    <td width="100%"   height="6">&nbsp;<font color="#0000FF">  
      <a href="TypeList.php?tid=&Oper=" target="main">商品分类</a></font></td>
  </tr>
  <tr>
    <td width="100%"  height="6">&nbsp;<font color="#0000FF">
    <a href="BulletinList.php">公告管理</a></font></td>
  </tr>
  <tr>
    <td width="100%"  height="6">&nbsp;</font></td>
  </tr>
  <tr>
    <td width="100%" height="6"><font color="#000080">商品管理</font></td>
  </tr>
<?PHP
  include('..\Class\GoodsType.php');
  $objType = new GoodsType();
  $results = $objType->GetGoodsTypelist();
  while($row = $results->fetch_row())  {
?>
 <tr>
    <td width="100%"  height="6">&nbsp;<font color="#0000FF">  
      <a href="GoodsList.php?type=<?PHP echo($row[0]); ?>" target="main"><?PHP   echo($row[1]); ?></a></font></td>
  </tr>
<?PHP 
    } 
?>
  <tr>
    <td width="100%"  height="6">&nbsp;</font></td>
  </tr>
  <tr>
    <td width="100%" height="6"><font color="#000080">用户管理</font></td>
  </tr>
  <tr>
    <td width="100%"  height="6">&nbsp;<font color="#0000FF">  
      <a href="UserList.php?flag=0" target="main">用户列表</a></font></td>
  </tr>
  <tr>
    <td width="100%"  height="6">&nbsp;<font color="#0000FF">
      <a href="MessageList.php" target="main">用户来信</a></font></td>
  </tr>
  <tr>
    <td width="100%"  height="6">&nbsp;<font color="#0000FF">
      <a href="AdminPwdChange.php" target="main">密码修改</a></font></td>
  </tr>

  <tr>
    <td width="100%" height="6"><font color="#000080"> <a href="logout.php" target="_parent">退出</font></td>     <!--target="_parent":退出系统时跳出frame框架-->
  </tr>

</table>
  </center>
</div>
</body>
</html>