
<?php
    session_unset();
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
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
        require_once("index.php");
            if(isset($_POST['btn_submit'])){
            $user = $_POST["username"];
            $pass = $_POST["password"];
            $user = strip_tags($user);
            $user = addslashes($user);
            $pass = strip_tags($pass);
            $pass = addslashes($pass);
                $sql = "select * from teacher where username = '$user' and password = '$pass' ";
                $query = mysqli_query($connect, $sql);
                $num_rows = mysqli_num_rows($query);

                echo "<script>";
                    if($num_rows==1){
                        $row = mysqli_fetch_assoc($query);
                        $_SESSION['username'] = $row['username'];
                        $_SESSION['password'] = $row['password'];
                        $_SESSION['makhoa'] = $row['makhoa'];
                        echo "alert(\"\");";
                    header('location: ../home/home.php');
                    }else{
                        echo "alert(\"Đăng nhập không thành công. Vui lòng kiểm tra lại tên đăng nhập và mật khẩu.\");";
                    }
                    }
                echo "</script>";
        ?>
</body>
</html>