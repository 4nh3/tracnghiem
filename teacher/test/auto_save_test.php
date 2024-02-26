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

$makhoa_gv = $_SESSION['makhoa'];
$mamon = $_POST['mmon'];
$numberOfQuestions = $_POST['numberOfQuestions'];

$query = "SELECT * FROM ques_$makhoa_gv WHERE mamon = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "s", $mamon);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$questions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $questions[] = $row;
}

shuffle($questions); // Trộn câu hỏi

$output = '';
for ($i = 0; $i < $numberOfQuestions; $i++) {
    $question = $questions[$i];
    $output .= '<tr>';
    // $output .= '<td>' . $question['stt'] . '</td>';
    $output .= '<td>' . $question['cauhoi'] . '</td>';
    $output .= '<td><input type="checkbox" name="questions[]" value="' . $question['stt'] . '" checked></td>';
    $output .= '</tr>';
}

echo $output;
?>
