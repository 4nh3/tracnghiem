<?php
session_start();
// session_unset();
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
$testId = $_GET['id'];

$sql = "SELECT * FROM bai_thi WHERE id = $testId";
$result = mysqli_query($connect, $sql);
$test = mysqli_fetch_assoc($result);

$sqlQuestions = "SELECT * FROM ques_$makhoa_gv 
                 INNER JOIN bai_thi_chi_tiet ON `ques_$makhoa_gv`.`stt` = `bai_thi_chi_tiet`.`stt`
                 WHERE `bai_thi_chi_tiet`.`bai_thi_id` = $testId";
$resultQuestions = mysqli_query($connect, $sqlQuestions);
$questions = mysqli_fetch_all($resultQuestions, MYSQLI_ASSOC);

mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bài thi</title>
    <link rel="stylesheet" href="question_detail.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
</head>
<body>

    <div class="wave-container">
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <div class='test-info'>
        <h1 class="content1" ><?php echo $test['ten_bai_thi']; ?></h1>
        <div class='content2'>Mã môn học: <?php echo $test['mamon']; ?></div>
        <div class='content3'>Thời gian: <?php echo $test['thoi_gian']; ?> phút</div>
        <div class='content4'>Mật khẩu: <?php echo $test['mat_khau']; ?></div>
        <div class='content5'>Số lần làm bài: <?php echo $test['so_lan_lam_bai']; ?></div>
    </div>

    <div class='container'>
    <ol class='question-list'>
        <?php foreach ($questions as $question) { ?>
            <li class='question' id='question'>
                <p class='question-show'><?php echo $question['cauhoi']; ?></p>
                <p class='answer-option'>A. <?php echo $question['A']; ?></p>
                <p class='answer-option'>B. <?php echo $question['B']; ?></p>
                <p class='answer-option'>C. <?php echo $question['C']; ?></p>
                <p class='answer-option'>D. <?php echo $question['D']; ?></p>
                <p class='answer-option'>Đáp án đúng:  <?php echo $question['dapan']; ?></p>
            </li>
        <?php } ?>
    </ol>
    </div>
</body>
</html>
