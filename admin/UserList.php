<?php include('isAdmin.php'); ?>
<html>
<head>
<title>系统用户管理</title>
<link rel="stylesheet" href="../css/bootstrap.min.css">  
<script src="../js/jquery-3.2.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script language="JavaScript">
function newwin(url) {
  var newwin=window.open(url,"newwin","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=400,height=380");
  newwin.focus();
  return false;
}
</script>
<?php date_default_timezone_set('Asia/Chongqing'); //系统时间差8小时问题?>
</head>
<body link="#000080" vlink="#008080">
<h3 align="center">用户列表</h3>
<table width='90%' align=center cellspacing=0 cellpadding=0 border=1 bordercolor="#808080" bordercolordark="#FFFFFF" bordercolorlight="#4DA6FF">
<tr>
<td align="center" width='10%' bgcolor="#eeeeee"><b>用户名</b></td>
<td align="center" width='15%' bgcolor="#eeeeee"><b>用户密码</b></td>
<td align="center" width='15%' bgcolor="#eeeeee"><b>邮箱</b></td>
<td align="center" width='15%' bgcolor="#eeeeee"><b>移动电话</b></td>
<td align="center" width='22%' bgcolor="#eeeeee"><b>操 作</b></td>
</tr>
<?php
  include('..\Class\Users.php');
  $obj = new Users();
  $results = $obj->GetUserslist();
  $rCount=0;
  //循环显示所有的用户数据，同时画出表格
  while ($row = $results->fetch_row()) {
      $rCount++; ?>
<tr>
<td align=center><?php   echo($row[0]);  /*用户名*/ ?></td>
<td align=center><?php   echo($row[1]);  /*用户密码*/ ?></td>
<td align=center><?php   echo($row[5]);  /*邮箱*/ ?></td>
<td align=center><?php   echo($row[3]); /*手机*/?>&nbsp;</td>
<td align="center">
<?php   if ($row[4]!=1) {//不是Admin的话就添加  删除  操作 ?>
<a href=UserDelt.php?userid=<?php     echo($row[0]); ?>  onClick="if(confirm('确定删除此用户?')){return newwin(this.href);}return false;">删除</a>
<a href="#" data-toggle="modal" data-id="<?php echo($row[0]) ?>" data-target="#myModal-message">发送消息</a>
<?php
      } ?>&nbsp;
</td>
</tr>

<?php
  }
  if ($rCount==0) {
      print("<tr align='center'><td colspan=6><font color=red>目前还没有用户记录</font></td></tr>");
  } else {
      print "<tr align='center'><td colspan=6><font color=red>当前共有".trim($rCount)."条用户记录</font></td></tr>";
  }
?>
</table>
    <div class="modal fade" id="myModal-message" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:500px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        留言
                    </h4>
                </div>
                <div class="modal-body">
                    <form class="bs-example bs-example-form" role="form" method="POST" action="MessageSave.php">
                        <div class="form-group input-group" style="padding: 0 30px;width:100%">
                            <span class="input-group-addon" style="width: 85px">接收人：</span>
                            <input type="text" class="form-control" name="recipient" value="" readonly>
                        </div>
                        <div class="form-group input-group" style="padding: 0 30px;width:100%">
                            <span class="input-group-addon" style="width: 85px">发送人：</span>
                            <input type="text" class="form-control" name="sender" value="admin" readonly>
                        </div>
						            <div class="form-group input-group" style="padding: 0 30px;width:100%">
                            <span class="input-group-addon" style="width: 85px">内容：</span>
                            <textarea class="form-control" name="content"></textarea>
                        </div>
                        <div class="form-group input-group" style="padding: 0 30px;width:100%">
                            <span class="input-group-addon" style="width: 85px">时间：</span>
                            <input type="text" class="form-control" name="sendtime" value="<?php echo(strftime("%Y-%m-%d %H:%M:%S")); ?>" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                            </button>
                            <button type="submit" class="btn btn-primary">
                            确定
                            </button>
                        </div>
                    </form>
                </div>
                
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
</body>
<script>
    $('#myModal-message').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('id') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('.modal-body input[name="recipient"]').val(recipient)
})
</script>
</html>