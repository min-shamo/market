<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>发布信息</title>
	<link rel="stylesheet" href="../css/bootstrap.min.css">  
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>

<body>
    <?php 
    include('..\Class\Goods.php');
    $gid=intval($_GET["gid"]);
    $obj = new Goods();
    $obj->GetGoodsInfo($gid);
    //读取卖家信息
    include('..\Class\Users.php');
    $objUser = new Users();
    $objUser->GetUsersInfo($obj->OwnerId);
    //读取商品类型
    include('..\Class\GoodsType.php');
    $objType = new GoodsType();
    $objType->GetGoodsTypeInfo($obj->TypeId);
    ?>
    <img width="100%" height="100%" style="z-index:-1;position:fixed;_position:absolute;left:0;right:0;bottom:0;top:0;" src="../images/back.png">
    <div style="width:550px;margin: 30px auto;padding:30px;background: #fff;">
        <form class="form-horizontal" role="form" method="POST" action="GoodsSave.php?action=edit&gid=<?php echo($gid); ?>" name="myform" onSubmit="return ChkFields()">
        <div class="form-group">
            <label for="typeid" class="col-sm-2 control-label">选择分类</label>
            <div class="col-sm-10">
                <select class="form-control" name="typeid">
                <?PHP
                $tid=intval($_GET["tid"]);
                $objType1 = new GoodsType();
                $results = $objType1->GetGoodsTypelist();
                while($row = $results->fetch_row())
                {
                ?><option value="<?PHP   echo($row[0]); ?>" <?PHP   if ($row[0]==$tid)
                {
                ?> selected <?PHP   } ?>><?PHP   echo($row[1]); ?></option>  
                <?PHP   } ?>  
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="goodsname" class="col-sm-2 control-label">商品名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="goodname" value="<?php echo($obj->GoodsName); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="price" class="col-sm-2 control-label">价格</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="price" value="<?php echo($obj->Price); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="old" class="col-sm-2 control-label">新旧程度</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="old" value="<?php echo($obj->OldNew); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="addtime" class="col-sm-2 control-label">添加时间</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="addtime" value="<?php echo($obj->StartTime); ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label for="detail" class="col-sm-2 control-label">商品详情</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="detail" value="<?php echo($obj->GoodsDetail); ?>">
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
</html>