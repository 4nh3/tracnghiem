<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
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

if (isset($_POST['search'])) {
    $mamon = $_POST['mamon'];
    $makhoa = $_SESSION['makhoa'];
    $sql = "SELECT * FROM bai_thi WHERE mamon = '$mamon' AND mamon IN (SELECT mamon FROM khoa WHERE makhoa = '$makhoa') ORDER BY id DESC";
} else {
    $makhoa = $_SESSION['makhoa'];
    $sql = "SELECT * FROM bai_thi WHERE mamon IN (SELECT mamon FROM $makhoa) ORDER BY id DESC";
}
$result = mysqli_query($connect, $sql);
$tests = mysqli_fetch_all($result, MYSQLI_ASSOC);
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bài thi</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="wave-container">
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <form method="POST" class="search-form">
        <input type="text" name="mamon" placeholder="Nhập mã môn cần tìm">
        <button type="submit" name="search">Tìm kiếm</button>
    </form>

    <div class="exam-list">
        <?php foreach ($tests as $test) { ?>
            <div class="exam-item">
                <a href="question_detail.php?id=<?php echo $test['id']; ?>" class="exam-link">
                    <div class="exam-info">
                        <h3 class="exam-name"><?php echo $test['ten_bai_thi']; ?></h3>
                    </div>
                    <div class="exam-details">
                        <div class="">
                            <p class="exam-time">Thời gian: <?php echo $test['thoi_gian']; ?> phút</p>
                            <p class="exam-attempts">Số lần làm: <?php echo $test['so_lan_lam_bai']; ?></p>
                        </div>  
                        <div class="exam-sub">
                            <?php echo $test['mamon']; ?>
                        </div>
                    </div>
                </a>
                <button class="delete" onclick="confirmDelete(<?php echo $test['id']; ?>)">XÓA BÀI THI</button>
            </div>
        <?php } ?>
        </div>
<script>
    function confirmDelete(testId) {
        if (confirm('Bạn có muốn xóa bài thi này?')) {
            // Nếu người dùng nhấn OK, chuyển hướng đến trang xóa bài thi với id tương ứng
            window.location.href = 'delete_test.php?id=' + testId;
        }
    }
</script>
</body>
</html>
