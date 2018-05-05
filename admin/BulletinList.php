<?PHP include('isAdmin.php'); ?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>公告管理</title>
<link href="../style.css" rel="stylesheet">
<script language="javascript">
function BulletinWin(url) {
  var oth="toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,left=200,top=200";
  oth = oth+",width=400,height=300";
  var BulletinWin = window.open(url,"BulletinWin",oth);
  BulletinWin.focus();
  return false;
}

function SelectChk()  //删除
{
  var s = false; //用来记录是否存在被选中的复选框
  var Bulletinid, n=0; 
  var strid, strurl;
  var nn = self.document.all.item("Bulletin"); //返回复选框Bulletin的数量
  for (j=0; j<nn.length; j++) {
   // if (self.document.all.item("Bulletin",j).checked) {
    if (nn[j].checked) {
      n = n + 1;
      s = true;
      //Bulletinid = self.document.all.item("Bulletin",j).id+"";  //转换为字符串
      Bulletinid = nn[j].id+"";  //转换为字符串
      //生成要删除公告编号的列表
      if(n==1) {
        strid = Bulletinid;
      }
      else {
        strid = strid + "," + Bulletinid;
      }
    }
  }
  strurl = "BulletinDelt.php?id=" + strid;
  if(!s) {
    alert("请选择要删除的公告!");
    return false;
  }    
  if (confirm("你确定要删除这些公告吗？")) {
    form1.action = strurl;
    form1.submit();
  }
}

function sltAll() //全选
{
    var nn = self.document.all.item("Bulletin");
    for(j=0;j<nn.length;j++)
    {
        //self.document.all.item("Bulletin",j).checked = true;
    nn[j].checked = true;
    }
}
function sltNull()  //清空
{
    var nn = self.document.all.item("Bulletin");
    for(j=0;j<nn.length;j++)
    {
        nn[j].checked = false;
    }
}
</script>
</head>
<body link="#000080" vlink="#080080">
<form name="form1" method="POST">
<?PHP
  include('..\Class\Bulletin.php');
  //查询表Bulletin中的公告信息
  $obj = new Bulletin();
  $results = $obj->GetBulletinlistall();
  $exist = false;
?>
<p align=center><font style='FONT-SIZE:12pt' color="#000080"><b>公 告 管 理</b></font></p>
<table align=center border="1" cellspacing="0" width="100%" bordercolorlight="#4DA6FF" bordercolordark="#ECF5FF" style='FONT-SIZE: 9pt'>
  <tr>
   <td width="50%" align="center" bgcolor="#eeeeee"><strong>题目</strong></td>
   <td width="30%" align="center" bgcolor="#eeeeee"><strong>时间</strong></td>
   <td width="10%" align="center"  bgcolor="#eeeeee"><strong>修改</strong></td>
   <td width="10%" align="center"  bgcolor="#eeeeee"><strong>选择</strong></td>
  </tr>
<?PHP 
  //依次显示公告信息
  while($row = $results->fetch_row())
  {
    $exist = true;
?>
  <tr>
    <td><a href="../BulletinView.php?id=<?PHP echo($row[0]); ?>" onClick="return BulletinWin(this.href)"><?PHP echo($row[1]); ?></a></td>
    <td align="center"><?PHP echo($row[3]); ?></td>
    <td align="center"><a href="BulletinEdit.php?id=<?PHP echo($row[0]); ?>" onClick="return BulletinWin(this.href)">修改</a></td>
    <td align="center"><input type="checkbox" name="Bulletin" id="<?PHP echo($row[0]); ?>" style="font-size: 9pt"></td>
  </tr>
<?PHP 
  } 
  if (!$exist)
  {
    print "<tr><td colspan=5 align=center>目前还没有公告。</td></tr></table>";
  }
?>
</table>
    <p align="center">
        <input type="button" value="添加公告" onclick="BulletinWin('BulletinAdd.php')" name=add>
         &nbsp;&nbsp;<input type="button" value="全 选" onclick="sltAll()" name=button1>
         &nbsp;&nbsp;<input type="button" value="清 空" onclick="sltNull()" name=button2>
          &nbsp;&nbsp;<input type="submit" value="删 除" name="tijiao" onclick="SelectChk()">
<br><br>
<input type=hidden name="Bulletin">
</form>
</body>
</html>