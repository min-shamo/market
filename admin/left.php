<html>

<head>
    <title>后台管理</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/jquery-3.2.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <base target="main">
    <style>
        .tag{
            padding:5px 20px;
        }
        .tag:hover{
            background:orange;
        }
        td{
            padding:10px;
        }
    </style>
</head>

<body style="background:#eee">
  <!--bgcolor="#eeeeee":设置左边那部分的颜色-->
    <div style="padding:10px">
        <center>
            <table width="100%" height="300">
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <font color="#000080">系统设置</font>
                    </td>
                </tr>
                <tr>
                    <td class="tag">
                        <a href="TypeList.php?tid=&Oper=" target="main">商品分类</a>
                    </td>
                </tr>
                <tr>
                    <td class="tag">
                            <a href="BulletinList.php">公告管理</a>
                    </td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <font color="#000080">商品管理</font>
                    </td>
                </tr>
                <?PHP
                include('..\Class\GoodsType.php');
                $objType = new GoodsType();
                $results = $objType->GetGoodsTypelist();
                while($row = $results->fetch_row())  {
              ?>
                <tr>
                    <td class="tag">
                        <a href="GoodsList.php?type=<?PHP echo($row[0]); ?>" target="main">
                            <?PHP   echo($row[1]); ?>
                        </a>
                    </td>
                </tr>
              <?PHP 
          } 
      ?>
                <tr>
                    <td></td>
                </tr>
                <tr>
                    <td>
                        <font color="#000080">用户管理</font>
                    </td>
                </tr>
                <tr>
                    <td class="tag">
                        <a href="UserList.php?flag=0" target="main">用户列表</a>
                    </td>
                </tr>
                <tr>
                    <td class="tag">
                        <a href="MessageList.php" target="main">用户来信</a>
                    </td>
                </tr>
                <tr>
                    <td class="tag">
                        <a href="AdminPwdChange.php" target="main">密码修改</a>
                    </td>
                </tr>

                <tr>
                    <td>
                        <a href="logout.php" target="_parent">退出</a>
                    </td>
                  <!--target="_parent":退出系统时跳出frame框架-->
                </tr>

            </table>
        </center>
    </div>
</body>

</html>