<?php
session_unset();

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

$mamon = $_POST['mamon'];
$malop = $_POST['malop'];
$baiThiID = $_POST['baiThiID'];

$sqlCount = "SELECT COUNT(*) AS total_question FROM bai_thi_chi_tiet WHERE bai_thi_id = '$baiThiID'";
$resultCount = mysqli_query($connect, $sqlCount);
$rowCount = mysqli_fetch_assoc($resultCount);
$totalQuestion = $rowCount['total_question'];

     

$sql = "SELECT student.*, `ket_qua`.`diem`, `ket_qua`.`bai_thi_id`, `ket_qua`.`so_cau_dung`
        FROM student
        INNER JOIN ket_qua ON `student`.`username` = `ket_qua`.`user_id`
        INNER JOIN bai_thi ON `ket_qua`.`bai_thi_id` = `bai_thi`.`id`
        WHERE `student`.`malop` = '$malop' AND `bai_thi`.`mamon` = '$mamon' AND `ket_qua`.`bai_thi_id` = '$baiThiID'";

$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<table class="table" id="questionTable">';
    echo '<tr>';
        echo '<th scope="col">Mã sinh viên</th>';
        echo '<th scope="col">Tên sinh viên</th>';
        echo '<th scope="col">Tổng câu hỏi</th>';
        echo '<th scope="col">Số câu đúng</th>';
        echo '<th scope="col">Điểm</th>';
    echo '</tr>';
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td class="examItem">' . $row['username'] .'</td>';
        echo '<td class="examItem">' . $row['tensv'] . '</td>';
        echo '<td class="examItem">' . $totalQuestion . '</td>';
        echo '<td class="examItem">' . $row['so_cau_dung'] . '</td>';
        echo '<td class="examItem">' . $row['diem'] . '</td>';
        echo '<td class="examItem"><a href="xem_bai_thi.php?baiThiID=' . $baiThiID . '&username=' . $row['username'] . '">Xem</a></td>'; // Thêm nút "Xem bài thi"
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'Không có học sinh nào.';
}
?>
