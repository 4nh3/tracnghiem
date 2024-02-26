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

    $monhoc = array();
    $sql = "SELECT mamon, tenmon FROM cnts";
    $result = mysqli_query($connect, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $monhoc[] = $row;
    }
    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Công Nghệ Thủy Sản</title>
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="nav">
        <img src="/img/logo.png" alt="">
        <p>HỆ THỐNG THI TRẮC NGHIỆM <a href="https://www.ctec.edu.vn/ctec/">TRƯỜNG CAO ĐẲNG KINH TẾ - KỸ THUẬT CẦN THƠ</a></p>
    </div>
        <div class="div_them">
            <div class="tthem"><a class="them" href="home.php">THÊM CÂU HỎI</a></div>

            <form class="div_form" action="create.php" method="post" >
                <div class="modal-body">
                    <div class="form-group">
                        <p>Mã môn học</p>
                            <select name="mmon" id="mmon">
                                <?php foreach ($monhoc as $mon) { ?>
                                    <option value="<?php echo $mon['mamon']; ?>"><?php echo $mon['mamon']; ?></option>
                                <?php } ?>
                            </select>
                    </div>

                    <div class="form-group">
                        <p>Nhập câu hỏi</p>
                        <textarea type="text" class="form-control" name="ques" id="txaQuestion" rows="3" placeholder="Nhập câu hỏi" required></textarea>
                    </div>

                    <div class="form-group">
                        <p>Nhập đán án A</p>
                        <input type="text" class="form-control" name="OptionA" id="txaOptionA" rows="1" placeholder="Đáp án A" required></input>
                    </div>

                    <div class="form-group">
                        <p>Nhập đáp án B</p>
                        <input type="text" class="form-control" name="OptionB" id="txaOptionB" rows="1" placeholder="Đáp án B" required></input>
                    </div>

                    <div class="form-group">
                        <p>Nhập đáp án C</p>
                        <input type="text" class="form-control" name="OptionC" id="txaOptionC" rows="1" placeholder="Đáp án C" required></input>
                    </div>

                    <div class="form-group">
                        <p>Nhập đáp án D</p>
                        <input type="text" class="form-control" name="OptionD" id="txaOptionD" rows="1" placeholder="Đáp án D" required></input>
                    </div>

                    <div class="form-group">
                        <p>Đáp án đúng</p>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="answer" id="rdOptionA" value="A" required>Đáp án A</label>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="answer" id="rdOptionB" value="B" required>Đáp án B</label>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="answer" id="rdOptionC" value="C" required>Đáp án C</label>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="answer" id="rdOptionD" value="D" required>Đáp án D</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer" >
                        <button type="submit" class="btn btn-primary" id="btnSubmit" name="btnSubmit" onclick="getSelectedAnswer()">Thêm câu hỏi</button>
                    </div>
            </form>
        </div>

    <div class="content">
        <div class="slidebar">
            <ul class="menu">
                <?php foreach ($monhoc as $mon) { ?>
                    <li onclick="showQuestion('<?php echo $mon['mamon']; ?>')"><?php echo $mon['tenmon'].'<br>'.'<p class="mamon">'.$mon['mamon'].'</p>'; ?></li>
                <?php } ?>
                <li><a href="../home.php">Thoát</a></li>
            </ul>
        </div>

        <div class="ques">
            <table class="table" id="questionTable">
                <thead>
                    
                </thead>
                <tbody id="questionBody">
                    <!-- Nội dung câu hỏi sẽ hiển thị ở đây -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function confirmDelete() {
            // return confirm("Xác nhận xóa?");
        }

        function getSelectedAnswer() {
            var radioButtons = document.getElementsByName("answer");
            var selectedAnswer = "";
                for (var i = 0; i < radioButtons.length; i++) {
                    if (radioButtons[i].checked) {
                        selectedAnswer = radioButtons[i].value;
                        break;
                    }
                }
                console.log("Đáp án được chọn: " + selectedAnswer);
            }

            function hideForm() {
                var formElement = document.querySelector(".div_form");
                formElement.style.display = "none";
            }

            document.addEventListener("DOMContentLoaded", function() {
                var menuItems = document.querySelectorAll(".menu li");
                menuItems.forEach(function(item) {
                    item.addEventListener("click", hideForm);
                });
            });

        function showQuestion(mamon) {
            // console.log("Mamon: " + mamon);
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("questionBody").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "get_questions.php?mamon=" + mamon, true);
            xhttp.send();
        }

        function searchQuestions() {
            var searchKeyword = document.getElementById("txtSearch").value;

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                document.getElementById("questionBody").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "search.php?search=" + searchKeyword, true);
            xhttp.send();
        }  
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
