<?PHP include('isAdmin.php'); ?>
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>公告管理</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">  
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script language="javascript">
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
 <p style="font-size:20px;padding:10px;text-align:center">公告管理</p>
<table align=center border="1" cellspacing="0" width="100%">
  <tr>
   <td width="50%" align="center"><strong>题目</strong></td>
   <td width="30%" align="center"><strong>时间</strong></td>
   <td width="10%" align="center"><strong>修改</strong></td>
   <td width="10%" align="center"><strong>选择</strong></td>
  </tr>
<?PHP 
  //依次显示公告信息
  while($row = $results->fetch_row())
  {
    $exist = true;
?>
  <tr>
    <td align="center"><a href="#" data-toggle="modal" data-target="#myModal-edit" onclick="bullet(<?PHP echo($row[0]); ?>,1)"><?PHP echo($row[1]); ?></a></td>
    <td align="center"><?PHP echo($row[3]); ?></td>
    <td align="center"><a href="#" data-toggle="modal" data-target="#myModal-edit" onclick="bullet(<?PHP echo($row[0]); ?>,2)">修改</a></td>
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
<div style="margin-top:20px;text-align:center">
        <input type="button" value="添加公告" data-toggle="modal" data-target="#myModal" name=add>
         &nbsp;&nbsp;<input type="button" value="全 选" onclick="sltAll()" name=button1>
         &nbsp;&nbsp;<input type="button" value="清 空" onclick="sltNull()" name=button2>
          &nbsp;&nbsp;<input type="submit" value="删 除" name="tijiao" onclick="SelectChk()">
</div>
<input type=hidden name="Bulletin">
</form>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        增加新公告
                    </h4>
                </div>
                <form class="bs-example bs-example-form" name="myform" role="form" method="POST" action="BulletinSave.php?action=add" onSubmit="return checkFields()">
                    <div class="modal-body">
                            <div class="form-group input-group" style="padding: 0 30px;width:100%">
                                <span class="input-group-addon" style="width: 85px">题目：</span>
                                <input type="text" class="form-control" name="title">
                            </div>
                            <div class="form-group input-group" style="padding: 0 30px;width:100%">
                                <span class="input-group-addon" style="width: 85px">内容：</span>
                                <textarea class="form-control" name="content"></textarea>
                            </div>                  
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                        </button>
                        <button type="reset" class="btn btn-default">重写</button>
                        <button type="submit" class="btn btn-primary">
                        确定
                        </button>      
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
    <div class="modal fade" id="myModal-edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel2"></h4>
                </div>
                <form class="bs-example bs-example-form" role="form" method="POST" action="BulletinSave.php?action=edit">
                    <div class="modal-body">
                        <div class="form-group input-group" style="padding: 0 30px;width:100%">
                            <span class="input-group-addon" style="width: 85px">题目：</span>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group input-group" style="padding: 0 30px;width:100%">
                            <span class="input-group-addon" style="width: 85px">内容：</span>
                            <textarea class="form-control" name="content"></textarea>
                        </div>                    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                        </button>
                        <button type="reset" class="btn btn-default">重写</button>
                        <button type="submit" class="btn btn-primary">
                        确定
                        </button>      
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
<script>
    function bullet(id,type){
        $.ajax({
            url: 'BulletinEdit.php',
            type: 'get',
            datatype: 'json',
            data: {
                id: id
            },
            success: function(result){
                //console.log(result);
                result=JSON.parse(result);
                $('#myModal-edit').find('input[name="title"]').val(result.title);
                $('#myModal-edit').find('textarea[name="content"]').val(result.content);
                $('#myModal-edit').find('form').attr("action","BulletinSave.php?action=edit&id="+id+"");
                if(type==1){
                    $('#myModalLabel2').html("查看公告");
                    $('#myModal-edit').find('button[type="submit"]').hide();
                    $('#myModal-edit').find('button[type="reset"]').hide();
                    $('#myModal-edit').find('input[name="title"]').attr("readonly","true");
                    $('#myModal-edit').find('textarea[name="content"]').attr("readonly","true");
                }
                else{
                    $('#myModalLabel2').html("修改公告");
                    $('#myModal-edit').find('button').show();
                    $('#myModal-edit').find('input[name="title"]').removeAttr("readonly");
                    $('#myModal-edit').find('textarea[name="content"]').removeAttr("readonly");
                }
            }
        })
    }
    function checkFields()
    {
    if (myform.title.value=="") {
       alert("公告题目不能为空");
       return false
    }
    if (myform.content.value=="") {
       alert("公告内容不能为空");
       return false
    }
    return true;
    }
</script>
</body>
</html>