<?PHP include('isAdmin.php'); ?>
<head>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</head>
<?PHP 
  $m=0;
  $itype=$_GET["type"];
?>
<body>
<p style="font-size:20px;padding:10px;text-align:center">商品列表</p>
<table border=1 width=100% cellspacing=0 bordercolorlight="#C0C0C0" bordercolordark="#FFFFFF">
<tr  bgcolor="#CCFFFF">
<td align=center width="16%">商品名称</td>
<td align=center width="16%">交易类型</td>
<td align=center width="16%">卖家/买家</td>
<td align=center width="16%">当前价格</td>
<td align=center width="16%">是否结束</td>
<td align=center width="16%">操作</td>
</tr>
<?PHP 
  include('..\Class\Goods.php');
  $obj = new Goods();
  $results = $obj->GetGoodslist(" WHERE TypeId=" . $itype);
  include('..\Class\Users.php');
  while($row = $results->fetch_row())
  {
    $m=$m+1;
    $objUser = new Users();
    $objUser->GetUsersInfo($row[15]);
?><tr>
  <td align=center><a href="../GoodsView.php?gid=<?PHP   echo($row[0]); ?>" target=_blank><?PHP   echo($row[3]); ?></a></td>
  <td align=center><?PHP if($row[2]==1){ ?>转让<?PHP }else{ ?>求购<?PHP } ?></td>
  <td align=center><a href="../UserView.php?uid=<?PHP   echo($row[15]); ?>"  target=_blank><?PHP   echo($objUser->UserId); ?></a></td>  
  <td align=center>￥<?PHP   echo($row[6]); ?></td>
  <td align=center><?PHP   if ($row[14]==1)
  {
?>已结束<?PHP   }
    else
  {
?>未结束<?PHP   } ?></td>
  <td align=center><a href="GoodsDelt.php?gid=<?PHP   echo($row[0]); ?>" onClick="if(confirm('确定删除商品?')){return this.href;}return false;" target=_blank>删除</a></td>
  </tr>  
<?PHP
} 
if ($m==0)
{
  print "<tr><td align=center colspan=6>没有商品</td></tr>";
} 
?>
</table>   
</body>