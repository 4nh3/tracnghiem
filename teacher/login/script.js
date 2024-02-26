window.addEventListener('DOMContentLoaded', function() {
    var rememberCheckbox = document.getElementById('remember');
    var usernameInput = document.getElementById('username');
    var passwordInput = document.getElementById('password');

    // Kiểm tra xem trình duyệt đã lưu tài khoản hay chưa
    var savedUsername = localStorage.getItem('savedUsername');
    var savedPassword = localStorage.getItem('savedPassword');
    var rememberChecked = localStorage.getItem('rememberChecked');

    if (rememberChecked === 'true') {
        rememberCheckbox.checked = true;
        usernameInput.value = savedUsername;
        passwordInput.value = savedPassword;
    }

    // Xử lý sự kiện khi submit form
    document.querySelector('form').addEventListener('submit', function(e) {
        if (rememberCheckbox.checked) {
            // Lưu tài khoản vào local storage
            localStorage.setItem('savedUsername', usernameInput.value);
            localStorage.setItem('savedPassword', passwordInput.value);
            localStorage.setItem('rememberChecked', 'true');
        } else {
            // Xóa tài khoản khỏi local storage
            localStorage.removeItem('savedUsername');
            localStorage.removeItem('savedPassword');
            localStorage.removeItem('rememberChecked');
        }
    })
})

// Xác nhận form
function checkStuff() {
    var username = document.form1.username;
    var password = document.form1.password;
    var msg = document.getElementById('msg');
    
    if (username.value == "") {
      msg.style.display = 'block';
      msg.innerHTML = "Vui lòng nhập username";
      username.focus();
      return false;
    } else {
      msg.innerHTML = "";
    }
    
     if (password.value == "") {
      msg.innerHTML = "Vui lòng nhập password";
      password.focus();
      return false;
    } else {
      msg.innerHTML = "";
    }
  }
  