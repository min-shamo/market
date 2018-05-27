<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>商品详情</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">  
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<?PHP 
    session_start(); 
    date_default_timezone_set('Asia/Chongqing'); //系统时间差8小时问题
?>
<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid" style="margin: 0 50px">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">二手市场</a>
            </div>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default">提交</button>
            </form>
            <?php
                include('Class\Users.php');
                //从Session变量中读取注册用户信息，并连接到数据库验证
                $objUser = new Users();
                @$UserId=trim($_SESSION["user_id"]);
                @$Pwd=trim($_SESSION["user_pwd"]);
                //连接数据库，进行身份验证
                $objUser->GetUsersInfo($UserId);
                if($UserId!="" && $objUser->UserPwd==$Pwd) 
                {
                    if($objUser->UserType==1)
                    {
                        echo("<script>window.location.href='admin/index.php'</script>");
                    }
                    else
                    {
            ?>       
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a>
                        <span class="glyphicon glyphicon-user"></span>&nbsp;<?PHP echo($objUser->UserId); ?></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">个人中心
                    <b class="caret"></b>
                    </a>
                <ul class="dropdown-menu">
				    <li>
                        <a href="user\GoodsAdd.php" target="_blank"><span class="glyphicon glyphicon-plus">&nbsp;</span>发布信息</a>
                    </li>
                    <li>
                        <a href="user\MessageList.php?uid=" target="_blank"><span class="glyphicon glyphicon-envelope">&nbsp;</span>我的消息</a>
                    </li>
                    <li>
                        <a href="user\UserView.php?uid=<?PHP   echo($objUser->UserId); ?>" target="_blank"><span class="glyphicon glyphicon-star">&nbsp;</span>我的商品</a>
                    </li>
                    <li>
                        <a href='user\PwdChange.php?uid=<?PHP   echo($objUser->UserId); ?>' ><span class="glyphicon glyphicon-cog">&nbsp;</span>修改密码</a>
                    </li>
                    <li>
                        <a href="LoginExit.php" onclick="return newswin(this.href)"><span class="glyphicon glyphicon-off">&nbsp;</span>退出登录</a>
                    </li>
                </ul>
            </li>
            </ul>    
            <?PHP 
                    }
                }
            else
                {
            ?>         
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="user/UserAdd.php" target=_blank>
                        <span class="glyphicon glyphicon-user"></span> 注册</a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#myModal">
                        <span class="glyphicon glyphicon-log-in"></span> 登录</a>
                </li>
            </ul>
            <?PHP }?>
        </div>
    </nav>
<div style="display:flex;justify-content: space-around;width:60%;margin:0 auto">
    <div>
		<?PHP 
		include('Class\Goods.php');
		$gid=$_GET["gid"];
		$obj = new Goods();
		$obj->Add_ClickTimes($gid);  // 增加点击次数
		$obj->GetGoodsInfo($gid);  // 获取商品信息
		// include('Class\Users.php');
		// //读取卖家信息
		// $objUser = new Users();
		$objUser->GetUsersInfo($obj->OwnerId);
		//读取商品类型
		include('Class\GoodsType.php');
		$objType = new GoodsType();
		$objType->GetGoodsTypeInfo($obj->TypeId);
		?>
		<?PHP if($obj->ImageURL=="")
		{
		?><img src="images/noImg.png" height=400 border=0>
		<?PHP }
		else
		{
		?><img src="user/images/<?PHP   echo($obj->ImageURL); ?>" height=400 width=400 border=0><br /><br />
		<?PHP } ?>
	</div>
	<div style="width:40%">
	    <p style="text-align:center">商品信息</p>
		<div>
			<label>商品名称：</label>
			<label><?PHP echo($obj->GoodsName); ?></label>
		</div>
		<div>
			<label>商品价格：</label>
			<label style="color:red">￥<?PHP echo($obj->Price); ?></label>
		</div>
		<div>
			<label>&nbsp;所 有 者：</label>
			<label><?PHP echo($obj->OwnerId); ?></label>
		</div>
		<div>
			<label>所属分类：</label>
			<label><?PHP echo($objType->TypeName); ?></label>
		</div>
		<div>
			<label>添加时间：</label>
			<label><?PHP echo($obj->StartTime); ?></label>
		</div>
		<div>
			<label>新旧程度：</label>
			<label><?PHP echo($obj->OldNew); ?></label>
		</div>
		<div>
			<label>商品描述：</label>
			<span style="text-align:left;display:block;word-break:normal;white-space:pre-wrap;word-wrap : break-word ;overflow: hidden ;"><?PHP echo($obj->GoodsDetail); ?></span>
		</div>
		<div style="text-align:center">
			<?PHP 
			if($obj->OwnerId==$UserId || $UserId=="")
			{
			?>
				<button type="submit" class="btn btn-default" onclick="tip(1)">留言</button>
                <button type="submit" class="btn btn-default" onclick="tip(2)">投诉</button>
                <button type="submit" class="btn btn-default" onclick="tip(3)">关注</button>
			<?PHP
			}
			else{
                include('Class\Follow.php');
                $objFollow=new Follow();
                $istrue=$objFollow->HaveFollow($gid,$UserId);
			?>
			    <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#myModal-message">留言</button>
                <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#myModal-message1">投诉</button>
                <button type="submit" class="btn btn-default follow" onclick="follow(<?PHP echo($gid) ?>)" <?PHP if($istrue)echo("disabled='disabled'") ?>><?PHP $v= ($istrue=="true") ? "已关注" : "关注";echo($v) ?></button>
		<?PHP } ?>
		</div>
    </div> 
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        用户登录
                    </h4>
                </div>
                <form class="bs-example bs-example-form" role="form" method="POST" action="putSession.php">
                <div class="modal-body">
                    
                        <div class="form-group input-group" style="padding: 0 30px">
                            <span class="input-group-addon" style="width: 85px">用户名：</span>
                            <input type="text" class="form-control" name="loginname" placeholder="username">
                        </div>
                        <div class="form-group input-group" style="padding: 0 30px">
                            <span class="input-group-addon" style="width: 85px">密码：</span>
                            <input type="password" class="form-control" name="password" placeholder="password">
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
                <form class="bs-example bs-example-form" role="form" method="POST" action="User/MessageSave.php">
                <div class="modal-body">
                    
                        <div class="form-group input-group" style="padding: 0 30px;width:100%">
                            <span class="input-group-addon" style="width: 85px">接收人：</span>
                            <input type="text" class="form-control" name="recipient" value="<?PHP echo($obj->OwnerId); ?>" readonly>
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
    <div class="modal fade" id="myModal-message1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:500px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        投诉
                    </h4>
                </div>
                <form class="bs-example bs-example-form" role="form" method="POST" action="User/MessageSave.php">
                <div class="modal-body">
                        <div class="form-group input-group" style="padding: 0 30px;width:100%">
                            <span class="input-group-addon" style="width: 85px">接收人：</span>
                            <input type="text" class="form-control" name="recipient" value="admin" readonly>
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
<div class="tip" style="display:none;text-align:center;line-height:30px;position:fixed;top:100px;left:50%;transform:translateX(-50%);color:red;width:150px;height:30px;background:#eee"></div>
</body>
<script>
    function tip(n){
        if(n==1)
        {
            alert("本人与游客不可留言！")
        }
        else if(n==2)
        {
            alert("本人与游客不可投诉！")
        }
        else if(n==3)
        {
            alert("本人与游客不可关注！")
        }
		
	}
    function follow(gid)
    {
        var gid=gid;
        $.ajax({
            url:"user/FollowEdit.php",
            type:"GET",
            data:{action:"add",id:gid},
            success:function(result){
                $('.tip').html(result).show();
                setTimeout("$('.tip').hide()", 1000);
                $('.follow').html("已关注").attr("disabled",true);
            }
        })
    }
//     $('#myModal-message').on('show.bs.modal', function (event) {
//         var button = $(event.relatedTarget) // Button that triggered the modal
//         var recipient = button.data('id') // Extract info from data-* attributes
//         var modal = $(this)
//         modal.find('.modal-body input[name="recipient"]').val(recipient)
// })
</script>
</html>