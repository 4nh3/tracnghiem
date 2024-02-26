<?php
$dbhost = "localhost";
$username = "root";
$password = "";
$dbname = "project";
$connect = mysqli_connect($dbhost, $username, $password, $dbname);
mysqli_query($connect, "SET NAMES 'utf8'");

if (!$connect) {
    die("Kết nối không thành công: " . mysqli_connect_error());
}

$monhoc = array();
$sql = "SELECT mamon, tenmon FROM qtkd";
$result = mysqli_query($connect, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $monhoc[] = $row;
}

$eid = $_GET['editid'];

if (isset($_POST['btnSubmit'])) {
    $mmon = $_POST['mmon'];
    $ques = $_POST['ques'];
    $OpA = $_POST['OptionA'];
    $OpB = $_POST['OptionB'];
    $OpC = $_POST['OptionC'];
    $OpD = $_POST['OptionD'];
    $ans = $_POST['answer'];
    $sql = "UPDATE `ques_qtkd` SET `cauhoi`='$ques', `A`='$OpA', `B`='$OpB', `C`='$OpC', `D`='$OpD', `dapan`='$ans', `mamon`='$mmon' WHERE stt = '$eid'";
    $result = mysqli_query($connect, $sql);
    if ($result) {
        echo "<script>";
        echo "alert(\"Cập nhật thành công\");";
        echo "window.location.href = 'home.php';";
        echo "</script>";
        exit();
    } else {
        echo "<script>alert(\"Cập nhật không thành công\");</script>";
    }
}
$sql = "SELECT * FROM `ques_qtkd` WHERE stt = '$eid'";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa câu hỏi</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <form class="div_form" action="" method="post">
        <div class="modal-body">
            <div class="form-group">
                <p>Mã môn học</p>
                <select name="mmon" id="mmon">
                    <?php foreach ($monhoc as $mon) { ?>
                        <option value="<?php echo $mon['mamon']; ?>" <?php if ($mon['mamon'] == $row['mamon']) echo 'selected'; ?>><?php echo $mon['mamon']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group">
                <p>Nhập câu hỏi</p>
                <textarea type="text" class="form-control" name="ques" id="ques" required><?php echo $row['cauhoi']; ?></textarea>
            </div>

            <div class="form-group">
                <p>Đáp án A</p>
                <input type="text" class="form-control" name="OptionA" id="OptionA" value="<?php echo $row['A']; ?>" required>
            </div>

            <div class="form-group">
                <p>Đáp án B</p>
                <input type="text" class="form-control" name="OptionB" id="OptionB" value="<?php echo $row['B']; ?>" required>
            </div>

            <div class="form-group">
                <p>Đáp án C</p>
                <input type="text" class="form-control" name="OptionC" id="OptionC" value="<?php echo $row['C']; ?>" required>
            </div>

            <div class="form-group">
                <p>Đáp án D</p>
                <input type="text" class="form-control" name="OptionD" id="OptionD" value="<?php echo $row['D']; ?>" required>
            </div>

            <div class="form-group">
                <p>Đáp án đúng</p>
                <input type="text" class="form-control" name="answer" id="answer" value="<?php echo $row['dapan']; ?>" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="btnSubmit">Lưu</button>
            <a href="home.php" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</body>
</html>
