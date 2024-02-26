<!DOCTYPE html>
<html>
<head>
    <title>Hệ thống thi trắc nghiệm - CTEC</title>
    <link rel="stylesheet" type="text/css" href="update.css">
</head>
<body id="particles-js">
  <div class="animated bounceInDown">
    <div class="container">
    <span class="error animated tada" id="msg"></span>

      <form name="form1" class="box" onsubmit="return checkStuff()" method="POST" action="update.php">
            <h2>ĐỔI MẬT KHẨU</h2>
            <h5>Hệ thống thi trắc nghiệm</h5>
            <input type="text" name="username" placeholder="Username" autocomplete="off" id="username">
            <input type="password" name="current_password" placeholder="Nhập mật khẩu hiện tại" id="password" autocomplete="off">
            <input type="password" name="new_password" placeholder="Nhập mật khẩu mới" id="password" autocomplete="off">
            <input type="password" name="confirm_password" placeholder="Nhập lại mật khẩu mới" id="password" autocomplete="off">
            <input type="submit" value="Cập Nhật" class="btn1" name="btn_submit">
      </form>
    </div> 
      <div class="footer">
        <span><a href="https://www.ctec.edu.vn/ctec/">Trường Cao Đẳng Kinh Tế - Kỹ Thuật Cần Thơ</a></span>
      </div>
  </div>
    <script src="script.js"></script>  
</body>
</html>
