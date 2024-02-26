<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết Quả Thi</title>
    <link rel="stylesheet" href="submit.css">
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
    // header('Location: login.php');
    exit;
}

$dbhost = "localhost";
$username = "root";
$password = "";
$dbname = "project";
$connect = mysqli_connect($dbhost, $username, $password, $dbname);
mysqli_query($connect, "SET NAMES 'utf8'");

if (!$connect) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}
$makhoa_gv = $_SESSION['makhoa'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ten_bai_thi = $_POST['ten_bai_thi'];
    // Truy vấn danh sách câu hỏi
    $sql_cauhoi = "SELECT ctbt.stt, q.cauhoi, q.A, q.B, q.C, q.D, q.dapan FROM bai_thi_chi_tiet ctbt
            INNER JOIN ques_$makhoa_gv q ON ctbt.stt = q.stt
            INNER JOIN bai_thi bt ON ctbt.bai_thi_id = bt.id
            WHERE bt.ten_bai_thi = '$ten_bai_thi'
            ORDER BY ctbt.stt ASC";
    $query_cauhoi = mysqli_query($connect, $sql_cauhoi);
    $totalQuestions = mysqli_num_rows($query_cauhoi);
    // Lưu dữ liệu vào bảng ket_qua
    $user_id = mysqli_real_escape_string($connect, $_SESSION['username']);
    $bai_thi_id = mysqli_real_escape_string($connect, $ten_bai_thi);
    $so_cau_dung = 0;
    $diem = 0;
    $ngay_thi = date("Y-m-d H:i:s");

    // $sql_insert_diem = "INSERT INTO ket_qua (user_id, bai_thi_id, so_cau_dung, diem, ngay_thi) 
    //                     VALUES ('$user_id', '$bai_thi_id', '$so_cau_dung', '$diem', '$ngay_thi')";
    $sql_insert_diem = "INSERT INTO ket_qua (user_id, bai_thi_id, so_cau_dung, diem, ngay_thi) 
                        SELECT '$user_id', id, '$so_cau_dung', '$diem', '$ngay_thi' FROM bai_thi WHERE ten_bai_thi = '$ten_bai_thi'";

    $query_insert_diem = mysqli_query($connect, $sql_insert_diem);
    if ($query_insert_diem) {
        $ket_qua_id = mysqli_insert_id($connect); // Lấy giá trị ket_qua_id từ bản ghi vừa chèn vào bảng ket_qua

        // Tạo một mảng để lưu trữ đáp án đúng của từng câu hỏi
        $correctAnswers = array();

        while ($row_cauhoi = mysqli_fetch_assoc($query_cauhoi)) {
            $stt = $row_cauhoi['stt'];
            $dap_an_dung = $row_cauhoi['dapan'];
            $correctAnswers[$stt] = $dap_an_dung;
            $cau_hoi = $row_cauhoi['cauhoi'];

            // Thực hiện xử lý và lưu câu trả lời của sinh viên vào cơ sở dữ liệu
            if (isset($_POST['dap_an_' . $stt])) {
                $temp = $_POST['dap_an_' . $stt];

                // Lưu câu hỏi và câu trả lời của sinh viên vào cơ sở dữ liệu
                $masv = $_SESSION['username'];
                $cauhoi = mysqli_real_escape_string($connect, $row_cauhoi['cauhoi']);
                $dap_an_hs = isset($_POST['dap_an_' . $stt]) ? mysqli_real_escape_string($connect, $_POST['dap_an_' . $stt]) : '';

                $sql_insert_cau_tra_loi = "INSERT INTO ket_qua_chi_tiet (ket_qua_id, sinh_vien_id, bai_thi_id, cau_hoi_id, cauhoi, lua_chon)
                                           SELECT '$ket_qua_id', '$masv', id, '$stt', '$cauhoi', '$temp' FROM bai_thi WHERE ten_bai_thi = '$ten_bai_thi'";
                $query_insert_cau_tra_loi = mysqli_query($connect, $sql_insert_cau_tra_loi);
                if (!$query_insert_cau_tra_loi) {
                    echo "Lưu câu hỏi và câu trả lời thất bại: " . mysqli_error($connect);
                }
                if ($temp === $dap_an_dung) {
                    $so_cau_dung++;
                }
            } else{
                $temp = 'không có';

                // Lưu câu hỏi và câu trả lời của sinh viên vào cơ sở dữ liệu
                $masv = $_SESSION['username'];
                $cauhoi = mysqli_real_escape_string($connect, $row_cauhoi['cauhoi']);
                $dap_an_hs = mysqli_real_escape_string($connect, "không có". $stt);

                $sql_insert_cau_tra_loi = "INSERT INTO ket_qua_chi_tiet (ket_qua_id, sinh_vien_id, bai_thi_id, cau_hoi_id, cauhoi, lua_chon)
                                        VALUES ('$ket_qua_id', '$masv', '$ten_bai_thi', '$stt', '$cauhoi', '$temp')";
                $query_insert_cau_tra_loi = mysqli_query($connect, $sql_insert_cau_tra_loi);
                if (!$query_insert_cau_tra_loi) {
                    echo "Lưu câu hỏi và câu trả lời thất bại: " . mysqli_error($connect);
                }
            }
        }

        $diem = ($so_cau_dung / $totalQuestions) * 10;

        // Cập nhật số câu đúng và điểm vào bảng ket_qua
        $sql_update_diem = "UPDATE ket_qua SET so_cau_dung = '$so_cau_dung', diem = '$diem' WHERE id = '$ket_qua_id'";
        $query_update_diem = mysqli_query($connect, $sql_update_diem);
        if ($query_update_diem) {
            echo '<div class="container">';
            echo '    <div class="title">' . $bai_thi_id . '</div>';
            echo '    <div class="subtitle">Số câu đúng: ' . $so_cau_dung . '/' . $totalQuestions . '</div>';
            echo '    <div class="subtitle">Điểm: ' . $diem .'</div>';
            echo '    <div class="suba"><a href="../form.php">THOÁT</a></div>';
            echo '</div>';
        } else {
            echo 'Lỗi cập nhật kết quả: ' . mysqli_error($connect);
        }
    }
}
    mysqli_close($connect);
    ?>

</body>
</html>
