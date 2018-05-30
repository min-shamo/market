<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>demo</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- jQuery (Bootstrap 的所有 JavaScript 插件都依赖 jQuery，所以必须放在前边) -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <!-- 加载 Bootstrap 的所有 JavaScript 插件。你也可以根据需要只加载单个插件。 -->
    <script src="js/bootstrap.min.js"></script>
    <!-- HTML5 shim 和 Respond.js 是为了让 IE8 支持 HTML5 元素和媒体查询（media queries）功能 -->
    <!-- 警告：通过 file:// 协议（就是直接将 html 页面拖拽到浏览器中）访问页面时 Respond.js 不起作用 -->
    <!--[if lt IE 9]>
      <script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<?PHP session_start(); ?>

<body>
    <nav class="navbar navbar-default" role="navigation">
        <div class="container-fluid" style="margin: 0 50px">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">二手市场</a>
            </div>
            <form class="navbar-form navbar-left" role="search" method="post" action="list.php?tid=">
                <div class="form-group">
                    <input type="text" class="form-control" name="search" placeholder="Search">
                </div>
                <button type="submit" class="btn btn-default" onclick="location='list.php'">提交</button>
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
                    if($objUser->UserType==1)//管理员判断
                    {
                        echo("<script>window.location.href = 'admin/index.php'</script>");
                    }
                    else
                    {
            ?>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a>
                        <span class="glyphicon glyphicon-user"></span>&nbsp;
                        <?PHP echo($objUser->UserId); ?>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">个人中心
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="user\GoodsAdd.php" target="_blank">
                                <span class="glyphicon glyphicon-plus">&nbsp;</span>发布信息</a>
                        </li>
                        <li>
                            <a href="user\MessageList.php?uid=" target="_blank">
                                <span class="glyphicon glyphicon-envelope">&nbsp;</span>我的消息</a>
                        </li>
                        <li>
                            <a href="user\UserView.php?uid=<?PHP   echo($objUser->UserId); ?>" target="_blank">
                                <span class="glyphicon glyphicon-star">&nbsp;</span>我的商品</a>
                        </li>
                        <li>
                            <a href="user\FollowList.php?uid=<?PHP  echo($objUser->UserId); ?>" target="_blank">
                                <span class="glyphicon glyphicon-heart">&nbsp;</span>关注的商品</a>
                        </li>
                        <li>
                            <a href='user\PwdChange.php?uid=<?PHP   echo($objUser->UserId); ?>'>
                                <span class="glyphicon glyphicon-cog">&nbsp;</span>修改密码</a>
                        </li>
                        <li>
                            <a href="LoginExit.php">
                                <span class="glyphicon glyphicon-off">&nbsp;</span>退出登录</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <?PHP 
                    }
                }
            else
                {
                    if($UserId!=""&&$Pwd!="")
                    {
                        echo("<script>alert('登录失败！')</script>");
                        $_SESSION["user_id"]="";
                        $_SESSION["user_pwd"]="";
                    }
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
                <form class="bs-example bs-example-form" role="form" method="POST" action="putSession.php" onsubmit="return check()">
                    <div class="modal-body">
                        <div class="form-group input-group" style="padding: 0 30px">
                            <span class="input-group-addon" style="width: 85px">用户名：</span>
                            <input type="text" class="form-control" name="loginname" placeholder="username">
                        </div>
                        <div class="form-group input-group" style="padding: 0 30px">
                            <span class="input-group-addon" style="width: 85px">密码：</span>
                            <input type="password" class="form-control" name="password" placeholder="password">
                        </div>
                        <div style="padding: 0 30px;color:blue;cursor:pointer">
                            <span id="find" data-toggle="modal" data-target="#Modal-find">忘记密码？</span>
                        </div>
                        <div class="tip" style="display:none;text-align:center;line-height:30px;position:fixed;top:20px;left:50%;transform:translateX(-50%);color:red;width:150px;height:30px;background:#eee"></div>
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
    <div class="modal fade" id="Modal-find" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:400px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="ModalLabel">
                        重置密码
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group input-group" style="padding: 0 30px">
                        <span class="input-group-addon">请输入用户和注册的邮箱：</span>
                    </div>
                    <div class="form-group input-group" style="padding: 0 30px;width:100%">
                        <input type="text" class="form-control" id="uid" placeholder="username">
                    </div>
                    <div class="form-group input-group" style="padding: 0 30px;width:100%">
                        <input type="text" class="form-control" id="email" placeholder="email">
                        <span id="chkmsg" style="color:red"></span></p>
                    </div>
                    <div class="tip1" style="display:none;text-align:center;line-height:30px;position:fixed;top:20px;left:50%;transform:translateX(-50%);color:red;width:200px;height:30px;background:#eee"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭
                    </button>
                    <button type="submit" class="btn btn-primary email-btn">
                        确定
                    </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal -->
    </div>
    <div style="width: 20%;padding:10px 20px;">
        <div style="height:180px">
            <p>最新公告</p>
            <ul class="nav nav-pills nav-stacked">
                <?PHP
                    include('Class\Bulletin.php');
                    $obj = new Bulletin();
                    $results = $obj->GetBulletinlist(1);
                    $exist=false;
                    //使用循环语句,依次显示分类信息
                    while($row = $results->fetch_row())
                    {
                    $exist = true;
                    $title=$row[1];
                    //显示新闻标题以及网页链接
                    if(strlen($title)>8)//设置公告标题显示长度
                    {
                        $title=mb_substr($title,0,8,"utf-8");
                    ?>
                <li>
                    <h5 style="text-align:center"><?PHP echo $title; ?>......</h5>
                </li>
                <?PHP  } 
                    else{
                    ?>
                <li>
                    <h5 style="text-align:center"><?PHP echo $title; ?></h5>
                </li>
                <?PHP } ?>
                <li>
                    <span style="text-align:left;margin:0 auto;width:80%;display:block;word-break:normal;white-space:pre-wrap;word-wrap: break-word;overflow: hidden;"><?PHP echo($row[2]); ?></span>
                </li>
                <?PHP } 
                    if (!$exist)
                    {
                    print "暂且没有公告";
                    }
                    ?>
            </ul>
        </div>
        <div style="height:250px">
            <p>商品分类</p>
            <ul class="nav nav-pills nav-stacked">
                <?PHP
            //从表GoodsType中读取商品类别数据
            include('Class\GoodsType.php');
            $gtype = new GoodsType();
            $results = $gtype->GetGoodsTypelist();
            //使用循环语句,依次显示分类信息
            while($row = $results->fetch_row())
            {  
            ?>
                <li style="height:25px">
                    <a style="display:inline" href="List.php?tid=<?PHP echo($row[0]); ?>" target="_blank">
                        <?PHP echo($row[1]); ?>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div style="height:180px">
            <p>最受关注商品TOP5</p>
            <ul class="nav nav-pills nav-stacked">
                <?PHP 
            include('Class\Goods.php');
            $objGoods = new Goods();
            //查询前10个点击次数(ClickTimes)最多的\未结束的商品信息
            $results = $objGoods->GetTopnMaxClick(5);
            $exist = false;
            //如果结果集为空,则显示提示信息

            //依次显示结果集中的商品信息
            while($row = $results->fetch_row())
            {
            $exist = true;
            ?>
                <li style="height:25px">
                    <a style="display:inline;" href="GoodsView.php?gid=<?PHP     echo($row[0]); ?>" target="_blank">
                        <?PHP     echo($row[3]); ?>
                    </a>(浏览
                    <font color="red">
                        <?PHP     echo($row[16]); ?>
                    </font>次)
                </li>
                <?PHP 
            } 
            if (!$exist)
            {
            print "暂且没有商品";
            }
            ?>
            </ul>
        </div>
        <div style="height:180px">
            <p>最新求购信息</p>
            <ul class="nav nav-pills nav-stacked">
                <?PHP 
            $results1 = $objGoods->GetTopnNewBuys(5);
            $exist = false;
            //如果结果集为空,则显示提示信息

            //依次显示结果集中的商品信息
            while($row = $results1->fetch_row())
            {
            $exist = true;
            ?>
                <li style="height:25px">
                    <a style="display:inline;" href="GoodsView.php?gid=<?PHP     echo($row[0]); ?>" target="_blank">
                        <?PHP     echo($row[3]); ?>
                    </a>(
                    <font>
                        <?PHP     echo($row[7]); ?>
                    </font>)
                </li>
                <?PHP 
            } 
            if (!$exist)
            {
            print "暂且没有信息";
            }
            ?>
            </ul>
        </div>
    </div>
    <div style="width: 75%;position:absolute;top:70px;right:20px;bottom:20px;">
        <div style="display:flex;justify-content: space-between;">
            <div id="myCarousel" class="carousel slide" style="width:100%">
                <!-- 轮播（Carousel）指标 -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>

                <!-- 轮播（Carousel）项目 -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="images/1.jpg" alt="First slide">
                    </div>
                    <div class="item">
                        <img src="images/2.jpg" alt="Second slide">
                    </div>
                    <div class="item">
                        <img src="images/3.jpg" alt="Third slide">
                    </div>
                </div>
                <!-- 轮播（Carousel）导航 -->
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <p style="margin:10px 0 0 0">最新商品</p>
        <div style="display: flex;justify-content: flex-start;flex-wrap:wrap; margin: 10px 0 10px 0">
            <?PHP
            $objGoods = new Goods();
            //查询前10个点击次数(ClickTimes)最多的\未结束的商品信息
            $results = $objGoods->GetTopnNewGoods(8);
            $exist = false;
            //如果结果集为空,则显示提示信息

            //依次显示结果集中的商品信息
            while($row = $results->fetch_row())
            {
            $exist = true;
            ?>
            <div class="good" style="cursor:pointer;width: 24%;margin:10px 1% 0 0;text-align: center;box-shadow:0 0 5px #000" onclick="window.open('GoodsView.php?gid=<?PHP echo($row[0]); ?>')">
                <?PHP 
            //显示商品图片
            if (!isset($row[5]) || trim($row[5])=="")
            {
            ?>
                <img border="0" src="images/noImg.png" width="100%" height="220">
                <?PHP 
            }
            else
            {
            ?>
                <a>
                    <img border="0" src="user/images/<?PHP  echo($row[5]); ?>" width="100%" height="220">
                </a>
                <?PHP 
            } 
            ?>
                <div style="font-size:20px">
                    <?PHP     echo($row[3]); ?>
                </div>
                <div style="color:red;font-size:16px">￥
                    <?PHP     echo($row[6]); ?>
                </div>
            </div>
            <?PHP 
            } 
            if (!$exist)
            {
            print "暂且没有商品";
            }
            ?>
        </div>
    </div>
    <div class="tip2" style="display:none;text-align:center;line-height:30px;position:fixed;top:20px;left:50%;transform:translateX(-50%);color:red;width:200px;height:30px;background:#eee"></div>
</body>
<script>
    $(function () {
        $("#myCarousel").carousel('cycle');
    });
    $('.good').mouseover(function(){
        $(this).css("background","#eee");
        $(this).find('img').css("opacity","0.7")
    })
    $('.good').mouseout(function(){
        $(this).css("background","#fff");
        $(this).find('img').css("opacity","1")
    })
    $('#find').click(function(){
        $('.close').click();
    })
    function check(){
        if($('#myModal').find('input[name="loginname"]').val()=="")
        {
            $('.tip').html("请输入用户名！").show();
            setTimeout("$('.tip').hide()", 1000);
            return false;
        }
        else if($('#myModal').find('input[name="password"]').val()=="")
        {
            $('.tip').html("请输入密码！").show();
            setTimeout("$('.tip').hide()", 1000);
            return false;
        }
        return true;
    }
    $(function(){
	$(".email-btn").click(function(){
		var email = $("#email").val();
        var uid = $("#uid").val();
		var preg = /^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/; //匹配Email
        if(uid=='')
        {
            $(".tip1").html("请输入用户名！").show();
            setTimeout("$('.tip1').hide()", 1000);
        }
		else if(email=='' || !preg.test(email)){
			$(".tip1").html("请填写正确的邮箱！").show();
            setTimeout("$('.tip1').hide()", 1000);
		}else{
			$.ajax({
                url:'sendmail.php',
                type:'post',
                data:{
                    uid:uid,email:email
                },
                success:function(result){
                    $('.close').click();
                    $('.tip2').html(result).show();
                    setTimeout("$('.tip2').hide()", 3000);
                }
            })
		}
	});
})
</script>

</html>