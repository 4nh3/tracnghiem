<?php
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
$makhoa_gv = $_SESSION['makhoa'];
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
    <title>Tạo bài thi</title>
    <link rel="stylesheet" href="create_test.css">
</head>

<body>
    <div class="wave-container">
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>

    <form id="createTestForm" action="process_test.php" method="POST">
        <div class="form-group">
            <label for="mmon">Mã môn học:</label>
            <select id="mmon" name="mmon">
                <?php foreach ($monhoc as $mon) { ?>
                    <option value="<?php echo $mon['mamon']; ?>"><?php echo $mon['mamon']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="testName">Tên bài thi:</label>
            <input type="text" id="testName" name="testName" required placeholder="Tên bài thi - Mã môn học - Năm học - Lần thi">
        </div>
        <div class="form-group">
            <label for="testDuration">Thời gian làm bài: </label>
            <input type="number" id="testDuration" name="testDuration" required placeholder="Phút">
        </div>
        <div class="form-group">
            <label for="testPassword">Mật khẩu:</label>
            <input type="password" id="testPassword" name="testPassword" required>
        </div>
        <div class="form-group">
            <label for="testAttempts">Số lần làm bài:</label>
            <input type="number" id="testAttempts" name="testAttempts" required>
        </div>

        <div class="form-group">
            <button type="button" id="addQuestionBtn">Thêm câu hỏi</button>
            <button type="button" id="autoAddQuestionsBtn">Câu hỏi tự động</button>
        </div>

        <div id="questionList">
            <table id="questionTable">
                <!-- Các hàng câu hỏi sẽ được thêm vào đây -->
            </table>
        </div>

        <input type="hidden" id="hiddenField" name="questions" value="">
        <input type="hidden" id="hiddenSttField" name="questionStts" value="">
        <!-- Thêm phần tử ẩn để lưu trữ danh sách câu hỏi đã chọn -->
        <div class="form-group">
            <button type="submit" id="btnCreate">Hoàn thành</button>
            <button type="button" onclick="goToHome()" id="back">Thoát</button>
        </div>

    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
   $(document).ready(function () {
    function updateHiddenField() {
        var selectedQuestions = Array.from(document.querySelectorAll('input[name="questions[]"]:checked'));
        var selectedQuestionIds = selectedQuestions.map(question => question.value);
        var selectedQuestionStts = selectedQuestions.map(question => question.dataset.stt);
        document.getElementById('hiddenField').value = JSON.stringify(selectedQuestionIds);
        document.getElementById('hiddenSttField').value = JSON.stringify(selectedQuestionStts);
        console.log(selectedQuestionIds);
        console.log(selectedQuestionStts);
    }

    $("#mmon").change(function () {
        var selectedSubject = $(this).val();
        $.ajax({
            url: "save_test.php",
            method: "POST",
            data: {mmon: selectedSubject},
            success: function (response) {
                $("#questionTable").html(response);
                updateHiddenField();
            }
        });
    });

    function addQuestion() {
        var selectedSubject = $("#mmon").val();
        $.ajax({
            url: "save_test.php",
            method: "POST",
            data: {mmon: selectedSubject},
            success: function (response) {
                $("#questionTable").append(response);
                updateHiddenField();
            }
        });
    }

    function autoAddQuestions() {
        var numberOfQuestions = prompt("Nhập số lượng câu hỏi cần thêm:");
        if (numberOfQuestions !== null && numberOfQuestions !== "") {
            var selectedSubject = $("#mmon").val();
            $.ajax({
                url: "auto_save_test.php",
                method: "POST",
                data: {mmon: selectedSubject, numberOfQuestions: numberOfQuestions},
                success: function (response) {
                    $("#questionTable").append(response);
                    updateHiddenField();
                }
            });
        }
    }

    $("#addQuestionBtn").click(function () {
        addQuestion();
    });

    $("#autoAddQuestionsBtn").click(function () {
        autoAddQuestions();
    });

    // Xử lý sự kiện khi có thay đổi trong form
    $(document).on('change', 'input[name="questions[]"]', function () {
        updateHiddenField();
    });
    $("#back").click(function () {
        window.location.href = "../home/home.php";
    });
});
</script>
</body>

</html>
