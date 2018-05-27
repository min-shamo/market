<?PHP
    session_start();
    date_default_timezone_set('Asia/Chongqing');
    if (isset($_GET['action']))  
    {  
        switch($_GET['action'])  
        {  
            case "add":add($_GET['id']);break;  
            case "delt":delt($_GET['id']);break;  
            default:break;  
        }  
    }  

    function add($id){
        include('..\Class\Follow.php');
        $obj =new Follow();
        $obj->GoodsId=$id;
        $obj->FollowMan=trim($_SESSION["user_id"]);
        $obj->FollowTime=strftime("%Y-%m-%d %H:%M:%S");
        $obj->insert();
        echo("关注成功！");
    }
    function delt($id){
        include('..\Class\Follow.php');
        $obj =new Follow();
        $obj->delete($id);
        echo("取消成功！");
    }
?>