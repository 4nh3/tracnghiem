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

$sql = "SELECT GROUP_CONCAT(DISTINCT `lop`.`tenlop` SEPARATOR ', ') AS tenlop, `lop`.`malop`, COUNT(DISTINCT `ket_qua`.`user_id`) AS total_students
        FROM ket_qua
        INNER JOIN bai_thi ON `ket_qua`.`bai_thi_id` = `bai_thi`.`id`
        INNER JOIN student ON `ket_qua`.`user_id` = `student`.`username`
        INNER JOIN lop ON `student`.`malop` = `lop`.`malop`
        WHERE `bai_thi`.`mamon` = '$mamon'
        GROUP BY `lop`.`malop`";

$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) > 0) {
    echo '<table class="table" id="questionTable">';
    echo '<tr>';
        echo '<th scope="col">Mã lớp</th>';
        echo '<th scope="col">Tên lớp</th>';
        echo '<th scope="col">Số học sinh vào thi</th>';
    echo '</tr>';
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td class="classItem" data-malop="' . $row['malop'] . '">' . $row['malop'] .'</td>';
        echo '<td class="classItem" data-malop="' . $row['malop'] . '">' . $row['tenlop'] . '</td>';
        echo '<td class="classItem" data-malop="' . $row['malop'] . '">' . $row['total_students'] . '</td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'Không có lớp nào.';
}
?>
