<?PHP 
   include('isAdmin.php'); 
      $uid=$_SESSION["user_id"];
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>修改密码</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">  
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>

<body>
    <img width="100%" height="100%" style="z-index:-1;position:fixed;_position:absolute;left:0;right:0;bottom:0;top:0;" src="../images/back.png">
    <div style="width:550px;margin: 30px auto;padding:30px;background: #fff;">
        <form class="form-horizontal" role="form" method="POST" action="AdminSavePwd.php?aid=<?PHP echo($uid); ?>" name="myform" onSubmit="return ChkFields()">
        <h4 style="text-align:center;margin-bottom:20px">修改密码</h4>
        <div class="form-group">
            <label for="userid" class="col-sm-2 control-label">用户名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="userid" value="<?php echo($uid) ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="oldpassword" class="col-sm-2 control-label">原密码</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="oldpassword" placeholder="请输入原密码">
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">新密码</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password" placeholder="请输入新密码">
            </div>
        </div>
        <div class="form-group">
            <label for="password1" class="col-sm-2 control-label">确认密码</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password1" placeholder="请确认新密码">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default" style="width:100%;height:40px;color: white;background: #ff552e">确定修改</button>
            </div>
        </div>
    </form>
    </div>
   
</body>
<script>
    function ChkFields() {
    if (document.myform.oldpassword.value=='') {
        alert("请输入原始密码！")
        return false
    }
    if (document.myform.password.value.length<6) {   
        alert("新密码长度大于等于6！")
        return false
    }
    if (document.myform.password.value!=document.myform.password1.value) {    
        alert("两次输入的新密码必须相同！")
        return false
    }
    return true
}
</script>
</html>    