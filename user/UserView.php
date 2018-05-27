<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>我的商品列表</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">  
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>
<body>
<?php session_start(); ?>
<div>
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
                        <a href="GoodsAdd.php" target="_blank"><span class="glyphicon glyphicon-plus">&nbsp;</span>发布信息</a>
                    </li>
                    <li>
                        <a href="MessageList.php?uid=" target="_blank"><span class="glyphicon glyphicon-envelope">&nbsp;</span>我的消息</a>
                    </li>
                    <li>
                        <a href="UserView.php?uid=<?PHP   echo($objUser->UserId); ?>" target="_blank"><span class="glyphicon glyphicon-star">&nbsp;</span>我的商品</a>
                    </li>
                    <li>
                        <a href='PwdChange.php?uid=<?PHP   echo($objUser->UserId); ?>' ><span class="glyphicon glyphicon-cog">&nbsp;</span>修改密码</a>
                    </li>
                    <li>
                        <a href="..\LoginExit.php" onclick="return newswin(this.href)"><span class="glyphicon glyphicon-off">&nbsp;</span>退出登录</a>
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
                    <a href="../user/UserAdd.php" target=_blank>
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
    <div style="margin:0 40px">
    <ul id="myTab" class="nav nav-tabs">
    <?php 
    //读取参数, flag表示转让或求购类型
    @$flag=intval($_GET["flag"]);
    //设置转让或求购的查询条件
    if ($flag==0)
    {
        $cond=" WHERE SaleOrBuy=1";
    }
    else
    {
        $cond=" WHERE SaleOrBuy=2";
    } 
    //设置商品分类查询条件
    if (@$tid>0)  //tid 是什么 TypeId
    {
        $cond=$cond." AND TypeId=".$tid;
    } 
    // 只查看未结束的商品
    $uid=$_GET["uid"];
    $cond=$cond." AND OwnerId='".$uid."'";
    //创建Goods对象，读取满足条件的记录
    include('..\Class\Goods.php');
    $obj = new Goods();
    $results = $obj->GetGoodslist($cond);
    if ($flag==0)
    {
    ?>
        <li class="active"><a data-toggle="tab">
		    转让信息</a></li>
	    <li><a href="UserView.php?flag=1&uid=<?php echo($objUser->UserId); ?>">求购信息</a></li>
    <?PHP }
    else
    {
    ?>
        <li><a href="UserView.php?flag=0&uid=<?php echo($objUser->UserId); ?>">
		    转让信息</a></li>
	    <li class="active"><a data-toggle="tab">求购信息</a></li>
    <?PHP } ?>  
    </ul>
<div id="myTabContent" class="tab-content">
    <div class="table-responsive">
	    <table class="table">
		    <caption style="text-align:center">【<?php echo($objUser->UserId); ?>的商品信息】</caption>
		    <thead>
			    <tr>
				    <th width="25%" style="text-align:center">商品图片</th>
				    <th width="20%">商品名称</th>
				    <th width="10%">价格</th>
                    <th width="10%">新旧程度</th>
                    <th width="20%">发布时间</th>
                    <th width="15%" style="text-align:center">操作</th>
			    </tr>
		    </thead>
		    <tbody>
			<?php 
            $m=0;
            while($row = $results->fetch_row())
            {
            ?>
            <tr><td align=center bgcolor="#FFFFFF"><?php   if ($row[5]=="")
            {
            ?><img src="../images/noImg.png" height=50 border=0>
            <?php   }
            else
            {
            ?><img src="images/<?php     echo($row[5]); ?>" height=50 border=0>
            <?php   } ?></td>
            <td><a href="../GoodsView.php?gid=<?PHP echo($row[0]); ?>" target=_blank><?PHP   echo($row[3]); ?></a></td>
            <td><?PHP   echo($row[6]); ?></td>
            <td><?PHP   echo($row[8]); ?>&nbsp;</td>
            <td><?PHP   echo($row[7]); ?></td>
            <td align=center bgcolor="#FFFFFF">
            <?php   if ($row[14]==1)
            {
            ?>
                已结束
            <?php   }
                else
            {
            ?>
            <?php if ($row[15]==@$_SESSION["user_id"])
                {
            ?>
            <a href="GoodsEdit.php?gid=<?php echo($row[0]); ?>" target=_blank>修改</a>&nbsp;
            <a href="GoodsDelt.php?gid=<?php echo($row[0]); ?>" target=_blank>删除</a>&nbsp;
            <a href="GoodsOver.php?gid=<?php echo($row[0]); ?>" target=_blank>结束</a>
            <?php     } ?>
            <?php   } ?></td>
            </tr>  
            <?PHP   $m=$m+1;
            } 
            if ($m==0)
            {
                print "<tr><td bgcolor=#FFFFFF align=center colspan=6>暂无商品信息</td></tr>";
            }  
            ?>
		    </tbody>
        </table>
    </div>  	
</div>
</div>
</div>
</body>
<script>

</script>
</html>