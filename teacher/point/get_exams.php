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

$sql = "SELECT * FROM ket_qua
        INNER JOIN bai_thi ON `ket_qua`.`bai_thi_id` = `bai_thi`.`id`
        INNER JOIN student ON `ket_qua`.`user_id` = `student`.`username`
        WHERE `bai_thi`.`mamon` = '$mamon' AND `student`.`malop` = '$malop'
        GROUP BY bai_thi_id";

$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<table class="table" id="questionTable">';
    echo '<tr>';
        echo '<th scope="col">Bài thi</th>';
        echo '<th scope="col">Thời gian làm bài</th>';
        echo '<th scope="col">Ngày thi</th>';
    echo '</tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
            echo '<td class="examItem" data-baithiid="' . $row['bai_thi_id'] . '">' . $row['ten_bai_thi'] . '</td>';
            echo '<td class="examItem" data-baithiid="' . $row['bai_thi_id'] . '">' . $row['thoi_gian'] . " phút".'</td>';
            echo '<td class="examItem" data-baithiid="' . $row['bai_thi_id'] . '">' . $row['ngay_thi'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'Không có bài thi nào.';
}
?>


   