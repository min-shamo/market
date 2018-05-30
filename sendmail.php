<?php  
require_once('Class\smtp.class.php');  
$uid=$_POST['uid'];
$email=$_POST['email'];
include('Class\users.php');
$obj=new Users();
$obj->GetUsersInfo($uid);
if($obj->UserId==""){
    echo("该用户不存在！");
}
else if($email!=$obj->Email)
{
    echo("此邮箱与注册邮箱不符！");
}
else if($email==$obj->Email)
{
    $mail = new MySendMail();
    //设置smtp服务器，到服务器的SSL连接
    $mail->setServer("smtp.163.com", "m15715902838@163.com", "hong031402508");
    $mail->setFrom("m15715902838@163.com"); //设置发件人
    
    $mail->setReceiver($email); //设置收件人，多个收件人，调用多次
    $mail->setMail("重置密码", "<html>test</html>"); //设置邮件主题、内容
    $mail->sendMail(); //发送
    echo("邮件已发送成功，请注意查收！");
}


?>  