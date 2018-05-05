<?PHP
    session_start();
    unset($_SESSION['user_id']);
    unset($_SESSION['user_pwd']);
    unset($_SESSION['user_type']);

    header("Location: ../index.php");
?>