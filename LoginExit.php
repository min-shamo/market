<?PHP
  session_start();
  $_SESSION["user_id"]="";
  $_SESSION["user_pwd"]="";
  header("Location: "."index.php");
?>