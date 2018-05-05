<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>分类列表</title>
	<link rel="stylesheet" href="./css/bootstrap.min.css">  
	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<?PHP session_start(); ?>
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
<div style="margin:0 40px">
    <ul id="myTab" class="nav nav-tabs">
    <?PHP 
    //读取参数, tid表示商品类型编号，flag表示转让或求购类型
    $tid=intval($_GET["tid"]);
    @$flag=intval($_GET["flag"]);
    if($flag==0)
    {
    ?>
        <li class="active"><a data-toggle="tab">
		    转让信息</a></li>
	    <li><a href="list.php?flag=1&tid=<?PHP echo($tid); ?>">求购信息</a></li>
    <?PHP }
    else
    {
    ?>
        <li><a href="list.php?flag=0&tid=<?PHP   echo($tid); ?>">
		    转让信息</a></li>
	    <li class="active"><a data-toggle="tab">求购信息</a></li>
    <?PHP } ?>  
</ul>
<div id="myTabContent" class="tab-content">
    <div class="table-responsive">
	    <table class="table">
		    <caption style="text-align:center">【商品信息 - 
            <?PHP 
            include('Class\GoodsType.php');
            $objType = new GoodsType();
            $objType->GetGoodsTypeInfo($tid);
            echo($objType->TypeName);
            ?>】</caption>
		    <thead>
			    <tr>
				    <th width="25%">商品图片</th>
				    <th width="20%">商品名称</th>
				    <th width="10%">价格</th>
                    <th width="10%">新旧程度</th>
				    <th width="15%">卖家</th>
				    <th width="20%">发布时间</th>
			    </tr>
		    </thead>
		    <tbody>
			<?PHP 
            //设置转让或求购的查询条件
            if($flag==0)
            {
                $cond=" WHERE SaleOrBuy=1";
            }
            else
            {
                $cond=" WHERE SaleOrBuy=2";
            } 

            //设置商品分类查询条件
            if ($tid>0)
            {
                $cond=$cond." AND TypeId=".$tid;
            } 
            // 只查看未结束的商品
            $cond=$cond." AND IsOver=0";
            //创建Goods对象，读取满足条件的记录
            include('Class\Goods.php');
            $obj = new Goods();
            $results = $obj->GetGoodslist($cond);
            $m=0;
            while($row = $results->fetch_row())
            {
            ?>
            <tr><td align=center bgcolor="#FFFFFF"><?PHP   if ($row[5]=="")
            {
            ?><img src="images/noImg.jpg" height=50 border=0>
            <?PHP   }
                else
            {
            ?><img src="user/images/<?PHP     echo($row[5]); ?>" height=50 border=0>
            <?PHP   } ?></td>
            <td><a href="GoodsView.php?gid=<?PHP echo($row[0]); ?>" target=_blank><?PHP   echo($row[3]); ?></a></td>
            <td><?PHP   echo($row[6]); ?></td>
            <td><?PHP   echo($row[8]); ?>&nbsp;</td>
            <td><a href="user/UserView.php?uid=<?PHP echo($row[15]); ?>" target=_blank><?PHP   echo($row[15]); ?></a></td>
            <td><?PHP   echo($row[7]); ?></td>
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
</body>
<script>

</script>
</html>