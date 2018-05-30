<?PHP
//本类用于保存对表Users的数据库访问操作
//表的每个字段对应类的一个成员变量
class Users  
{
    public $UserId;        // 用户名
    public $UserPwd;    // 密码
    //public $Name;        // 姓名
    public $Sex;        // 性别
    //public $Address;    // 地址
    //public $Postcode;   // 邮编
    public $Email;        // 电子邮件
    //public $Telephone;    // 电话
    public $Mobile;        // 手机
    public $UserType;    // 用户类型
    public $getpasstime;
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


  //获取个人信息
  function GetUsersInfo($uid)
  {
    $sql="SELECT * FROM Users WHERE UserId='".$uid."'";
    $results = $this->conn->query($sql);
    if($row = $results->fetch_row())  {
      $this->UserId=$uid;
      $this->UserPwd=$row[1];
      //$this->Name=$row[2];
      $this->Sex=$row[2];
      //$this->Address=$row[4];
      //$this->Postcode=$row[5];
      $this->Email=$row[5];
      $this->getpasstime=$row[6];
      //$this->Telephone=$row[7];
      $this->Mobile=$row[3];
      $this->UserType=$row[4];
    }
    else
    {
      $this->UserId = "";
      $this->UserPwd = "error";
    }
      
  } 

  //获取所有个人信息，返回结果集
  function GetUserslist()
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM Users";
    //打开记录集
    $results = $this->conn->query($sql);
    return $results;
  } 

  function GetTopnActiveUser($n)
  {
    //设置查询的SELECT语句
    $sql="SELECT u.UserId, Count(g.GoodsId) AS cc "
    ." FROM Users u INNER JOIN Goods g ON u.UserId=g.OwnerId "
    ." GROUP BY u.UserId "
    ." ORDER BY Count(g.GoodsId) DESC LIMIT 0," . $n;
    //打开记录集
    $results = $this->conn->query($sql);
    return $results;
  } 

  // 判断指定用户名是否存在
  function HaveUsers($uid)
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM Users WHERE UserId='".$uid."'";
    //打开记录集
    $results = $this->conn->query($sql);
    if($row = $results->fetch_row()) 
      $exist=true;
    else
      $exist=false;
    return $exist;
  } 

  // 判断指定用户名和密码是否存在
  function CheckUser()
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM Users WHERE UserId='".$this->UserId."' AND UserPwd='".$this->UserPwd."'";
    //打开记录集
    $results = $this->conn->query($sql);
    if($row = $results->fetch_row()) 
      $exist=true;
    else
      $exist=false;
    return $exist;
  } 

  //添加个人信息
  function insert()
  {
    $sql="INSERT INTO Users VALUES ('" . $this->UserId . "','" . $this->UserPwd
     . "'," . $this->Sex . ",'" . $this->Mobile . "'," . $this->UserType . ",'" . $this->Email . "','" . $this->getpasstime . "')";
    //执行SQL语句
    $this->conn->query($sql);
  } 

  //修改个人信息
  function update($uid)
  {
    $sql="UPDATE Users SET Sex=" . $this->Sex . ", Mobile='" . $this->Mobile . "' WHERE UserId='" . $uid . "'";
    //执行SQL语句
    $this->conn->query($sql);
  } 

  function setpwd($uid)
  {
    $sql="UPDATE Users SET UserPwd='" . $this->UserPwd . "' WHERE UserId='" . $uid . "'";
    $this->conn->query($sql);
  } 

  //删除个人信息
  function delete($uid)
  {
    $sql="DELETE FROM Users WHERE UserId='".$uid."'";
    $this->conn->query($sql);
  } 
}
?>