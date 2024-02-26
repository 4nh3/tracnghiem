<?php
// session_start();

// $dbhost = "localhost";
// $username = "root";
// $password = "";
// $dbname = "project";
// $connect = mysqli_connect($dbhost, $username, $password);
// mysqli_query($connect, "SET NAMES 'utf8'");
// mysqli_select_db($connect, $dbname);

// if (!$connect) {
//     die("Kết nối không thành công: " . mysqli_connect_error());
// }

// $mamon = $_POST['mmon'];
// $makhoa_gv = $_SESSION['makhoa'];

// $query = "SELECT * FROM ques_$makhoa_gv
//           INNER JOIN $makhoa_gv ON $makhoa_gv.mamon = ques_$makhoa_gv.mamon
//           WHERE $makhoa_gv.mamon = ?";
// $stmt = mysqli_prepare($connect, $query);
// mysqli_stmt_bind_param($stmt, "s", $mamon);
// mysqli_stmt_execute($stmt);
// $result = mysqli_stmt_get_result($stmt);

// $questionList = '';
// while ($row = mysqli_fetch_assoc($result)) {
//     $question = $row['cauhoi'];
//     $questionId = $row['stt'];
//     $questionList .= '<tr><td>' . $question . '</td>';
//     $questionList .= '<td><input type="checkbox" name="questions[]" value="' . $questionId .'" class="question-checkbox"></td></tr>';
// }

// echo $questionList;
?>
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

$mamon = $_POST['mmon'];
$makhoa_gv = $_SESSION['makhoa'];

$query = "SELECT * FROM ques_$makhoa_gv WHERE mamon = ?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "s", $mamon);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$questionList = '';
while ($row = mysqli_fetch_assoc($result)) {
    $question = $row['cauhoi'];
    $questionId = $row['stt'];
    $questionList .= '<tr><td>' . $question . '</td>';
    $questionList .= '<td><input type="checkbox" name="questions[]" value="' . $questionId .'" class="question-checkbox"></td></tr>';
}

echo $questionList;
?>
