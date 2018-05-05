<?PHP
 // session_start();
  include("isuser.php");
  date_default_timezone_set('Asia/Chongqing'); //系统时间差8小时问题
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"> 
	<title>发布信息</title>
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
        <form class="form-horizontal" role="form" method="POST" action="GoodsSave.php?action=add" name="myform" onSubmit="return ChkFields()">
        <h4 style="text-align:center;margin-bottom:20px">发布新商品</h4>
        <div class="form-group">
            <label for="typeid" class="col-sm-2 control-label">选择分类</label>
            <div class="col-sm-10">
                <select class="form-control" name="typeid">
                <?PHP
                include('..\Class\GoodsType.php');
                $tid=intval($_GET["tid"]);
                $obj = new GoodsType();
                $results = $obj->GetGoodsTypelist();
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
            <label for="goodsname" class="col-sm-2 control-label">商品名称</label><font style="color:red;font-size:20px">*</font>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="goodname" placeholder="请输入商品名称">
            </div>
        </div>
        <div class="form-group">
            <label for="price" class="col-sm-2 control-label">价格</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="price" placeholder="请输入价格">
            </div>
        </div>
        <div class="form-group">
            <label for="old" class="col-sm-2 control-label">新旧程度</label><font style="color:red;font-size:20px">*</font>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="old" placeholder="请输入新旧程度">
            </div>
        </div>
        <div class="form-group">
            <label for="saleorbuy" class="col-sm-2 control-label">交易类型</label>
            <div class="col-sm-10">
                <select class="form-control" name="saleorbuy">
                    <option value="1">转让</option>
                    <option value="2">求购</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="addtime" class="col-sm-2 control-label">添加时间</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="addtime" value="<?PHP echo(strftime("%Y-%m-%d %H:%M:%S")); ?>" readonly>
            </div>
        </div>
        <div class="form-group">
            <label for="detail" class="col-sm-2 control-label">商品详情</label><font style="color:red;font-size:20px">*</font>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="detail" placeholder="请输入商品详情">
            </div>
        </div>
        <div class="form-group">
            <label for="goodimage" class="col-sm-2 control-label">商品图片</label><font style="color:red;font-size:20px">*</font>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="goodimage" readonly>
            </div>
        </div>
        <div class="form-group">
            <label for="goodimage" class="col-sm-2 control-label">&nbsp;&nbsp;</label>
            <div class="col-sm-10">
                <iframe frameborder="0" height="40" width="100%" scrolling="no" src="upload.php" ></iframe>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">&nbsp;&nbsp;</label>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-default" style="width:100%;height:40px;color: white;background: #ff552e">发布</button>
            </div>
        </div>
    </form>
    </div>
</body>
</html>