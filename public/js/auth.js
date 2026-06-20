document.addEventListener("DOMContentLoaded", function () {
    // Hàm xử lý chung cho trạng thái Loading
    function setLoading(btn) {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
        btn.style.opacity = "0.7";
        btn.style.pointerEvents = "none";
        btn.disabled = true;
    }

    // Hàm hiển thị lỗi JS và ẩn lỗi Server
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
            if (errorBox) {
                errorBox.style.display = "none";
            }

            // Kiểm tra rỗng
            if (email === "" || password === "") {
                e.preventDefault();
                showError("Vui lòng nhập đủ thông tin!");
                return; // Dừng thực thi các lệnh bên dưới
            }

            // Kiểm tra sai định dạng email
            if (!emailRegex.test(email)) {
                e.preventDefault();
                showError(
                    "Vui lòng nhập đúng định dạng email (vd: abc@domain.com)!",
                );
                return;
            }

            // Kiểm tra đuôi email hợp lệ (chỉ cho phép đuôi miền chuẩn)
            const allowedDomains = [
                "@gmail.com",
                "@ut.edu.vn",
                "@outlook.com",
                "@yahoo.com",
            ];
            const domainIndex = email.indexOf("@");
            const enteredDomain =
                domainIndex !== -1 ? email.substring(domainIndex) : "";

            if (domainIndex === -1 || !allowedDomains.includes(enteredDomain)) {
                e.preventDefault();
                showError(
                    "Địa chỉ email không hợp lệ! Vui lòng sử dụng đuôi email chuẩn (vd: @gmail.com, @ut.edu.vn).",
                );

                // Hồi phục lại nút Đăng Nhập để người dùng sửa lại
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = "Đăng Nhập";
                    btn.style.opacity = "1";
                    btn.style.pointerEvents = "auto";
                }
                return;
            }

            // Kiểm tra độ dài mật khẩu tối thiểu
            if (password.length < 8) {
                e.preventDefault();
                showError("Mật khẩu phải có ít nhất 8 ký tự!");
                return;
            }

            // Hợp lệ -> Khóa cứng nút submit (chỉ nhận 1 lần click) và bật Loading
            if (btn) {
                setLoading(btn);
            }
        });
    }

    // 2. Xử lý Form Quên Mật Khẩu (Bổ sung kiểm tra định dạng & đuôi email)
    const forgotForm = document.getElementById("forgotPasswordForm");
    if (forgotForm) {
        forgotForm.addEventListener("submit", function (e) {
            const email = document.getElementById("email").value.trim();
            const errorBox = document.getElementById("js-error-message");
            const btn = document.getElementById("submitBtn");

            // Định dạng chuẩn của 1 email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (errorBox) {
                errorBox.style.display = "none";
            }

            if (email === "") {
                e.preventDefault();
                showError("Vui lòng nhập Email để nhận mã OTP!");
                if (btn) {
                    btn.disabled = false;
                    btn.style.opacity = "1";
                    btn.style.pointerEvents = "auto";
                }
                return;
            }

            // Kiểm tra sai định dạng email
            if (!emailRegex.test(email)) {
                e.preventDefault();
                showError(
                    "Vui lòng nhập đúng định dạng email (vd: abc@domain.com)!",
                );
                if (btn) {
                    btn.disabled = false;
                    btn.style.opacity = "1";
                    btn.style.pointerEvents = "auto";
                }
                return;
            }

            // Kiểm tra đuôi email hợp lệ (chỉ cho phép đuôi miền chuẩn)
            const allowedDomains = [
                "@gmail.com",
                "@ut.edu.vn",
                "@outlook.com",
                "@yahoo.com",
            ];
            const domainIndex = email.indexOf("@");
            const enteredDomain =
                domainIndex !== -1 ? email.substring(domainIndex) : "";

            if (domainIndex === -1 || !allowedDomains.includes(enteredDomain)) {
                e.preventDefault();
                showError(
                    "Địa chỉ email không hợp lệ! Vui lòng sử dụng đuôi email chuẩn (vd: @gmail.com, @ut.edu.vn).",
                );

                // Hồi phục lại nút Gửi OTP để người dùng sửa lại
                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = "Gửi OTP";
                    btn.style.opacity = "1";
                    btn.style.pointerEvents = "auto";
                }
                return;
            }

            if (btn) {
                setLoading(btn);
            }
        });
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
            const btn = document.getElementById("submitBtn");

            if (errorBox) {
                errorBox.style.display = "none";
            }

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
            if (btn) {
                setLoading(btn);
            }
        });
    }

    // 4. Chức năng Xem/Ẩn mật khẩu (dùng chung cho các màn hình)
    const togglePasswordIcons = document.querySelectorAll(".toggle-password");

    if (togglePasswordIcons.length > 0) {
        togglePasswordIcons.forEach((icon) => {
            icon.addEventListener("click", function () {
                // Lấy đích danh thẻ input dựa vào thuộc tính toggle
                const inputId = this.getAttribute("toggle");
                const passwordInput = document.querySelector(inputId);

                if (passwordInput) {
                    // Kiểm tra loại hiện tại của input
                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        this.classList.remove("fa-eye");
                        this.classList.add("fa-eye-slash"); // Chuyển sang icon mắt bị gạch chéo
                    } else {
                        passwordInput.type = "password";
                        this.classList.remove("fa-eye-slash");
                        this.classList.add("fa-eye"); // Trở lại icon mắt bình thường
                    }
                }
            });
        });
    }
});
