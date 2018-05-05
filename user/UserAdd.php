<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>注册</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">  
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>
<style>
    .control-label{
        width:20%;
    }
    .col-sm-10{
        width:75%
    }
</style>
<body>
    <img width="100%" height="100%" style="z-index:-1;position:fixed;_position:absolute;left:0;right:0;bottom:0;top:0;" src="../images/back.png">
    <div style="width:550px;margin: 30px auto;padding:30px;background: #eee;">
        <form class="form-horizontal" role="form" method="POST" action="UserSave.php" name="myform" onSubmit="return ChkFields()">
        <h4 style="text-align:center;margin-bottom:20px">新用户注册</h4>
        <input type="hidden" name="isadd" value="new">
        <div class="form-group">
            <label for="userid" class="col-sm-2 control-label">用户名</label><font style="color:red;font-size:20px">*</font>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="userid" placeholder="请输入用户名">
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">密码</label><font style="color:red;font-size:20px">*</font>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password" placeholder="请输入密码">
            </div>
        </div>
        <div class="form-group">
            <label for="password1" class="col-sm-2 control-label">确认密码</label><font style="color:red;font-size:20px">*</font>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password1" placeholder="请确认密码">
            </div>
        </div>
        <div class="form-group">
            <label for="sex" class="col-sm-2 control-label">性别</label>
            <div class="col-sm-10">
                <select class="form-control" name="sex">
                    <option value="0">男</option>
                    <option value="1">女</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="mobile" class="col-sm-2 control-label">手机</label><font style="color:red;font-size:20px">*</font>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="mobile" placeholder="请输入手机号码">
            </div>
        </div>
        <div class="form-group">
        <label class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-default" style="width:100%;height:40px;color: white;background: #ff552e">注册</button>
            </div>
        </div>
    </form>
    </div>
   
</body>
<script>
    function ChkFields() {
    if (document.myform.userid.value=='') {
        window.alert ("请输入用户名！")
        myform.userid.focus()
        return false
    }
    if (document.myform.userid.value.length<=2) {
        window.alert ("请用户名长度必须大于2！")
        myform.userid.focus()
        return false
    }
    // if (document.myform.username.value=='') {        
    //     window.alert ("请输入用户姓名！")
    //     myform.username.focus()
    //     return false
    // }
    if (document.myform.mobile.value=='') {        
        window.alert ("请输入手机号码！")
        myform.mobile.focus()
        return false
    }
    if (document.myform.password.value.length<6) {        
        window.alert ("新密码长度大于等于6！")
        myform.password.focus()
        return false
    }
    if (document.myform.password.value=='') {        
        window.alert ("请输入新密码！")
        myform.password.focus()
        return false
    }
    if (document.myform.password1.value=='') {        
        window.alert ("请确认新密码！")
        myform.password1.focus()
        return false
    }
    if (document.myform.password.value!=document.myform.password1.value) {        
        window.alert ("两次输入的新密吗必须相同！")
        return false
    }
    return true
}
</script>
</html>    