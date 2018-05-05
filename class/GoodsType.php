<?PHP
//本类用于保存对表GoodsType的数据库访问操作
//表的每个字段对应类的一个成员变量
class GoodsType
{
  public $TypeId; // 照片类型编号
  public $TypeName; // 照片类型名称
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

  //获取分类信息
  function GetGoodsTypeInfo($id)
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM GoodsType WHERE TypeId=".$id;
    //打开记录集
    $results = $this->conn->query($sql);
    //读取分类数据
    if($row = $results->fetch_row())
    {
      $this->TypeId=$id;
      $this->TypeName=$row[1];
    } 
    else
    {
      $TypeId="";
    }
  }

  //获取所有分类信息，返回结果集
  function GetGoodsTypelist()
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM GoodsType";
    //打开记录集
    $results = $this->conn->query($sql);
    return $results;
  } 

  // 判断指定商品分类是否存在
  function HaveGoodsType($name)
  {
    //设置查询的SELECT语句
    $sql="SELECT * FROM GoodsType WHERE TypeName='" . $name . "'";
    //打开记录集
    $results = $this->conn->query($sql);
    if($row = $results->fetch_row()) 
        $exist = true;
    else
      $exist = false;
    return $exist;
  } 

  //添加分类信息
  function insert()
  {
    $sql="INSERT INTO GoodsType (TypeName) VALUES ('".$this->TypeName."')"; 
    //执行SQL语句
    $results = $this->conn->query($sql);
  } 

  //修改分类信息
  function update($id)
  {
    $sql="UPDATE GoodsType SET TypeName='".$this->TypeName."' WHERE TypeId="
    .$id;
    //执行SQL语句
    $results = $this->conn->query($sql);
  } 

  //删除分类信息
  function delete($id)
  {
    $sql="DELETE FROM GoodsType WHERE TypeId IN (".$id.")";
    //执行SQL语句
    $results = $this->conn->query($sql);
  } 
}
?>