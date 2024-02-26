<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

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

// Lấy thông tin học sinh từ cơ sở dữ liệu
$user = $_SESSION['username'];
$sql = "SELECT * FROM student WHERE username = '$user'";
$query = mysqli_query($connect, $sql);
$num_rows = mysqli_num_rows($query);

if ($num_rows == 1) {
    $row = mysqli_fetch_assoc($query);
    $malop = $row['malop'];

    // Truy vấn thông tin lớp học
    $sql_lop = "SELECT * FROM lop WHERE malop = '$malop'";
    $query_lop = mysqli_query($connect, $sql_lop);
    $num_rows_lop = mysqli_num_rows($query_lop);

    if ($num_rows_lop == 1) {
        $row_lop = mysqli_fetch_assoc($query_lop);
        $makhoa = $row_lop['makhoa'];

        // Truy vấn thông tin khoa và môn học
        $sql_khoa = "SELECT * FROM khoa WHERE makhoa = '$makhoa'";
        $query_khoa = mysqli_query($connect, $sql_khoa);
        $num_rows_khoa = mysqli_num_rows($query_khoa);

        if ($num_rows_khoa == 1) {
            $row_khoa = mysqli_fetch_assoc($query_khoa);
            $tenkhoa = $row_khoa['tenkhoa'];

            // Truy vấn danh sách môn học của khoa
            $sql_monhoc = "SELECT * FROM $makhoa";
            $query_monhoc = mysqli_query($connect, $sql_monhoc);
            $num_rows_monhoc = mysqli_num_rows($query_monhoc);
            $_SESSION['makhoa'] = $row_khoa['makhoa'];

            if ($num_rows_monhoc > 0) {
                echo "<h1 class=\"khoa-title\">Khoa $tenkhoa</h1>";
                echo "<ul class=\"monhoc-list monhoc-row\">";
                while ($row_monhoc = mysqli_fetch_assoc($query_monhoc)) {
                    $mamon = $row_monhoc['mamon'];
                    $tenmon = $row_monhoc['tenmon'];
                    echo "<li class=\"monhoc-item\">
                              <a href=\"question.php?mamon=$mamon\">
                              <div class=\"monhoc-icon\"></div>
                              $tenmon
                              <div class=\"exam-sub\">$mamon</div>
                              </a>
                          </li>";
                }
                echo "</ul>";
            } else {
                echo "<p class=\"no-result\">Không có môn học nào thuộc khoa $tenkhoa.</p>";
            }
        } else {
            echo "<p class=\"no-result\">Không tìm thấy thông tin khoa.</p>";
        }
    } else {
        echo "<p class=\"no-result\">Không tìm thấy thông tin lớp học.</p>";
    }
} else {
    echo "<p class=\"no-result\">Không tìm thấy thông tin người dùng.</p>";
}

mysqli_close($connect);
?>
</body>
</html>
