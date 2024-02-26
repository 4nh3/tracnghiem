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

    if (isset($_POST['btnSubmit'])) {
        $mmon = $_POST['mmon'];
        $ques = $_POST['ques'];
        $OpA = $_POST['OptionA'];
        $OpB = $_POST['OptionB'];
        $OpC = $_POST['OptionC'];
        $OpD = $_POST['OptionD'];
        $ans = $_POST['answer'];

        // Kiểm tra và xử lý dữ liệu đầu vào để tránh SQL injection
        $mmon = mysqli_real_escape_string($connect, $mmon);
        $ques = mysqli_real_escape_string($connect, $ques);
        $OpA = mysqli_real_escape_string($connect, $OpA);
        $OpB = mysqli_real_escape_string($connect, $OpB);
        $OpC = mysqli_real_escape_string($connect, $OpC);
        $OpD = mysqli_real_escape_string($connect, $OpD);
        $ans = mysqli_real_escape_string($connect, $ans);

        // Lưu nội dung của đáp án đúng
        $correctAnswer = "";
        if ($ans === 'A') {
            $correctAnswer = $OpA;
        } elseif ($ans === 'B') {
            $correctAnswer = $OpB;
        } elseif ($ans === 'C') {
            $correctAnswer = $OpC;
        } elseif ($ans === 'D') {
            $correctAnswer = $OpD;
        }

        $sql = "INSERT INTO `ques_khcb`(`cauhoi`, `A`, `B`, `C`, `D`, `dapan`, `mamon`) VALUES ('$ques','$OpA','$OpB','$OpC','$OpD','$correctAnswer','$mmon')";
        $result = mysqli_query($connect, $sql);

        echo "<script>";
        if ($result) {
            echo "alert(\"Thêm thành công\");";
            echo "window.location.href = 'home.php';";
        } else {
            echo "alert(\"Thêm không thành công\");";
            echo "window.location.href = 'home.php';";
        }
        echo "</script>";
    }
?>
