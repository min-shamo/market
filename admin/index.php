<?PHP include('isAdmin.php'); ?>
<html>

<head>
    <meta http-equiv=”Content-Type” content=”text/html; charset=utf-8″> 
    <title>二手交易市场系统后台管理</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">  
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>

<frameset framespacing="20" border="20" bordercolor= "#333399"  frameborder="1">
    <frameset cols="200,*">
        <frame name="contents" target="main" src="left.php" scrolling="auto" frameborder=0>
        <frame name="main" src="BulletinList.php" scrolling="auto" noresize frameborder=0>
    </frameset>
    <noframes>
    <body>

    <p>此网页使用了框架，但您的浏览器不支持框架。</p>

    </body>
    </noframes>
</frameset>

</html>