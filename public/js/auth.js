document.addEventListener("DOMContentLoaded", function () {
    // Hàm xử lý chung cho trạng thái Loading
    function setLoading(btn) {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
        btn.style.opacity = "0.7";
        btn.style.pointerEvents = "none";
        btn.disabled = true;
    }

    // 1. Xử lý Form Đăng Nhập
    const loginForm = document.getElementById("loginForm");
    if (loginForm) {
        loginForm.addEventListener("submit", function (e) {
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();
            const errorBox = document.getElementById("js-error-message");
            const btn = document.getElementById("submitBtn");

            // Định dạng chuẩn của 1 email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Reset trạng thái lỗi
            errorBox.style.display = "none";

            // 1. Kiểm tra rỗng
            if (email === "" || password === "") {
                e.preventDefault();
                showError("Vui lòng nhập đủ thông tin!");
                return; // Dừng thực thi các lệnh bên dưới
            }

            // 2. Kiểm tra sai định dạng email
            if (!emailRegex.test(email)) {
                e.preventDefault();
                showError(
                    "Vui lòng nhập đúng định dạng email (vd: abc@domain.com)!",
                );
                return;
            }

            // 3. Kiểm tra độ dài mật khẩu tối thiểu
            if (password.length < 8) {
                e.preventDefault();
                showError("Mật khẩu phải có ít nhất 8 ký tự!");
                return;
            }

            // 4. Hợp lệ -> Khóa cứng nút submit (chỉ nhận 1 lần click) và bật Loading
            btn.disabled = true;
            setLoading(btn);
        });
    }

    // 2. Xử lý Form Quên Mật Khẩu (Mới)
    const forgotForm = document.getElementById("forgotPasswordForm");
    if (forgotForm) {
        forgotForm.addEventListener("submit", function (e) {
            const email = document.getElementById("email").value.trim();
            const errorBox = document.getElementById("js-error-message");

            if (email === "") {
                e.preventDefault();
                errorBox.innerText = "Vui lòng nhập Email để nhận mã OTP!";
                errorBox.style.display = "block";
            } else {
                setLoading(document.getElementById("submitBtn"));
            }
        });
    }

    function showError(msg) {
        const errorBox = document.getElementById("js-error-message");
        if (errorBox) {
            errorBox.innerText = msg;
            errorBox.style.display = "block";
        }
        function showError(msg) {
            // 1. Tìm và Ẩn khung báo lỗi của Server (nếu đang có)
            const serverError = document.getElementById("server-error-message");
            if (serverError) {
                serverError.style.display = "none";
            }

            // 2. Hiển thị khung báo lỗi của JS
            const errorBox = document.getElementById("js-error-message");
            if (errorBox) {
                errorBox.innerText = msg;
                errorBox.style.display = "block";
            }
        }
    }
    // 3. Xử lý Form Xác Thực OTP & Đặt Lại Mật Khẩu
    const otpForm = document.getElementById("otpResetForm");
    const otpInput = document.getElementById("otp");

    // Ép người dùng chỉ được nhập số vào ô OTP
    if (otpInput) {
        otpInput.addEventListener("input", function (e) {
            this.value = this.value.replace(/[^0-9]/g, "");
        });
    }

    if (otpForm) {
        otpForm.addEventListener("submit", function (e) {
            const otp = document.getElementById("otp").value.trim();
            const password = document.getElementById("password").value.trim();
            const passwordConfirm = document
                .getElementById("password_confirmation")
                .value.trim();
            const errorBox = document.getElementById("js-error-message");

            errorBox.style.display = "none";

            // Kiểm tra độ dài mã OTP
            if (otp.length !== 6) {
                e.preventDefault();
                showError("Mã OTP phải bao gồm đúng 6 chữ số!");
                return;
            }

            // Kiểm tra mật khẩu
            if (password === "" || passwordConfirm === "") {
                e.preventDefault();
                showError("Vui lòng nhập đầy đủ mật khẩu mới và xác nhận!");
                return;
            }

            if (password.length < 8) {
                e.preventDefault();
                showError("Mật khẩu mới phải có ít nhất 8 ký tự!");
                return;
            }

            if (password !== passwordConfirm) {
                e.preventDefault();
                showError(
                    "Mật khẩu xác nhận không khớp. Vui lòng kiểm tra lại!",
                );
                return;
            }

            // Hợp lệ -> Khóa nút, bật Loading
            setLoading(document.getElementById("submitBtn"));
        });
    }
});
