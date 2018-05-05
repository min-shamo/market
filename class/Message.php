<?PHP
//本类用于保存对表Message的数据库访问操作
//表的每个字段对应类的一个成员变量
class Message
{
  public $MessageId; //记录编号
  public $Recipient; // 接收人
  public $Sender; // 发送人
  public $Content; // 内容
  public $SendTime; //发送时间
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
  function GetMessageInfo($id)
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM Message WHERE MessageId=".$id;
    //打开记录集
    $results = $this->conn->query($sql);
    //读取分类数据
    if($row = $results->fetch_row())
    {
      $this->MessageId=$id;
      $this->Recipient=$row[1];
      $this->Sender=$row[2];
      $this->Content=$row[3];
      $this->SendTime=$row[4];
    } 
    else
    {
      $Recipient="";
    }
  }

  //获取所有信息，返回结果集
  function GetMessagelist()
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM Message";
    //打开记录集
    $results = $this->conn->query($sql);
    return $results;
  } 
  //根据接收人获取信息，返回结果集
  function GetMessagelistbyRecipient($uid)
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM Message WHERE Recipient='" .$uid. "'ORDER BY SendTime DESC";
    //打开记录集
    $results = $this->conn->query($sql);
    return $results;
  } 
  //根据发送人获取信息，返回结果集
  function GetMessagelistbySender($uid)
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM Message WHERE Sender='" .$uid. "'ORDER BY SendTime DESC";
    //打开记录集
    $results = $this->conn->query($sql);
    return $results;
  } 

  //添加留言信息
  function insert()
  {
    $sql="INSERT INTO Message (Recipient, Sender, Content, SendTime) VALUES ('" . $this->Recipient . "','" . $this->Sender
     . "','" . $this->Content . "','" . $this->SendTime . "')";
    //执行SQL语句
    $this->conn->query($sql);
  } 
  //删除留言信息
  function delete($id)
  {
    $sql="DELETE FROM Message WHERE MessageId='".$id."'";
    $this->conn->query($sql);
  } 
}
?>