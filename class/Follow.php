<?PHP
//本类用于保存对表Message的数据库访问操作
//表的每个字段对应类的一个成员变量
class Follow
{
  public $FollowId; //记录编号
  public $GoodsId; // 商品Id
  public $FollowMan; // 关注人
  public $FollowTime; // 关注时间
  var $conn;

  function __construct() {
    // 连接数据库
    $this->conn = mysqli_connect("localhost", "root", "", "market"); 
    mysqli_query($this->conn, "SET NAMES utf-8");
  }
        
  function __destruct() {
    // 关闭连接
    mysqli_close($this->conn);
  }

  //获取信息
  function GetFollowInfo($id)
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM Follow WHERE FollowId=".$id;
    //打开记录集
    $results = $this->conn->query($sql);
    //读取分类数据
    if($row = $results->fetch_row())
    {
      $this->FollowId=$id;
      $this->GoodsId=$row[1];
      $this->FollowMan=$row[2];
      $this->FollowTime=$row[3];
    } 
    else
    {
      $FollowId="";
    }
  }

  //获取所有信息，返回结果集
  function GetFollowlist()
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM Follow";
    //打开记录集
    $results = $this->conn->query($sql);
    return $results;
  } 
  //根据接收人获取信息，返回结果集
  function GetFollowlistbyuid($uid)
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM Follow WHERE FollowMan='" .$uid. "'ORDER BY FollowTime DESC";
    //打开记录集
    $results = $this->conn->query($sql);
    return $results;
  } 
  // 判断指定关注是否存在
  function HaveFollow($id,$uid)
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM Follow WHERE GoodsId='".$id."' AND FollowMan='".$uid."'";
    //打开记录集
    $results = $this->conn->query($sql);
    if($row = $results->fetch_row()) 
      $exist=true;
    else
      $exist=false;
    return $exist;
  } 

  //添加关注信息
  function insert()
  {
    $sql="INSERT INTO Follow (GoodsId, FollowMan, FollowTime) VALUES ('" . $this->GoodsId . "','" . $this->FollowMan
     . "','" . $this->FollowTime . "')";
    //执行SQL语句
    $this->conn->query($sql);
  } 
  //删除关注信息
  function delete($id)
  {
    $sql="DELETE FROM Follow WHERE FollowId='".$id."'";
    $this->conn->query($sql);
  } 
}
?>