<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xem Trước Bài Thi</title>
    <link rel="stylesheet" href="success_test.css">
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

    $makhoa_gv = $_SESSION['makhoa'];
    $testId = $_SESSION['testId'];

    if (isset($_POST['testId'])) {
        $testId = $_POST['testId'];
    }

    $sql = "SELECT * FROM bai_thi WHERE id = '$testId'";
    $result = mysqli_query($connect, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $testName = $row['ten_bai_thi'];
        $testDuration = $row['thoi_gian'];
        $testPassword = $row['mat_khau'];
        $testAttempts = $row['so_lan_lam_bai'];

        echo "<div class='test-info'>";
        echo "<br>";
        echo "<div class='cre'>Tạo bài thi thành công</div>";
        echo "<div class='content1'>" . $testName . "</div>";
        echo "<div class='content2'>" . "Thời gian làm bài: " . $testDuration . " phút " . "</div>";
        echo "<div class='content3'>" . "Mật khẩu bài thi: " . $testPassword . "</div>";
        echo "<div class='content4'>" . "Số lần làm bài: " . $testAttempts . "</div>";
        echo "</div>";

        $sql_cauhoi = "SELECT ctbt.stt, q.cauhoi, q.A, q.B, q.C, q.D, q.dapan FROM bai_thi_chi_tiet ctbt
                            INNER JOIN ques_$makhoa_gv q ON ctbt.stt = q.stt
                            INNER JOIN bai_thi bt ON ctbt.bai_thi_id = bt.id
                            WHERE bt.id = '$testId'
                            ORDER BY ctbt.stt ASC";
        $query_cauhoi = mysqli_query($connect, $sql_cauhoi);

        if (mysqli_num_rows($query_cauhoi) > 0) {
            echo "<div class='container'>";
            echo "<ol class='question-list'>";
            while ($row_cauhoi = mysqli_fetch_assoc($query_cauhoi)) {
                $stt = $row_cauhoi['stt'];
                $cau_hoi = $row_cauhoi['cauhoi'];
                $dap_an_a = $row_cauhoi['A'];
                $dap_an_b = $row_cauhoi['B'];
                $dap_an_c = $row_cauhoi['C'];
                $dap_an_d = $row_cauhoi['D'];
                $dap_an = $row_cauhoi['dapan'];

                echo "<li class='question' id='question'>";
                echo "<p class='question-show'>$cau_hoi</p>";
                echo "<ul class='answer-list'>";
                echo "<li><label class='answer-option'>A. $dap_an_a</label></li>";
                echo "<li><label class='answer-option'>B. $dap_an_b</label></li>";
                echo "<li><label class='answer-option'>C. $dap_an_c</label></li>";
                echo "<li><label class='answer-option'>D. $dap_an_d</label></li>";
                echo "<li><label class='question-show'>Đáp án đúng: $dap_an</label></li>";
                echo "</ul>";
                echo "</li>";
            }

            echo "</ol>";
            echo "</div>";

            echo "<div class='button-container'>";
            echo "<form method='post'>";
            echo "<input type='submit' name='exit' value='Thoát' class='button'>";
            echo "</form>";
            echo "</div>";

            if (isset($_POST['exit'])) {
                header("Location: create_test.php");
                exit();
            }
        } else {
            echo "<div class='error-message'>Không tìm thấy thông tin câu hỏi.</div>";
        }
    } else {
        echo "<div class='error-message'>Không tìm thấy thông tin bài thi.</div>";
    }
    ?>

</body>

</html>
