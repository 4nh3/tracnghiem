<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["username"];
    $currentPassword = $_POST["current_password"];
    $newPassword = $_POST["new_password"];
    $confirmPassword = $_POST["confirm_password"];
    // Làm sạch thông tin, xóa bỏ các tag html và ký tự đặc biệt
    $currentPassword = strip_tags($currentPassword);
    $currentPassword = addslashes($currentPassword);
    $newPassword = strip_tags($newPassword);
    $newPassword = addslashes($newPassword);
    $confirmPassword = strip_tags($confirmPassword);
    $confirmPassword = addslashes($confirmPassword);
    // Kiểm tra mật khẩu hiện tại
    // Nếu mật khẩu hiện tại không khớp, hiển thị thông báo lỗi
    if (!checkCurrentPassword($user, $currentPassword)) {
        include 'connect.php';
        $currentPassword = addslashes($currentPassword);
        $sql = "select * from student where username = '$user' and password = '$currentPassword' ";
            // echo $sql;
        $query = mysqli_query($connect, $sql);
        $num_rows = mysqli_num_rows($query);
        echo "<script>alert('Username hoặc Mật khẩu hiện tại không đúng. Vui lòng kiểm tra lại.');</script>";
    } else {
        // Kiểm tra mật khẩu mới và xác nhận mật khẩu có khớp không
        if ($newPassword != $confirmPassword) {
            echo "<script>";
            echo "alert(\"Mật khẩu mới và xác nhận mật khẩu không khớp. Vui lòng kiểm tra lại.\");";
            echo "window.location.href = 'update-form.php';";
            echo "</script>";
        } else {
            // Cập nhật mật khẩu mới vào cơ sở dữ liệu
            updatePassword($user, $newPassword);
            echo "<script>";
            echo "alert(\"Đổi mật khẩu thành công.\");";
            echo "window.location.href = 'form.php';";
            echo "</script>";
        }
    }
}

function checkCurrentPassword($user, $currentPassword)
{
    // Thực hiện kiểm tra mật khẩu hiện tại trong cơ sở dữ liệu
    include 'connect.php';
    $sql = "SELECT * FROM student WHERE username = '$user' AND password = '$currentPassword'";
    $query = mysqli_query($connect, $sql);
    $numRows = mysqli_num_rows($query);
    mysqli_close($connect);
    return $numRows == 1;
}

function updatePassword($user, $newPassword)
{
    // Thực hiện cập nhật mật khẩu mới trong cơ sở dữ liệu
    include 'connect.php';
    $sql = "UPDATE student SET password = '$newPassword' WHERE username = '$user'";
    $query = mysqli_query($connect, $sql);
    mysqli_close($connect);
}
?>

