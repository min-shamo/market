<?PHP
//本类用于保存对表Goods的数据库访问操作
//表的每个字段对应类的一个成员变量
class Goods  {
  public $GoodsId;                // 记录编号
  public $GoodsName;            // 商品名称
  public $TypeId;                // 类型编号
  public $SaleOrBuy;            // 交易类型，1表示转让，2表示求购
  public $GoodsDetail;            // 商品说明
  public $ImageURL;                //  图片链接地址
  public $Price;                //  转让价格
  public $StartTime;            // 开始时间
  public $OldNew;                // 新旧程度
  public $Invoice;                // 是否有发票
  public $Repaired;                // 是否保修
  public $Carriage;                // 运费
  public $PayMode;                // 支付方式
  public $DeliverMode;            // 送货方式
  public $IsOver;                // 是否结束
  public $OwnerId;                // 卖家用户名
  public $ClickTimes;            // 点击次数
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

  // 获取商品信息
  function GetGoodsInfo($id)  {
    // 设置查询的SELECT语句
     $sql = "SELECT * FROM Goods WHERE GoodsId=" . $id;
    //打开记录集
    $results = $this->conn->query($sql);
    // 读取个人数据
    if($row = $results->fetch_row()) {
      $this->GoodsId = $id;
      $this->TypeId = $row[1];
      $this->SaleOrBuy = $row[2];
      $this->GoodsName = $row[3];
      $this->GoodsDetail = $row[4];
      $this->ImageURL = $row[5];
      $this->Price = $row[6];
      $this->StartTime = $row[7];
      $this->OldNew = $row[8];
      $this->Invoice = $row[9];
      $this->Repaired = $row[10];
      $this->Carriage = $row[11];
      $this->PayMode = $row[12];
      $this->DeliverMode = $row[13];
      $this->IsOver = $row[14];
      $this->OwnerId = $row[15];
      $this->ClickTimes = $row[16];
    }
    else  {
      $GoodsId=0;
    }
  }

  // 根据查询条件获取所有商品信息，返回结果集
  function GetGoodslist($cond)  {
    // 设置查询的SELECT语句
    $sql = "SELECT * FROM Goods" . $cond . " ORDER BY StartTime DESC";
    //打开记录集
    $results = $this->conn->query($sql);
    return $results;
  }

  // 获取前n名最新添加的商品
  function GetTopnNewGoods($n)  {
    // 设置查询的SELECT语句
    $sql = "SELECT * FROM Goods WHERE IsOver=0 AND SaleOrBuy=1 ORDER BY StartTime DESC LIMIT 0," . $n;
    //打开记录集
    $results = $this->conn->query($sql);
    return $results;
  }

  // 获取前n名最受关注的商品
  function GetTopnMaxClick($n)  {
    // 设置查询的SELECT语句
    $sql = "SELECT * FROM Goods WHERE IsOver=0 ORDER BY ClickTimes DESC, StartTime DESC LIMIT 0," . $n;
    //打开记录集
    $results = $this->conn->query($sql);
    return $results;
  }

  // 判断指定商品分类是否存在
  function HaveGoodsType($tid)  {
    //设置查询的SELECT语句
    $sql = "SELECT * FROM Goods WHERE TypeId=" . $tid;
    //打开记录集
    $results = $this->conn->query($sql);
    if($row = $results->fetch_row()) 
        $exist = true;
    else
      $exist = false;
    return $exist;
  }

  // 添加信息
  function insert()  {
    $sql = "INSERT INTO Goods (TypeId, SaleOrBuy, GoodsName, GoodsDetail, ImageUrl, Price, StartTime, OldNew, IsOver, OwnerId, ClickTimes) VALUES (" . $this->TypeId. "," . $this->SaleOrBuy . ",'" . $this->GoodsName . "','" . $this->GoodsDetail . "','" . $this->ImageUrl . "','" . $this->Price . "','" . $this->StartTime . "','" . $this->OldNew . "',0,'" . $this->OwnerId . "',0)";
    //执行SQL语句
    $this->conn->query($sql);
  }

  function update($id)  {
    $sql = "UPDATE Goods SET GoodsName='" . $this->GoodsName . "', TypeId=" . $this->TypeId . ", GoodsDetail='" . $this->GoodsDetail . "', Price='" . $this->Price . "', OldNew='" . $this->OldNew . "' WHERE GoodsId=" . $id;
    //执行SQL语句
    $this->conn->query($sql);
  }

  function Add_ClickTimes($id)  {
    $sql = "UPDATE Goods SET ClickTimes=ClickTimes+1 WHERE GoodsId=" . $id;
    $this->conn->query($sql);
  }
  
  function SetOver($id)  {
    $sql = "UPDATE Goods SET IsOver=1 WHERE GoodsId=" . $id;
    $this->conn->query($sql);
  }

  // 批量删除信息
  function delete($id) {
    $sql = "DELETE FROM Goods WHERE GoodsId IN (" . $id . ")";
    $this->conn->query($sql);
  }
}
?>