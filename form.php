<!DOCTYPE html>
<html>
<head>
    <title>Hệ thống thi trắc nghiệm - CTEC</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body id="particles-js">
  <div class="animated bounceInDown">
    <div class="container">
      <span class="error animated tada" id="msg"></span>
      <form name="form1" class="box" onsubmit="return checkStuff()" method="POST" action="login.php">
          <h2>Đăng Nhập</h2>
          <h5>Hệ thống thi trắc nghiệm</h5>
          <input type="text" name="username" placeholder="Username" autocomplete="off" id="username">
          <input type="password" name="password" placeholder="Passsword" id="password" autocomplete="off">
          <label>
            <input type="checkbox" id="remember" name="remember">
            <label for="remember" class="rmb">Nhớ mật khẩu</label>
          </label>
            <input type="submit" value="Sign in" class="btn1" name="btn_submit">
      </form>
      <span>
        <a href="teacher/login/index.php" class="dnthave">Tôi là giảng viên</a>
        <a href="update-form.php" class="dnthave-2">Đổi mật khẩu</a>
      </div> 

      <div class="footer">
        <span><a href="https://www.ctec.edu.vn/ctec/">Trường Cao Đẳng Kinh Tế - Kỹ Thuật Cần Thơ</a></span>
      </div>
  </div>
    <script src="script.js"></script>  
</body>
</html>
