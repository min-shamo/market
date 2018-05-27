<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>我的关注</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
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
                include('..\Class\Users.php');
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
                            <a href="GoodsAdd.php" target="_blank">
                                <span class="glyphicon glyphicon-plus">&nbsp;</span>发布信息</a>
                        </li>
                        <li>
                            <a href="MessageList.php?uid=" target="_blank">
                                <span class="glyphicon glyphicon-envelope">&nbsp;</span>我的消息</a>
                        </li>
                        <li>
                            <a href="UserView.php?uid=<?PHP   echo($objUser->UserId); ?>" target="_blank">
                                <span class="glyphicon glyphicon-star">&nbsp;</span>我的商品</a>
                        </li>
                        <li>
                            <a href='PwdChange.php?uid=<?PHP   echo($objUser->UserId); ?>'>
                                <span class="glyphicon glyphicon-cog">&nbsp;</span>修改密码</a>
                        </li>
                        <li>
                            <a href="../LoginExit.php" onclick="return newswin(this.href)">
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
    <div style="margin:0 300px;">
        <p style="font-size:20px;padding:10px">
            <span class="glyphicon glyphicon-heart">&nbsp;</span>我关注的商品</p>
        <div style="display:flex;justify-content: space-between;">
                <div style="width:100%;height:500px;background:#fff;border:1px solid #eee;overflow:auto">
                    <ul class="nav nav-pills nav-stacked">
                        <?PHP
                        include('..\Class\Follow.php');
                        $objFollow=new Follow();
                        include('..\Class\Goods.php');
                        $obj=new Goods();
                        $exsit=false;
                        $results1=$objFollow->GetFollowlistbyuid($UserId);
                        while ($row = $results1->fetch_row()) {
                            $exsit=true;
                            $fid=$row[0];
                            $gid=$row[1];
                            $obj->GetGoodsInfo($gid);
                            if($obj->ImageURL=="")
                            {
                                $img="../images/noImg.png";
                            }
                            else{
                                $img="images/".$obj->ImageURL;
                            }
                            ?>
                            <li style="width:100%">
                                <div style="display:flex;flex-direction:start;padding:10px 30px;border:1px solid #eee;margin:10px">
                                    <div style="margin-right:30px">
                                        <img src="<?PHP echo($img) ?>" height=100px width=100px>
                                    </div>
                                    <div style="margin-right:30px">
                                        <div style="font-size:18px;margin-bottom:10px;width:200px"><?PHP echo($obj->GoodsName) ?></div>
                                        <div style="color:red; font-size:16px">￥<?PHP echo($obj->Price) ?></div>
                                        <div style="font-size:14px;margin-top:10px">库存：<?PHP echo($obj->Amount) ?>&nbsp;件</div>
                                    </div>  
                                    <div style="margin-right:30px;width:200px;text-align: left;display: block;word-break: normal;white-space: pre-wrap;word-wrap: break-word;overflow: hidden;"><?PHP echo($obj->GoodsDetail) ?></div> 
                                    <div>
                                        <?PHP if($obj->IsOver){
                                            ?>
                                        <button class="btn btn-default" style="margin-bottom:10px" disabled="true">联系卖家</button>
                                        <button class="btn btn-default" style="margin-bottom:10px" onclick="follow(<?PHP echo($fid) ?>)">取消关注</button>
                                        <p style="padding: 6px 12px;">交易结束</P>
                                        <?php }else{
                                            ?>
                                        <button class="btn btn-default" style="margin-bottom:10px">联系卖家</button>
                                        <button class="btn btn-default" style="margin-bottom:10px" onclick="follow(<?PHP echo($fid) ?>)">取消关注</button>
                                        <?php
                                        } ?>
                                    </div> 
                                </div>
                            </li>
                            <?PHP
                        }
                        if(!$exsit){ ?>
                            <li style="width:100%">
                                <div style="text-align:center;padding:10px">
                                    暂无关注商品
                                </div>
                            </li>
                        <?PHP
                        }
                    ?>
                    </ul>
                </div>
        </div>
    </div>
    <div class="tip" style="display:none;text-align:center;line-height:30px;position:fixed;top:100px;left:50%;transform:translateX(-50%);color:red;width:150px;height:30px;background:#eee"></div>
</body>
<script>
    function follow(fid)
    {
        var fid=fid;
        $.ajax({
            url:"FollowEdit.php",
            type:"GET",
            data:{action:"delt",id:fid},
            success:function(result){
                $('.tip').html(result).show();
                setTimeout("$('.tip').hide()", 1000);
                location.reload();
            }
        })
    }
</script>
</html>