<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="question.css">
</head>
<body>
<div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
<?php
session_start();

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

if (isset($_GET['mamon'])) {
    $mamon = $_GET['mamon'];

    // Truy vấn danh sách bài thi thuộc môn học
    $sql_baithi = "SELECT ten_bai_thi FROM bai_thi WHERE mamon = '$mamon' ORDER BY id DESC";
    $query_baithi = mysqli_query($connect, $sql_baithi);
    $num_rows_baithi = mysqli_num_rows($query_baithi);

    if ($num_rows_baithi > 0) {
        // Hiển thị danh sách bài thi
        echo "<div class=\"container\">";
        echo "<h1 class=\"heading\">Danh sách bài thi</h1>";
        echo "<ul class=\"exam-list\">";
       

        while ($row_baithi = mysqli_fetch_assoc($query_baithi)) {
            $ten_bai_thi = $row_baithi['ten_bai_thi'];
    
            // Lấy thông tin thời gian và số lần làm từ cơ sở dữ liệu
            $sql_thongtin = "SELECT * FROM bai_thi WHERE ten_bai_thi = '$ten_bai_thi'";
            $query_thongtin = mysqli_query($connect, $sql_thongtin);
            $row_thongtin = mysqli_fetch_assoc($query_thongtin);
            $thoi_gian = $row_thongtin['thoi_gian'];
            $so_lan_lam = $row_thongtin['so_lan_lam_bai'];
            $ngay = $row_thongtin['ngay'];
                
            echo "<li class=\"exam-item\">";
                echo "<a class=\"exam-link\" href=\"exam.php?ten_bai_thi=$ten_bai_thi\">";
                echo "<div class=\"exam-info\">";
                    echo "<h3 class=\"exam-name\">$ten_bai_thi</h3>";
                    echo "<p class=\"exam-time\">Thời gian: $thoi_gian phút</p>";
                    echo "<p class=\"exam-attempts\">Số lần làm: $so_lan_lam</p>";
                echo "</div>";
                echo "</a>";
            echo "<p class=\"exam-sub\">$ngay</p>";
            echo "</li>";
            $_SESSION['ten_bai_thi'] = $ten_bai_thi;
        }
        

        echo "</ul>";
        echo "</div>";
    } else {
        echo "<div class=\"container\">";
        echo "<p class=\"no-exams\">Không có bài thi nào thuộc môn học này.</p>";
        echo "</div>";
    }
    
}

mysqli_close($connect);
?>

</body>
</html>

