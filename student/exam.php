<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm tra</title>
    <link rel="stylesheet" href="exam.css">
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

    if (isset($_GET['ten_bai_thi'])) {
        $ten_bai_thi = $_GET['ten_bai_thi'];

        // Truy vấn thông tin bài thi
        $sql_baithi = "SELECT * FROM bai_thi WHERE ten_bai_thi = '$ten_bai_thi'";
        $query_baithi = mysqli_query($connect, $sql_baithi);
        $num_rows_baithi = mysqli_num_rows($query_baithi);

        if ($num_rows_baithi == 1) {
            $row_baithi = mysqli_fetch_assoc($query_baithi);
            $thoi_gian = $row_baithi['thoi_gian'];
            $so_lan_lam_bai = $row_baithi['so_lan_lam_bai'];
            $mat_khau_baithi = $row_baithi['mat_khau'];
            $mamon = $row_baithi['mamon'];

            // Kiểm tra mật khẩu
            if (isset($_POST['password'])) {
                $entered_password = $_POST['password'];

                if ($entered_password === $mat_khau_baithi) {
                    $user_id = $_SESSION['username'];

                    // Kiểm tra số lần làm bài của tài khoản
                    $sql_lanlam = "SELECT COUNT(*) AS lan_lam_bai FROM ket_qua WHERE user_id = '$user_id' AND bai_thi_id = '$ten_bai_thi'";
                    $query_lanlam = mysqli_query($connect, $sql_lanlam);
                    $row_lanlam = mysqli_fetch_assoc($query_lanlam);
                    $lan_lam_bai = $row_lanlam['lan_lam_bai'];

                    if ($lan_lam_bai < $so_lan_lam_bai) {
                        // Đánh dấu bài thi đã bắt đầu
                        $_SESSION['exam_started'] = true;

                        // Tính toán thời gian kết thúc và lưu vào session
                        $current_time = time();
                        $_SESSION['exam_end_time'] = $current_time + ($thoi_gian * 60);

                        // Chuyển sang trang làm bài
                        header("Location: exam_test.php?ten_bai_thi=$ten_bai_thi");
                        exit;
                    } else {
                        echo "<script>alert('Bài thi đã kết thúc. Vui lòng thử lại');</script>";
                    }
                } else {
                    echo "<script>alert('Mật khẩu không đúng. Vui lòng thử lại');</script>";
                }
            }
            echo "<div class=\"container\">";

            echo "<h1>THÔNG TIN BÀI THI</h1>";
            echo "<p class=\"exam-name\">$ten_bai_thi</p>";
            echo "<p class=\"exam-sub\">Mã môn: $mamon</p>";
            echo "<p class=\"exam-time\">Thời gian: $thoi_gian phút</p>";
            echo "<p class=\"exam-number\">Số lần đã làm bài: $so_lan_lam_bai</p>";

            // Hiển thị form nhập mật khẩu bài thi
            echo "<form method='POST'>";
            echo "<label for='password'>Mật khẩu</label>";
            echo "<input type='password' name='password' id='password' required>";
            echo "<br>";
            echo "<input type='submit' value='Xác nhận'>";
            echo "</form>";
            echo "</div>";
        } else {
            echo "Không tìm thấy thông tin bài thi.";
        }
    } else {
        echo "Tên bài thi không được xác định.";
    }

    mysqli_close($connect);
    ?>

</body>
</html>