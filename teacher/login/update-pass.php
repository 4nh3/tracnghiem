<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $currentPassword = $_POST["current_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];
    $currentPassword = strip_tags($currentPassword);
    $currentPassword = addslashes($currentPassword);
    $newPassword = strip_tags($newPassword);
    $newPassword = addslashes($newPassword);
    $confirmPassword = strip_tags($confirmPassword);
    $confirmPassword = addslashes($confirmPassword);

    if (!checkCurrentPassword($user, $currentPassword)) {
        include 'connect.php';
        $currentPassword = addslashes($currentPassword);
        $sql = "select * from student where username = '$user' and password = '$currentPassword' ";
        $query = mysqli_query($connect, $sql);
        $num_rows = mysqli_num_rows($query);
        echo "<script>alert('Username hoặc Mật khẩu hiện tại không đúng. Vui lòng kiểm tra lại.');</script>";
    } else {
        if ($newPassword != $confirmPassword) {
            echo "<script>";
            echo "alert(\"Mật khẩu mới và xác nhận mật khẩu không khớp. Vui lòng kiểm tra lại.\");";
            echo "window.location.href = 'update-form.php';";
            echo "</script>";
        } else {
            updatePassword($user, $newPassword);
            echo "<script>";
            echo "alert(\"Đổi mật khẩu thành công.\");";
            echo "window.location.href = 'index.php';";
            echo "</script>";
        }
    }
}

function checkCurrentPassword($user, $currentPassword)
{
    include 'connect.php';
    $sql = "SELECT * FROM teacher WHERE username = '$user' AND password = '$currentPassword'";
    $query = mysqli_query($connect, $sql);
    $numRows = mysqli_num_rows($query);
    mysqli_close($connect);
    return $numRows == 1;
}

function updatePassword($user, $newPassword)
{
    include 'connect.php';
    $sql = "UPDATE teacher SET password = '$newPassword' WHERE username = '$user'";
    $query = mysqli_query($connect, $sql);
    mysqli_close($connect);
}
?>

