<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="exam_test.css">
    <style>
        .answer-list-item.selected {
            background-color: lightgray;
        }
    </style>
</head>

<body>
    <div class="wave-container">
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

    if (isset($_GET['ten_bai_thi'])) {
        $ten_bai_thi = $_GET['ten_bai_thi'];
        // echo $ten_bai_thi;
        // Truy vấn thông tin bài thi
        $sql_baithi = "SELECT * FROM bai_thi WHERE ten_bai_thi = '$ten_bai_thi'";
        $query_baithi = mysqli_query($connect, $sql_baithi);
        $num_rows_baithi = mysqli_num_rows($query_baithi);

        if ($num_rows_baithi == 1) {
            $row_baithi = mysqli_fetch_assoc($query_baithi);
            $thoi_gian = $row_baithi['thoi_gian'];
            $so_lan_lam_bai = $row_baithi['so_lan_lam_bai'];

            $sql_cauhoi = "SELECT ctbt.stt, q.cauhoi, q.A, q.B, q.C, q.D FROM bai_thi_chi_tiet ctbt
               INNER JOIN ques_$makhoa_gv q ON ctbt.stt = q.stt
               INNER JOIN bai_thi bt ON ctbt.bai_thi_id = bt.id
               WHERE bt.ten_bai_thi = '$ten_bai_thi'
               ORDER BY RAND()"; // Sắp xếp ngẫu nhiên

            $query_cauhoi = mysqli_query($connect, $sql_cauhoi);

            if (mysqli_num_rows($query_cauhoi) > 0) {
                echo "<div class='timer' id='countdown'></div>"; // Đồng hồ đếm ngược
                echo "<div class='container'>";
                echo "<form id='exam-form' action='submit.php' method='POST'>";
                echo "<input type='hidden' name='ten_bai_thi' value='$ten_bai_thi'>";
                echo "<ol class='question-list'>";

                while ($row_cauhoi = mysqli_fetch_assoc($query_cauhoi)) {
                    $stt = $row_cauhoi['stt'];
                    $cau_hoi = $row_cauhoi['cauhoi'];
                    $dap_an_a = $row_cauhoi['A'];
                    $dap_an_b = $row_cauhoi['B'];
                    $dap_an_c = $row_cauhoi['C'];
                    $dap_an_d = $row_cauhoi['D'];

                    echo "<li class='question' id='question-$stt'>";
                    echo "<p class='question-show'>$cau_hoi</p>";
                    $answers = array($dap_an_a, $dap_an_b, $dap_an_c, $dap_an_d);

                    shuffle($answers);

                    echo "<ul class='answer-list'>";
                    echo "<li class='answer-list-item'><label><input type='radio' name='dap_an_$stt' value='$answers[0]' onclick=\"markQuestion($stt)\"> $answers[0]</label></li>";
                    echo "<li class='answer-list-item'><label><input type='radio' name='dap_an_$stt' value='$answers[1]' onclick=\"markQuestion($stt)\"> $answers[1]</label></li>";
                    echo "<li class='answer-list-item'><label><input type='radio' name='dap_an_$stt' value='$answers[2]' onclick=\"markQuestion($stt)\"> $answers[2]</label></li>";
                    echo "<li class='answer-list-item'><label><input type='radio' name='dap_an_$stt' value='$answers[3]' onclick=\"markQuestion($stt)\"> $answers[3]</label></li>";
                    echo "</ul>";

                    echo "</li>";
                }

                echo "</ol>";
                echo "<input type='hidden' name='selected_answers' id='selected-answers' value=''>";
                echo "<input type='submit' name='submitBtn' value='NỘP BÀI' onclick='confirmSubmit(event)'>";
                echo "</form>";
                echo "</div>";
                
            } else {
                echo "Không có câu hỏi nào cho bài thi này.";
            }
        } else {
            echo "Không tìm thấy bài thi.";
        }
    } else {
        echo "Không có thông tin bài thi.";
    }

    mysqli_close($connect);
    ?>
    <script>

function markQuestion(stt) {
    const selectedAnswers = document.getElementById('selected-answers');
    const selectedOption = document.querySelector(`input[name="dap_an_${stt}"]:checked`);

    if (selectedOption) {
        const selectedAnswer = selectedOption.value;
        selectedAnswers.value += `${stt}:${selectedAnswer};`;

        // Tô màu phần đáp án đã chọn
        const selectedListItem = selectedOption.closest('.answer-list-item');
        selectedListItem.classList.add('selected');
    } else {
        selectedAnswers.value += `${stt}:không có;`; 
    }
}


function confirmSubmit(event) {
    event.preventDefault();
    const confirmSubmit = confirm('Bạn có chắc chắn muốn nộp bài?');
    if (confirmSubmit) {
        const examForm = document.getElementById('exam-form');
        examForm.submit();
    }
}


  // Đồng hồ đếm ngược
  function countdown() {
    const countdownElement = document.getElementById('countdown');
    let timeRemaining = <?php echo $thoi_gian * 60; ?>; // Thời gian tính bằng giây

    const timer = setInterval(() => {
      const minutes = Math.floor(timeRemaining / 60);
      const seconds = timeRemaining % 60;

      countdownElement.innerHTML = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
      timeRemaining--;

      if (timeRemaining < 0) {
        clearInterval(timer);
        const examForm = document.getElementById('exam-form');
        examForm.submit();
      }
    }, 1000);
  }

  countdown(); // Bắt đầu đếm ngược khi tải trang
</script>


</body>

</html>
