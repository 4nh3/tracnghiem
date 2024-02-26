<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem bài thi</title>
    <link rel="stylesheet" href="xem.css">
</head>
<body>
    <div class="wave-container">
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
<?php
session_start();

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

$baiThiID = $_GET['baiThiID'];
$username = $_GET['username'];
$makhoa_gv = $_SESSION['makhoa'];
$sql_bai_thi = "SELECT * FROM bai_thi WHERE ten_bai_thi = '$baiThiID'";
$result_bai_thi = mysqli_query($connect, $sql_bai_thi);
$row_bai_thi = mysqli_fetch_assoc($result_bai_thi);

$sql_cau_hoi = "SELECT *
                FROM ket_qua_chi_tiet kqct
                INNER JOIN ques_$makhoa_gv q ON q.stt = kqct.cau_hoi_id
                INNER JOIN ket_qua kq ON kqct.ket_qua_id = kq.id
                WHERE kqct.bai_thi_id = '$baiThiID' AND kqct.sinh_vien_id = '$username' ";

$result_cau_hoi = mysqli_query($connect, $sql_cau_hoi);
echo "<div class='header'>";
echo "<h3>Bài thi: $baiThiID</h3>";
echo "<h3>Sinh viên: $username</h3>";
echo "</div>";

$stt = 1;
echo '<div class="container">';
while ($row_cau_hoi = mysqli_fetch_assoc($result_cau_hoi)) {
    $cauhoi = $row_cau_hoi['cauhoi'];
    $A = $row_cau_hoi['A'];
    $B = $row_cau_hoi['B'];
    $C = $row_cau_hoi['C'];
    $D = $row_cau_hoi['D'];
    $dapandung = $row_cau_hoi['dapan'];
    $dapansv = $row_cau_hoi['lua_chon'];
    $socaudung = $row_cau_hoi['so_cau_dung'];
    $diem = $row_cau_hoi['diem'];

    $class = '';
    if ($dapansv != '') {
        if ($dapansv != $dapandung) {
            $class = 'wrong';
        }
    }
    echo '<div class="question">';
    echo "<p class='questions $class'>Câu hỏi: $stt. $cauhoi</p>";
        if ($dapansv == $A) {
            echo "<p class='question-show correct'>A. $A</p>";
            echo "<p class='question-show'>B. $B</p>";
            echo "<p class='question-show'>C. $C</p>";
            echo "<p class='question-show'>D. $D</p>";
        } 
        if ($dapansv == $B) {
            echo "<p class='question-show'>A. $A</p>";
            echo "<p class='question-show correct'>B. $B</p>";
            echo "<p class='question-show'>C. $C</p>";
            echo "<p class='question-show'>D. $D</p>";
        } 
        if ($dapansv == $C) {
            echo "<p class='question-show'>A. $A</p>";
            echo "<p class='question-show'>B. $B</p>";
            echo "<p class='question-show correct'>C. $C</p>";
            echo "<p class='question-show'>D. $D</p>";  
        } if ($dapansv == $D) {
            echo "<p class='question-show'>A. $A</p>";
            echo "<p class='question-show'>B. $B</p>";
            echo "<p class='question-show'>C. $C</p>";
            echo "<p class='question-show correct'>D. $D</p>";
        }  
         if ($dapansv == 'không có') {
            echo "<p class='question-show'>A. $A</p>";
            echo "<p class='question-show'>B. $B</p>";
            echo "<p class='question-show'>C. $C</p>";
            echo "<p class='question-show'>D. $D</p>";
        } 
         
    echo '</div>';

    $stt++;
}


echo '</div>';
echo '<div class="infor">';
echo "<p>Số câu đúng: $socaudung</p>";
echo "<p>Điểm: $diem</p>";
echo '</div>';
mysqli_close($connect);
?>


</body>
</html>
