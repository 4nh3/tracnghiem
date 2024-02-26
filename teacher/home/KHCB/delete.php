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

    $eid = $_GET['deleteid'];

    if (isset($_GET['confirm'])) {
        // Xóa câu hỏi khi đã xác nhận
        $sql = "DELETE FROM `ques_khcb` WHERE stt = '$eid'";
        $result = mysqli_query($connect, $sql);
        
        if ($result) {
            echo "<script>";
            echo "alert(\"Xóa thành công\");";
            echo "window.location.href = 'home.php';";
            echo "</script>";
        } else {
            echo "<script>";
            echo "alert(\"Xóa không thành công\");";
            echo "window.location.href = 'home.php';";
            echo "</script>";
        }
    } else {
        // Hiển thị thông báo xác nhận xóa
        echo "<script>";
        echo "if (confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')) {";
        echo "  window.location.href = 'delete.php?deleteid=$eid&confirm=true';";
        echo "} else {";
        echo "  window.location.href = 'home.php';";
        echo "}";
        echo "</script>";
    }

?>