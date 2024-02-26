<?php
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
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>Giảng Viên - CTEC</title>
</head>
<body>

    <div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <div class="nav">
        <?php 
        // Lấy giá trị của $_SESSION['username']
        $username = $_SESSION['username'];

        // Thực hiện truy vấn SQL dựa trên giá trị $username
        $sql = "SELECT * FROM teacher WHERE username = '$username'";
        $query = mysqli_query($connect, $sql);

        // Kiểm tra số hàng dữ liệu trả về
        $num_rows = mysqli_num_rows($query);
        if ($num_rows > 0) {
            $row = mysqli_fetch_assoc($query);
            $makhoa_gv = $row['makhoa'];
        } else {
            echo "Không tìm thấy thông tin người dùng.";
        }
        ?>
    </div>

    <div class="content">
        <a class="element--hover" href="<?php echo getHrefByKhoa($makhoa_gv); ?>">BỘ CÂU HỎI</a>
    </div>
    <div class="content">
        <a class="element--hover" href="../point/home.php">ĐIỂM</a>
    </div>
    <div class="content">
        <a class="element--hover" href="../test/create_test.php" id="btnCreate">TẠO BÀI THI</a>
    </div>
    <div class="content">
        <a class="element--hover" href="../test/index.php" id="btnCreate">DANH SÁCH BÀI THI</a>
    </div>
    <div class="content">
        <a class="element--hover" href="../login/index.php" id="btnCreate">ĐĂNG XUẤT</a>
    </div>
    
    <?php
function getHrefByKhoa($makhoa_gv) {
    $makhoa_gv = $_SESSION['makhoa'];
    
    switch ($makhoa_gv) {
        case 'cntt':
            return 'CNTT/home.php';
        case 'nn':
            return 'NN/home.php';
        case 'tckt':
            return 'TCKT/home.php';
        case 'qtkd':
            return 'QTKD/home.php';
        case 'cnts':
            return 'CNTS/home.php';
        case 'khcb':
            return 'KHCB/home.php';
    }
}
?>

</body>
</html>