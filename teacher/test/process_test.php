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
    $tenbai = $_POST['testName'];
    $thoigian = $_POST['testDuration'];
    $matkhau = $_POST['testPassword'];
    $solanlam = $_POST['testAttempts'];
    $ngay = date("Y-m-d H:i:s");
    $query = "INSERT INTO bai_thi (mamon, ten_bai_thi, thoi_gian, mat_khau, so_lan_lam_bai, ngay) 
              VALUES ('$mamon', '$tenbai', '$thoigian', '$matkhau', '$solanlam', '$ngay')";
    $result = mysqli_query($connect, $query);
   
    if (!$result) {
        die("Lỗi: " . mysqli_error($connect));
    }
    $bai_thi_id = mysqli_insert_id($connect);
    $_SESSION['testId'] = $bai_thi_id; 
    if (isset($_POST['questions'])) {
        $selectedQuestions = $_POST['questions'];
        echo $selectedQuestions;    
        $selectedQuestions = json_decode($selectedQuestions, true);
        foreach ($selectedQuestions as $questionId) {
            $sttQuery = "SELECT stt FROM ques_$makhoa_gv WHERE stt = '$questionId'";
            $sttResult = mysqli_query($connect, $sttQuery);
            echo $questionId;
            if (!$sttResult) {
                die("Lỗi: " . mysqli_error($connect));
            }
    
            while ($row = mysqli_fetch_assoc($sttResult)) {
                $stt = $row['stt'];
                echo "STT: " . $stt . "<br>";
            
            $query = "INSERT INTO bai_thi_chi_tiet (bai_thi_id, ten_bai_thi, stt) 
                      VALUES ('$bai_thi_id', '$tenbai', '$stt')";
            
            $result = mysqli_query($connect, $query);
            
            if (!$result) {
                die("Lỗi: " . mysqli_error($connect));
            }
        }
            
        }
    }
    if (isset($_POST['exit'])) {
        header("Location: ../home/home.php");
        exit();
    }
    header("Location: success_test.php");
    exit();
?>
