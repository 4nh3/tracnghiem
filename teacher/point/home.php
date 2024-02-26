    <?php
    session_unset();
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

    $monhoc = array();
    $makhoa_gv = $_SESSION['makhoa']; // Lấy giá trị của mã khoa từ session
    $sql = "SELECT mamon, tenmon FROM $makhoa_gv"; 
    $result = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $monhoc[] = $row;
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ĐIỂM</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="nav">
        <img src="/img/logo.png" alt="">
        <p>HỆ THỐNG THI TRẮC NGHIỆM <a href="https://www.ctec.edu.vn/ctec/">TRƯỜNG CAO ĐẲNG KINH TẾ - KỸ THUẬT CẦN THƠ</a></p>
    </div>

    <div class="content">
        <div class="slidebar">
            <ul class="menu">
                <?php foreach ($monhoc as $mon) { ?>
                    <li onclick="showClasses('<?php echo $mon['mamon']; ?>')"><?php echo $mon['tenmon'] . '<br>' . '<p class="mamon">' . $mon['mamon'] . '</p>'; ?></li>
                <?php } ?>
                <li><a href="../home/home.php">Thoát</a></li>
            </ul>
        </div>

        <div id="classesContainer"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script>
        function showClasses(mamon) {
            $.ajax({
                type: 'POST',
                url: 'get_classes.php',
                data: {
                    mamon: mamon
                },
                success: function(response) {
                    $('#classesContainer').html(response);
                    $('.classItem').click(function() {
                        var malop = $(this).data('malop');
                        showExams(mamon, malop);
                    });
                }
            });
        }

        function showExams(mamon, malop) {
            $.ajax({
                type: 'POST',
                url: 'get_exams.php',
                data: {
                    mamon: mamon,
                    malop: malop
                },
                success: function(response) {
                    $('#classesContainer').html(response);
                    $('.examItem').click(function() {
                        var baiThiID = $(this).data('baithiid');
                        showStudents(mamon, malop, baiThiID);
                    });
                }
            });
        }

        function showStudents(mamon, malop, baiThiID) {
            $.ajax({
                type: 'POST',
                url: 'get_students.php',
                data: {
                    mamon: mamon,
                    malop: malop,
                    baiThiID: baiThiID
                },
                success: function(response) {
                    $('#classesContainer').html(response);
                }
            });
        }
    </script>
</body>
</html>
