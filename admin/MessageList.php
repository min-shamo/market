<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>消息页面</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">  
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>
<style>
    .message-li:hover,.message-name:hover{
    display: block;
    background: #eee;   
}
</style>
<?PHP 
    session_start(); 
    date_default_timezone_set('Asia/Chongqing'); //系统时间差8小时问题
?>
<body>
            <?php
                include('..\Class\Users.php');
                //从Session变量中读取注册用户信息，并连接到数据库验证
                $objUser = new Users();
                @$UserId=trim($_SESSION["user_id"]);
                @$Pwd=trim($_SESSION["user_pwd"]);
                //连接数据库，进行身份验证
                $objUser->GetUsersInfo($UserId);
            ?>
<div style="margin:0 300px;">
    <p style="font-size:20px;padding:10px"><span class="glyphicon glyphicon-envelope">&nbsp;</span>用户消息</p>
    <div style="display:flex;justify-content: space-between;">
        <div class="message-left" style="width:100%;">
            <ul id="myTab" class="nav nav-tabs">
                <li class="active li-1" style="width:50%;text-align:center"><a href="#">发出的消息</a></li>
                <li class="li-2" style="width:50%;text-align:center"><a href="#">收到的消息</a></li>          
            </ul>
            <div style="height:500px;background:#fff;border:1px solid #eee;overflow:auto">
                <ul class="nav nav-pills nav-stacked">
                    <?PHP 
                        include('..\Class\Message.php');
                        $objmessage = new Message();
                        $results1 = $objmessage->GetMessagelistbyRecipient($objUser->UserId);
                        $results2 = $objmessage->GetMessagelistbySender($objUser->UserId);
                        //var_dump($results);
                        $m=0;
                        $name="";
                        while($row = $results1->fetch_row())
                        {
                            $name=$row[2];
                            $content=$row[3];
                    ?>
                        <li class="message-li1" style="cursor:pointer;display:none">
                        <div style="padding:10px 15px 10px 15px;display:flex;">
                            <div style="width:80%"  data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<?PHP echo($row[3]); ?>" title="留言详情">
                                <div style="display:flex;flex-direction:start;margin-bottom:10px">
                                    <span class="glyphicon glyphicon-user" style="font-size:16px">&nbsp;<?PHP echo($row[2]) ?></span>
                                    <span style="color:#a5a5a5;margin-left:30px"><?PHP echo($row[4]) ?></span>
                                </div>
                                <?PHP 
                                if(strlen($content)>30)
                                {
                                    $content=mb_substr($content,0,30,"utf-8");
                                ?>
                                <span style="font-size:17px;color:#666"><?PHP echo($content) ?>...</span>
                                <?PHP }
                                else{
                                ?>
                                <span style="font-size:17px;color:#666"><?PHP echo($content) ?></span> 
                                <?PHP } ?>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                <button class="btn btn-default" style="width:100px;height:40px;color: white;background: #ff552e" data-toggle="modal" data-id="<?PHP echo($name) ?>" data-target="#myModal-message">回复</button>
                                </div>
                            </div>
                        </div>
                        </li>
                        <?PHP
                        $m++;
                        } 
                        while($row = $results2->fetch_row())
                        {
                            $content=$row[3];
                        ?>
                        <li class="message-li2" style="cursor:pointer">
                        <div style="padding:10px 15px 10px 15px;display:flex;">
                            <div style="width:80%"  data-toggle="popover" data-placement="bottom" data-trigger="hover" data-content="<?PHP echo($row[3]); ?>" title="留言详情">
                                <div style="display:flex;flex-direction:start;margin-bottom:10px">
                                    <span class="glyphicon glyphicon-user" style="font-size:16px">&nbsp;<?PHP echo($row[1]) ?></span>
                                    <span style="color:#a5a5a5;margin-left:30px"><?PHP echo($row[4]) ?></span>
                                </div>
                                <?PHP 
                                if(strlen($content)>30)
                                {
                                    $content=mb_substr($content,0,30,"utf-8");
                                ?>
                                <span style="font-size:17px;color:#666"><?PHP echo($content) ?>...</span>
                                <?PHP }
                                else{
                                ?>
                                <span style="font-size:17px;color:#666"><?PHP echo($content) ?></span> 
                                <?PHP } ?>
                            </div>
                        </div>
                        </li>
                        <?PHP
                        $m++;
                        } 
                        ?>        
                </ul>
            </div>
        </div>
    </div>
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
                <form class="bs-example bs-example-form" role="form" method="POST" action="MessageSave.php">
                <div class="modal-body"> 
                        <div class="form-group input-group" style="padding: 0 30px;width:100%">
                            <span class="input-group-addon" style="width: 85px">接收人：</span>
                            <input type="text" class="form-control" name="recipient" value="" readonly>
                        </div>
                        <div class="form-group input-group" style="padding: 0 30px;width:100%">
                            <span class="input-group-addon" style="width: 85px">发送人：</span>
                            <input type="text" class="form-control" name="sender" value="<?PHP echo($UserId); ?>" readonly>
                        </div>
						<div class="form-group input-group" style="padding: 0 30px;width:100%">
                            <span class="input-group-addon" style="width: 85px">内容：</span>
                            <textarea class="form-control" name="content"></textarea>
                        </div>
                        <div class="form-group input-group" style="padding: 0 30px;width:100%">
                            <span class="input-group-addon" style="width: 85px">时间：</span>
                            <input type="text" class="form-control" name="sendtime" value="<?PHP echo(strftime("%Y-%m-%d %H:%M:%S")); ?>" readonly>
                        </div>
                        
                    
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
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
</div>
</body>
<script>
    $(function() {  
    $("[data-toggle='popover']").popover({  
        html : true,      
        delay:{show:500, hide:1000}
    });  
}); 
    $('.li-1').click(function(){
        $('.message-li2').show();
        $(this).addClass('active');
        $('.li-2').removeClass('active');
        $('.message-li1').hide();
    });
    $('.li-2').click(function(){
        $('.message-li1').show();
        $(this).addClass('active');
        $('.li-1').removeClass('active');
        $('.message-li2').hide();
    })
    $('#myModal-message').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('id') // Extract info from data-* attributes
        var modal = $(this)
        modal.find('.modal-body input[name="recipient"]').val(recipient)
    })
</script>
</html>