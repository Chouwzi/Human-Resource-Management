# BỐ CỤC SLIDE VÀ KỊCH BẢN THUYẾT TRÌNH BÁO CÁO CUỐI KỲ MÔN LẬP TRÌNH WEB
**Đề tài:** Hệ Thống Quản Lý Nhân Sự (Human Resource Management - HRM)
**Thời lượng:** ~15 phút | **Đối tượng:** Giảng viên & Sinh viên trong lớp

---

## MỤC LỤC SLIDE
- **Slide 1:** Trang tiêu đề & Giới thiệu thành viên nhóm.
- **Slide 2:** Lý do chọn đề tài & Mục tiêu của hệ thống HRM.
- **Slide 3:** Công nghệ sử dụng & Kiến trúc hệ thống.
- **Slide 4:** Thiết kế Cơ sở dữ liệu (Database Schema / ERD).
- **Slide 5:** Thiết kế Hệ thống Phân quyền (Security & Authorization).
- **Slide 6:** Chức năng chính - Phân hệ Admin/HR (Quản lý Nhân sự & Cơ cấu).
- **Slide 7:** Chức năng chính - Phân hệ Admin (Quản lý Hợp đồng & Lương).
- **Slide 8:** Chức năng chính - Phân hệ Employee (Chấm công & Nghỉ phép).
- **Slide 9:** Kiến trúc Code & Xử lý nghiệp vụ nổi bật (Middleware & Event-flow).
- **Slide 10:** Quy trình Kiểm thử & Chất lượng mã nguồn (Testing & Verification).
- **Slide 11:** Phân chia công việc & Tỷ lệ đóng góp (Task Allocation).
- **Slide 12:** Tổng kết, Hướng phát triển & Q&A.

---

## CHI TIẾT TỪNG SLIDE & KỊCH BẢN THOẠI

### SLIDE 1: GIỚI THIỆU ĐỀ TÀI & THÀNH VIÊN
*   **Bố cục trực quan:**
    *   **Trái:** Logo trường, tên đề tài "HỆ THỐNG QUẢN LÝ NHÂN SỰ (HRM SYSTEM ON LARAVEL)".
    *   **Phải:** Tên nhóm, danh sách thành viên + MSSV. Một số biểu tượng logo công nghệ (Laravel, PHP, Bootstrap, MySQL).
*   **Nội dung Slide (Bullet points):**
    *   Môn học: Lập trình Web và ứng dụng.
    *   Giảng viên hướng dẫn.
    *   Thành viên nhóm dự án.
*   **Kịch bản thoại (Thuyết trình viên 1):**
    > *"Lời đầu tiên, em xin gửi lời chào trân trọng nhất đến thầy và toàn thể các bạn có mặt trong buổi bảo vệ ngày hôm nay. Chúng em là nhóm [Tên nhóm] và hôm nay, nhóm rất hào hứng được đại diện trình bày kết quả dự án cuối kỳ môn Lập trình Web với đề tài: 'Hệ thống Quản lý Nhân sự - HRM'. Dự án này được thiết kế và hiện thực hóa dựa trên bài bản phát triển phần mềm thực tế, tối ưu hóa quy trình vận hành cho các doanh nghiệp vừa và nhỏ. Sau đây xin mời thầy và các bạn cùng đi vào chi tiết dự án."*

---

### SLIDE 2: LÝ DO CHỌN ĐỀ TÀI & MỤC TIÊU HỆ THỐNG
*   **Bố cục trực quan:**
    *   Hai cột so sánh: **"Thách thức thực tế"** (Icon cảnh báo / Xoay quanh excel thủ công, lỗi chấm công, rò rỉ dữ liệu lương, chậm trễ phê duyệt phép) vs **"Giải pháp phần mềm"** (Tự động hóa chấm công, tính toán lương minh bạch, tối ưu hóa quy trình số).
*   **Nội dung Slide (Bullet points):**
    *   *Nỗi đau doanh nghiệp*: Quản lý thủ công kém bảo mật, tốn thời gian.
    *   *Mục tiêu cốt lõi*: Số hóa toàn diện hồ sơ, tự động hóa luồng chấm công & phê duyệt phép, bảo vệ thông tin mật.
    *   *Lợi ích mang lại*: Tiết kiệm chi phí vận hành, cải thiện trải nghiệm nhân viên.
*   **Kịch bản thoại (Thuyết trình viên 1):**
    > *"Thưa thầy và các bạn, hầu hết doanh nghiệp vừa và nhỏ hiện nay vẫn đang chật vật quản lý thông tin nhân viên qua các file Excel rời rạc. Điều này vừa dẫn đến thất thoát dữ liệu, vừa tốn thời gian khi nhân viên muốn xin nghỉ phép hoặc xem bảng lương. Hệ thống HRM của chúng em ra đời nhằm giải quyết triệt để vấn đề này, đưa mọi tác vụ từ khai báo thông tin, lưu trữ hợp đồng, chấm công hàng ngày cho tới tự động hóa tính lương và phê duyệt nghỉ phép lên một nền tảng tập trung duy nhất, khoa học và hoàn toàn responsive."*

---

### SLIDE 3: KIẾN TRÚC HỆ THỐNG & CÔNG NGHỆ CHỦ ĐẠO
*   **Bố cục trực quan:**
    *   Sơ đồ kiến trúc 3 lớp (3-tier architecture): Client (Blade views) <=> Backend (Laravel 11 PHP Controller/Middleware) <=> Database Storage (MySQL).
*   **Nội dung Slide (Bullet points):**
    *   **Backend**: PHP 8.2+, Laravel Framework 11 (MVC Pattern).
    *   **Frontend**: HTML5/CSS3, Bootstrap, Vanilla JS & AJAX.
    *   **Database**: MySQL/SQLite (Sử dụng Laravel Migrations & Seeders).
    *   **Dependencies**: Composer.
*   **Kịch bản thoại (Thuyết trình viên 1):**
    > *"Về kiến trúc công nghệ, chúng em lựa chọn Laravel 11 – một framework PHP hiện đại bậc nhất, nổi tiếng với sự bảo mật và kiến trúc MVC phân tách rõ ràng. Phần giao diện hiển thị sử dụng Blade template engine kết hợp với Bootstrap để tối ưu hiển thị trên các thiết bị di động. Về phần dữ liệu, nhóm sử dụng MySQL để quản lý tập trung và thiết kế hệ thống thông qua Laravel Migration, giúp việc triển khai dự án trên mọi môi trường máy chủ cực kỳ nhanh chóng và nhất quán."*

---

### SLIDE 4: THIẾT KẾ CƠ SỞ DỮ LIỆU (ERD)
*   **Bố cục trực quan:**
    *   Hình ảnh sơ đồ ERD trực quan (hoặc sơ đồ Mermaid). Làm nổi bật các bảng cốt lõi: `users`, `employees`, `contracts`, `attendance_logs`, `salaries`, `leave_requests`.
*   **Nội dung Slide (Bullet points):**
    *   Tổng số lượng bảng: 11 bảng được thiết kế chuẩn hóa 3NF.
    *   *Quan hệ 1-1*: `users` và `employees`.
    *   *Quan hệ 1-N*: `departments` -> `positions` -> `employees`; `employees` -> `contracts`/`attendance_logs`/`leave_requests`/`salaries`.
    *   *Ràng buộc đặc biệt*: Khóa phức hợp (composite key) `uq_salary_employee_month_year` ngăn chặn nhân bản bản ghi lương.
*   **Kịch bản thoại (Thuyết trình viên 2):**
    > *(Người thuyết trình 2 nhận mic)*
    > *"Sau đây em xin đại diện nhóm trình bày về phần Phân tích Thiết kế Cơ sở dữ liệu. Nhìn vào sơ đồ ERD, hệ thống của chúng em có tất cả 11 bảng được chuẩn hóa cao. Điểm mấu chốt là sự phân tách giữa thực tế đăng nhập tài khoản (`users`) và hồ sơ vật lý của nhân sự (`employees`) bằng quan hệ một-một. Cơ cấu tổ chức được phân rã rõ ràng qua phòng ban (`departments`) và chức vụ (`positions`). Để đảm bảo tính toàn vẹn của dữ liệu trong quá trình vận hành, nhóm đã bổ sung các chỉ mục khóa duy nhất, ví dụ như tránh việc tạo trùng lặp bảng lương của một nhân viên trong cùng một tháng bằng khóa phức hợp trên bảng `salaries`."*

---

### SLIDE 5: THIẾT KẾ PHÂN QUYỀN HỆ THỐNG
*   **Bố cục trực quan:**
    *   Bảng ma trận phân quyền (Role Matrix): Cột chức năng (Lương, Hợp đồng, Công, Phép) vs Dòng vai trò (Admin, HR, Employee). Đánh dấu tick xanh/chữ X đỏ thể hiện quyền hạn.
*   **Nội dung Slide (Bullet points):**
    *   Cơ chế: Role-based Access Control (RBAC).
    *   **Admin (Quản trị tối cao)**: Toàn quyền hệ thống, quản lý tài chính (Lương/Hợp đồng) và sở hữu quyền XÓA (Delete).
    *   **HR (Quản lý hồ sơ)**: Thêm/Sửa nhân sự, phòng ban, chốt công, xem danh sách nghỉ phép. Không có quyền sửa Lương/Hợp đồng hoặc Xóa dữ liệu chính.
    *   **Employee (Nhân viên)**: Sử dụng các tính năng cá nhân (check-in, check-out, xem lịch sử công, làm đơn xin phép và xem bảng lương bản thân).
*   **Kịch bản thoại (Thuyết trình viên 2):**
    > *"Một yêu cầu bắt buộc của giảng viên đối với dự án là tính phân quyền. Chúng em đã chia quyền hệ thống làm 3 mức rõ rệt bằng cơ chế Middleware trong Laravel:
    > Thứ nhất, Admin có quyền tối cao từ chấm công, quản lý cơ cấu tới sửa lương, hợp đồng và có thẩm quyền xóa dữ liệu.
    > Thứ hai, nhân sự HR tập trung quản lý hồ sơ nhân viên và phòng ban, duyệt phép nhưng hoàn toàn không thể can thiệp vào bảng lương, hợp đồng của nhân viên khác hay xóa dữ liệu.
    > Cuối cùng là Nhân viên chỉ được xem và tương tác với dữ liệu của chính mình để tránh vi phạm quyền riêng tư."*

---

### SLIDE 6: PHÂN HỆ ADMIN/HR - QUẢN LÝ NHÂN SỰ
*   **Bố cục trực quan:**
    *   Chụp ảnh màn hình (Screenshot) giao diện: Danh sách nhân viên, form thêm mới/cập nhật thông tin nhân viên, cơ cấu phòng ban và vị trí công việc.
*   **Nội dung Slide (Bullet points):**
    *   CRUD Phòng ban (`departments`) & Chức vụ (`positions`).
    *   Quản lý Hồ sơ nhân sự (`employees`): Thông tin liên lạc, mã định danh nhân viên cơ sở (Employee Code), sơ đồ người quản lý trực tiếp (`manager_id`).
    *   Giao diện bộ lọc thông minh, hỗ trợ sắp xếp theo phòng ban hoặc phân loại trạng thái làm việc (thử việc, chính thức, nghỉ việc).
*   **Kịch bản thoại (Thuyết trình viên 2):**
    > *"Đây là giao diện Quản lý Tổ chức dành cho ADMIN và HR. Tại đây, hệ thống hỗ trợ tạo mới phòng ban, định hình các vị trí công việc kèm theo mức lương cơ bản mặc định. Tiếp đó là tính năng tuyển dụng và quản lý hồ sơ nhân viên. Điểm đặc biệt của codebase là khi tạo tài khoản nhân viên, hệ thống sẽ tự động gán mã nhân viên duy nhất và cho phép chỉ định trực tiếp người quản lý thiết lập liên kết cấu trúc cây nhân sự trong công ty."*

---

### SLIDE 7: PHÂN HỆ ADMIN - QUẢN LÝ HỢP ĐỒNG & LƯƠNG
*   **Bố cục trực quan:**
    *   Screenshot giao diện bảng lương tháng (Salaries list), chi tiết tính toán Lương Gross/Net, giao diện quản lý Hợp đồng lao động. Ghi chú rõ chỉ có Admin mới có quyền truy cập ở đây.
*   **Nội dung Slide (Bullet points):**
    *   *Hợp đồng*: Quản lý loại hợp đồng (thử việc, có thời hạn, không thời hạn), hạn hợp đồng và theo dõi trạng thái kích hoạt.
    *   *Tính lương tự động*: Gross salary = Base salary + Allowance + Bonus. Net salary = Gross salary - Deduction.
    *   *Trạng thái*: Chốt nháp (Draft), Duyệt & trả lương (Paid) ghi nhận thời gian thực tế chi trả.
*   **Kịch bản thoại (Thuyết trình viên 3):**
    > *(Người thuyết trình 3 nhận mic)*
    > *"Tiếp theo, em xin giới thiệu phần Quản lý Tài chính - Hợp đồng và Lương. Chức năng này được khóa chặt, chỉ cho phép vai trò Admin thao tác. Chúng em đã xây dựng công thức tính lương dựa trên luật lao động cơ bản: Lương thực lĩnh = Lương cơ bản trong hợp đồng + Phụ cấp + Thưởng - Các khoản giảm trừ. Bản ghi lương được tạo dưới dạng nháp để Admin rà soát, và sau khi thực hiện giao dịch thanh toán xong mới đổi trạng thái sang 'Paid' để ghi nhận, đồng thời cho nhân viên xem qua tài khoản cá nhân."*

---

### SLIDE 8: PHÂN HỆ EMPLOYEE - CHẤM CÔNG & NGHỈ PHÉP
*   **Bố cục trực quan:**
    *   Screenshot giao diện Check-in/Check-out thời gian thực trên giao diện nhân viên. Screenshot giao diện gửi đơn nghỉ phép và danh sách duyệt phép của quản lý.
*   **Nội dung Slide (Bullet points):**
    *   *Chấm công*: Một chạm Check-in/Check-out hàng ngày. Thuật toán tự động tính toán tổng số phút làm việc thực tế (`worked_minutes`) và số phút tăng ca (`overtime_minutes`).
    *   *Nghỉ phép*: Nhân viên làm đơn xin phép ghi nhận lý do, loại nghỉ phép (phép năm, nghỉ ốm, việc riêng, ...). Phía quản trị viên (Admin/HR) nhận thông báo duyệt hoặc từ chối thông qua giao diện trực quan.
*   **Kịch bản thoại (Thuyết trình viên 3):**
    > *"Về phía Nhân viên, chúng em tập trung thiết kế luồng quy trình tối giản, tiện lợi nhất. Khi đến công ty, nhân viên chỉ việc nhấn 'Check-in', và trước khi về nhấn 'Check-out'. Code xử lý ở backend sẽ tự động tính toán số giờ làm việc thực tế và làm cơ sở tính lương tăng ca. Nhân viên cũng dễ dàng theo dõi thời gian nghỉ phép của mình. Hệ thống sẽ tự động trừ đi số ngày nghỉ khi đơn xin phép được Admin hoặc HR phê duyệt."*

---

### SLIDE 9: KIẾN TRÚC CODE & XỬ LÝ NGHIỆP VỤ NỔI BẬT
*   **Bố cục trực quan:**
    *   Bên trái: Sơ đồ luồng đi của Request thông qua `Kernel -> Middleware -> Controller -> Model -> Response`.
    *   Bên phải: Đoạn code minh họa ngắn của `RequireRole` Middleware (chỉ ra cách so khớp thông tin từ session).
*   **Nội dung Slide (Bullet points):**
    *   *Custom Middleware*: `RequireRole.php` tối ưu việc kiểm tra quyền hạn của Session User trước khi cho phép vào Router.
    *   *MVC Controller*: `AdminHrmController.php` điều hành toàn bộ logic nhân sự, bảo mật phân tách ở mức phương thức.
    *   *ORM Eloquent*: Tận dụng các Laravel Model Relation giúp truy cập mượt mà dữ liệu liên kết mà không cần viết các câu lệnh JOIN SQL phức tạp.
*   **Kịch bản thoại (Thuyết trình viên 3):**
    > *"Để thuyết phục giảng viên về chất lượng kỹ thuật của mã nguồn, ban nhóm xin trình bày thiết kế luồng xử lý ở backend. Thay vì kiểm tra quyền thủ công ở mọi Controller, nhóm đã thiết kế một Middleware dùng chung có tên `require.role`. Khi có request gửi lên, Middleware này sẽ lấy vai trò lưu trong session để so khớp với quyền tối thiểu của route đó. Nếu không đáp ứng sẽ trả ngay lỗi 403. Việc này giúp code cực kỳ sạch, dễ mở rộng và ngăn chặn hoàn toàn xâm nhập trái phép vào hệ thống."*

---

### SLIDE 10: QUY TRÌNH KIỂM THỬ (TESTING & VERIFICATION)
*   **Bố cục trực quan:**
    *   Kết quả chạy lệnh test trên terminal: `php artisan test`. Hộp hiển thị kết quả kiểm thử mượt mà với 100% test pass. Các ca kiểm thử chính được liệt kê.
*   **Nội dung Slide (Bullet points):**
    *   Sử dụng framework kiểm thử: PHPUnit tích hợp trong Laravel.
    *   *Các ca kiểm thử quan trọng*: 
        *   `AuthControllerTest`: Xác thực đăng nhập đúng/sai vai trò.
        *   `PendingLeaveCountTest`: API đếm đơn nghỉ phép chưa duyệt.
        *   `ModelRelationshipsTest`: Kiểm thử tính toàn vẹn khóa ngoại Eloquent.
        *   `SalaryControllerTest` & `ContractControllerTest`: Bảo mật ngăn chặn nhân viên truy cập thông tin tài chính người khác.
*   **Kịch bản thoại (Thuyết trình viên 3):**
    > *"Nhóm chúng em đề cao tính ổn định của hệ thống bằng việc đầu tư viết các bài Test tự động hóa. Chúng em có tổng cộng hàng chục ca kiểm thử tích hợp (Feature & Integration testing) chạy bằng PHPUnit. Hệ thống kiểm thử tự động quét các trường hợp biên như: Thử đăng nhập sai tài khoản, nhân sự cố tình truy cập vào trang xem hợp đồng lương của người khác, hoặc đảm bảo API trả về đúng số lượng đơn phép chờ duyệt. Toàn bộ các bài kiểm tra đều vượt qua tuyệt đối (100% tests passed)."*

---

### SLIDE 11: PHÂN CHIA CÔNG VIỆC NHÓM
*   **Bố cục trực quan:**
    *   Bản phân chia công việc (Gantt chart/Bảng phân công). Cột Thành viên - Nhiệm vụ đảm trách - Tỷ lệ phần trăm hoàn thành.
*   **Nội dung Slide (Bullet points):**
    *   **Thành viên A (Trưởng nhóm)**: Thiết kế CSDL, Code nghiệp vụ backend (Lương, Hợp đồng, Chấm công), viết PHPUnit test. (Đóng góp: 100%).
    *   **Thành viên B**: Thiết kế kiến trúc và luồng phân quyền, code Frontend Bootstrap, tích hợp giao diện responsive. (Đóng góp: 100%).
    *   **Thành viên C**: Soạn thảo báo cáo, thiết kế slide thuyết trình, kiểm thử biên thủ công trên trình duyệt. (Đóng góp: 100%).
*   **Kịch bản thoại (Thuyết trình viên 1):**
    > *(Thuyết trình viên 1 nhận lại mic)*
    > *"Cuối cùng về mặt nhân sự nội bộ, nhóm chúng em phân chia công việc rõ ràng dựa trên năng lực thành viên. Chúng em có sự phối hợp ăn ý từ khâu thiết kế cơ sở dữ liệu ban đầu cho tới lập trình frontend, kiểm thử chất lượng và chuẩn bị tài liệu báo cáo. Nhóm đồng thuận đánh giá mức độ đóng góp của tất cả thành viên là 100%, ai cũng nỗ lực hết mình để đưa dự án HRM về đích đúng tiến độ."*

---

### SLIDE 12: TỔNG KẾT & Q&A
*   **Bố cục trực quan:**
    *   Chữ **"CẢM ƠN THẦY VÀ CÁC BẠN ĐÃ LẮNG NGHE"** lớn ở trung tâm. Thông tin liên hệ, và góc "Q&A" kèm hiệu ứng hình ảnh mời gọi câu hỏi.
*   **Nội dung Slide (Bullet points):**
    *   *Kết quả*: Hệ thống chạy mượt mà, đáp ứng 100% yêu cầu đề bài.
    *   *Hướng phát triển*: Tích hợp máy chấm công khuôn mặt (FaceID), xuất báo cáo lương ra PDF/Excel, gửi email tự động nhận thông báo nghỉ phép.
*   **Kịch bản thoại (Thuyết trình viên 1):**
    > *"Tổng kết lại, ứng dụng quản lý nhân sự HRM của nhóm đã hoàn thành xuất sắc các tiêu chí kỹ thuật: Giao diện hiện đại responsive, phân quyền chặt chẽ, đầy đủ tính năng CRUD và có bộ kiểm thử tự động toàn diện. Trong tương lai, chúng em mong muốn phát triển thêm các tính năng nâng cao như trích xuất báo cáo lương sang PDF và tích hợp chấm công sinh trắc học. 
    > Sau đây, nhóm chúng em xin phép được demo trực tiếp phần mềm chạy thực tế trên máy chủ để thầy và các bạn cùng đánh giá trực quan nhất. Đồng thời chúng em rất mong nhận được những góp ý, câu hỏi từ thầy để nhóm tiếp tục cải thiện sản phẩm tốt hơn. Xin trân trọng cảm ơn!"*
