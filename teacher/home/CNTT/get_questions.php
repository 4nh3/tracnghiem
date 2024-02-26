<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="../fontawesome-free-6.1.1-web/css/all.min.css">
</head>
<body>
<div class="ques">
            <div class="search">
            <input id="txtSearch" type="text" class="searchTerm" placeholder="Tìm kiếm câu hỏi">
            <button type="button" class="searchButton" onclick="searchQuestions()">
                <i class="fa fa-search"></i>
            </button>
            </div>

            <table class="table" id="questionTable">
                <thead>
                    <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Câu Hỏi</th>
                        <th scope="col">A</th>
                        <th scope="col">B</th>
                        <th scope="col">C</th>
                        <th scope="col">D</th>
                        <th scope="col">Đáp án</th>
                        <th scope="col"><a href="get_questions.php">Trở lại</a></th>
                    </tr>
                </thead>
                <tbody id="questionBody">
                    <!-- Nội dung câu hỏi sẽ được tải bằng AJAX và hiển thị ở đây -->
                </tbody>
                <div id="questionBody">
                        <!-- Nội dung câu hỏi sẽ được thay thế bằng kết quả tìm kiếm -->
                    </div>
            </table>
        </div>
</body>
</html>
        
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

if (isset($_GET['mamon'])) {
    $mamon = $_GET['mamon'];
    $sql = "SELECT * FROM ques_cntt WHERE mamon = '" . $mamon . "'";
    $result = mysqli_query($connect, $sql);
    $stt = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
                <th scope="row">' . $stt . '</th>
                <td>' . $row['cauhoi'] . '</td>
                <td>' . $row['A'] . '</td>
                <td>' . $row['B'] . '</td>
                <td>' . $row['C'] . '</td>
                <td>' . $row['D'] . '</td>
                <td>' . $row['dapan'] . '</td>
                <td><button class="btn btn-danger" onclick="confirmDelete()"><a href="delete.php?deleteid=' . $row['stt'] . '">Xoá</a></button></td>
                <td><button class="btn btn-success"><a href="update.php?editid=' . $row['stt'] . '">Sửa</a></button></td>
            </tr>';
        $stt++;
    }
}
?>

