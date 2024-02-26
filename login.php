<?php
    session_unset();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập hệ thống</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
    session_start();
    
        require_once("form.php");
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user = $_POST["username"];
            $pass = $_POST["password"];
            //làm sạch thông tin
            $user = strip_tags($user);
            $user = addslashes($user);
            $pass = strip_tags($pass);
            $pass = addslashes($pass);

                include 'connect.php';
                $sql = "select * from student where username = '$user' and password = '$pass' ";
                $query = mysqli_query($connect, $sql);
                $num_rows = mysqli_num_rows($query);
                if ($num_rows == 1) {
                    $row = mysqli_fetch_assoc($query);
                    $_SESSION['username'] = $row['username'];
                }
                echo "<script>";
                    if($num_rows==1){
                        echo "alert(\"\");";
                    header('location: student/home.php');
                    }else{
                        echo "alert(\"Đăng nhập không thành công. Vui lòng kiểm tra lại tên đăng nhập và mật khẩu.\");";
                    }
                    }
                echo "</script>";
?>
</body>
</html>