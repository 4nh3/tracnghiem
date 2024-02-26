<?php
session_start();
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $testId = $_GET['id'];
    $dbhost = "localhost";
    $username = "root";
    $password = "";
    $dbname = "project";
    $connect = mysqli_connect($dbhost, $username, $password);
    mysqli_query($connect, "SET NAMES 'utf8'");
    mysqli_select_db($connect, $dbname);

    if (!$connect) {
        die("Kết nối không thành công: " . mysqli_connect_error());
    }
    $sql = "DELETE FROM bai_thi WHERE id = '$testId'";
    mysqli_query($connect, $sql);
    mysqli_close($connect);
    header("Location: index.php");
    exit();
} else {
    header("Location: exam_list.php");
    exit();
}
