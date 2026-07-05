// Xử lý bật/tắt ẩn hiện mật khẩu
function togglePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}

// Lắng nghe sự kiện submit form đăng nhập
document.getElementById("loginForm").addEventListener("submit", function (e) {
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const errorDiv = document.getElementById("js-error-message");
    const submitBtn = document.getElementById("submitBtn");
    const spinner = document.getElementById("loginSpinner");
    const btnText = document.getElementById("btnText");

    // Reset trạng thái hiển thị lỗi trước khi kiểm tra
    errorDiv.style.display = "none";
    errorDiv.innerHTML = "";

    // 1. Kiểm tra để trống
    if (email === "" || password === "") {
        e.preventDefault(); // Ngăn form submit
        errorDiv.style.display = "block";
        errorDiv.innerHTML = "Vui lòng không để trống Email hoặc Mật khẩu.";
        return;
    }

    // 2. Kiểm tra định dạng email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        e.preventDefault();
        errorDiv.style.display = "block";
        errorDiv.innerHTML = "Định dạng email không hợp lệ.";
        return;
    }

    // 3. Chặn khoảng trắng (space) trong mật khẩu
    if (password.includes(" ")) {
        e.preventDefault();
        errorDiv.style.display = "block";
        errorDiv.innerHTML = "Mật khẩu không được chứa khoảng trắng.";
        return;
    }

    // 4. Kiểm tra giới hạn độ dài mật khẩu (tối thiểu 8 ký tự)
    if (password.length < 8) {
        e.preventDefault();
        errorDiv.style.display = "block";
        errorDiv.innerHTML = "Mật khẩu phải có độ dài tối thiểu là 8 ký tự.";
        return;
    }

    // Kích hoạt trạng thái Loading khi dữ liệu hợp lệ
    submitBtn.disabled = true;
    if (spinner) spinner.style.display = "inline-block";
    if (btnText) btnText.innerText = "Đang xử lý...";
});
