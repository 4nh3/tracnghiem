<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <table class="table" id="questionTable">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Câu Hỏi</th>
                <th scope="col">A</th>
                <th scope="col">B</th>
                <th scope="col">C</th>
                <th scope="col">D</th>
                <th scope="col">Đáp án đúng</th>
                <th scope="col"><a href="home.php" class="btn btn-warning">Trở lại</a></th>
            </tr>
        </thead>
    </table>
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

if (isset($_GET['search'])) {
  $search = addslashes($_GET['search']);
  $query = "SELECT * FROM ques_nn WHERE cauhoi LIKE '%$search%'";
  $result = mysqli_query($connect, $query);
  $stt = 1;

  // Hiển thị các câu hỏi tìm kiếm được
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
