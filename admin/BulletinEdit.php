<?PHP 
    include('isAdmin.php'); 
    $id=$_GET['id'];
    include('..\Class\Bulletin.php');
    $obj=new Bulletin();
    $obj->GetBulletinInfo($id);
    if($obj->Id==0)
    {
        echo ("无此公告！");
    }
    else{
        $data = array("title"=>$obj->Title,"content"=>$obj->Content);
        echo json_encode($data);
    }
?>
