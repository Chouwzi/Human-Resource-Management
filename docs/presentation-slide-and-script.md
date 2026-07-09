# CẨM NANG THUYẾT TRÌNH ĐỒ ÁN CUỐI KỲ: HỆ THỐNG QUẢN LÝ NHÂN SỰ (HRM SYSTEM)
**Công nghệ:** Laravel 11 + MySQL | Giao diện Responsive Bootstrap 5
**Thời lượng:** 15 phút tổng (Thuyết trình: 9-10 phút | Demo: 3-4 phút | Q&A: 2 phút)
**Nhóm thực hiện (Nhóm 14):** 5 thành viên (Chương, Nguyên, Dũng, Long, Minh)

---

## PHẦN 1: PHÂN BỔ THỜI GIAN VÀ PHÂN VAI THUYẾT TRÌNH (5 THÀNH VIÊN)
Để đảm bảo tất cả các thành viên đều có điểm thuyết trình và nói đúng chuyên môn đã phát triển:
*   **Speaker 1 (Nguyễn Trần Đình Chương - Trưởng nhóm):** Nói Slide 1, 2, 3 (Mở đầu, Lý do, Kiến trúc chung) & Slide 12 (Tổng kết, Q&A). (Thời gian: ~2.5 phút).
*   **Speaker 2 (Phạm Hoàng Dũng - Dev Backend):** Nói Slide 5 (Phân quyền truy cập) & Slide 10 (Bảo mật thực tế & Kiểm thử). (Thời gian: ~2 phút).
*   **Speaker 3 (Nguyễn Trung Nguyên - Dev Backend):** Nói Slide 8 (Nhân viên: Chấm công & Phép) & Slide 9 (Nghiệp vụ Chốt công tự động). (Thời gian: ~2 phút).
*   **Speaker 4 (Kim Long - Dev Backend/Frontend):** Nói Slide 4 (Thiết kế CSDL ERD) & Slide 6 (Admin/HR: Quản lý nhân viên & Cơ cấu). (Thời gian: ~2 phút).
*   **Speaker 5 (Trần Nhật Minh - UI/UX & Frontend):** Nói Slide 7 (Admin: Hợp đồng & Bảng lương) & Slide 11 (Phân công công việc). (Thời gian: ~1.5 phút).

---

## PHẦN 2: CHI TIẾT 12 SLIDE BÁO CÁO & KỊCH BẢN THOẠI (SPEAKING SCRIPT)

### SLIDE 1: GIỚI THIỆU ĐỀ TÀI & THÀNH VIÊN
*   **Bố cục trực quan (Visual Style):**
    *   *Trái:* Tên đề tài nổi bật: **"HỆ THỐNG QUẢN LÝ NHÂN SỰ (HRM SYSTEM)"** cỡ chữ lớn, font Jakarta. Logo Trường đại học góc trên.
    *   *Phải:* Danh sách 5 thành viên nhóm 14 (Chương - Leader, Nguyên, Dũng, Long, Minh) xếp theo dạng thẻ gọn gàng.
*   **Nội dung Slide (Bullet points):**
    *   Môn học: Lập trình Web và ứng dụng.
    *   Giảng viên hướng dẫn: [Tên Giảng Viên].
    *   Công nghệ cốt lõi: Laravel 11, PHP 8.2+, MySQL, Bootstrap 5.
*   **Kịch bản thoại (Speaker 1 - Chương):**
    > *"Kính chào Thầy và các bạn đã đến với buổi bảo vệ đồ án cuối kỳ môn Lập trình Web của nhóm 14 chúng em. Nhóm chúng em gồm 5 thành viên: em là Nguyễn Trần Đình Chương - trưởng nhóm, cùng các bạn Nguyễn Trung Nguyên, Phạm Hoàng Dũng, Kim Long và Trần Nhật Minh. Hôm nay, nhóm chúng em xin phép trình bày đề tài: **'Hệ thống Quản lý Nhân sự - HRM'**. Đây là một sản phẩm thực tiễn được xây dựng trên nền tảng framework Laravel 11, hướng tới việc tối ưu hóa toàn diện công tác quản trị nhân sự, chấm công và tính toán bảng lương cho các doanh nghiệp vừa và nhỏ. Sau đây, em xin phép bắt đầu buổi thuyết trình."*

---

### SLIDE 2: LÝ DO CHỌN ĐỀ TÀI & MỤC TIÊU HỆ THỐNG
*   **Bố cục trực quan:**
    *   Bố cục Bento Grid 2 cột so sánh tương phản rõ nét:
        *   Cột 1: **"Nỗi đau thực tế"** (Lưu trữ thủ công bằng giấy/Excel rời rạc, sai sót chấm công, rò rỉ dữ liệu lương, phê duyệt phép chậm trễ).
        *   Cột 2: **"Giải pháp số HRM"** (Cơ sở dữ liệu tập trung, chấm công trực tuyến tức thời, tự động hóa tính lương minh bạch, duyệt phép trực quan).
*   **Nội dung Slide (Bullet points):**
    *   *Nỗi đau doanh nghiệp:* Quản lý thông tin thiếu nhất quán; tốn thời gian tổng hợp ngày công và tính lương cuối tháng.
    *   *Mục tiêu phần mềm:* Số hóa 100% hồ sơ nhân viên; tự động hóa luồng chấm công & đối chiếu phép; đảm bảo bảo mật dữ liệu lương.
*   **Kịch bản thoại (Speaker 1 - Chương):**
    > *"Thưa Thầy, phần lớn các doanh nghiệp quy mô vừa và nhỏ hiện nay vẫn đang quản lý hồ sơ nhân viên và tính lương thông qua các file Excel thủ công. Cách làm này không chỉ gây tốn kém thời gian mà còn dễ dẫn đến sai lệch số liệu ngày công và rò rỉ thông tin lương nhạy cảm. 
    > Mục tiêu của hệ thống HRM do nhóm xây dựng là số hóa toàn diện quy trình này: từ việc lưu trữ hồ sơ, ký kết hợp đồng, đến việc cung cấp cổng tự chấm công hàng ngày cho nhân viên, tự động đối chiếu đơn xin nghỉ phép để tính toán bảng lương cuối tháng chính xác 100%."*

---

### SLIDE 3: CÔNG NGHỆ CHỦ ĐẠO & KIẾN TRÚC HỆ THỐNG
*   **Bố cục trực quan:**
    *   Sơ đồ khối Kiến trúc MVC 3 tầng chạy trên nền Laravel 11.
    *   Các biểu tượng logo công nghệ được căn chỉnh gọn gàng dưới dạng bento grid nhỏ.
*   **Nội dung Slide (Bullet points):**
    *   **Backend:** PHP 8.2+, Laravel Framework 11 (Tận dụng Eloquent ORM, Route Middleware, Service Providers).
    *   **Frontend:** Bootstrap 5 (Đảm bảo hiển thị Responsive trên PC, Tablet và Mobile), JavaScript (Tương tác AJAX chấm công thời gian thực).
    *   **Database:** MySQL Server (Quản lý qua Laravel Migrations và DB Seeders tạo dữ liệu mẫu).
*   **Kịch bản thoại (Speaker 1 - Chương):**
    > *"Về mặt kiến trúc, chúng em lựa chọn mô hình MVC cổ điển được hỗ trợ mạnh mẽ bởi Laravel 11. Laravel giúp chúng em tổ chức mã nguồn sạch sẽ, bảo mật cao nhờ tích hợp sẵn các cơ chế bảo vệ web. 
    > Giao diện người dùng được xây dựng hoàn toàn responsive bằng Bootstrap 5 giúp nhân viên dễ dàng check-in ngay trên điện thoại di động khi đến văn phòng. Toàn bộ dữ liệu được lưu trữ có cấu trúc trong MySQL, quản lý nhất quán qua hệ thống migrations của Laravel. Sau đây, em xin nhường mic cho bạn Kim Long trình bày chi tiết về phần thiết kế cơ sở dữ liệu."*

---

### SLIDE 4: THIẾT KẾ CƠ SỞ DỮ LIỆU (ERD)
*   **Bố cục trực quan:**
    *   Sơ đồ ERD (Entity Relationship Diagram) phóng to, làm nổi bật các mối quan hệ thực thể.
    *   Highlight các ràng buộc khóa ngoại quan trọng bằng màu sắc rõ nét.
*   **Nội dung Slide (Bullet points):**
    *   *Các bảng chính:* `users`, `employees`, `departments`, `positions`, `contracts`, `attendance_logs`, `salaries`, `leaves`, `leave_requests`, `leave_types`.
    *   *Tính toàn vẹn dữ liệu:* Ràng buộc khóa ngoại `onDelete('cascade')` hoặc `onDelete('set null')`, thiết lập UNIQUE constraint cho chấm công và lương để tránh dữ liệu rác.
*   **Kịch bản thoại (Speaker 4 - Long):**
    > *"Xin chào Thầy và các bạn, em là Kim Long, em xin phép trình bày về thiết kế cơ sở dữ liệu của hệ thống. Hệ thống gồm các bảng dữ liệu được chuẩn hóa để tránh dư thừa thông tin. 
    > Mối quan hệ 1-1 giữa `users` và `employees` giúp phân tách rõ ràng thông tin tài khoản đăng nhập và hồ sơ nhân sự thực tế. Điểm nổi bật là trường `manager_id` tự liên kết trong bảng `employees` để quản lý cây sơ đồ tổ chức công ty (nhân viên thuộc quản lý của ai). Nhóm cũng thiết lập các ràng buộc duy nhất (Unique Constraints) ở mức database trên bảng `salaries` nhằm ngăn chặn hoàn toàn lỗi nghiệp vụ tạo trùng lặp bảng lương của một nhân viên trong cùng một tháng. Sau đây, xin mời bạn Hoàng Dũng trình bày về phân quyền."*

---

### SLIDE 5: THIẾT KẾ HỆ THỐNG PHÂN QUYỀN (RBAC)
*   **Bố cục trực quan:**
    *   Bảng Ma trận phân quyền (Role Matrix Table) trực quan:
        *   **Admin:** Có dấu Check-green cho tất cả các cột chức năng (kèm biểu tượng Thùng rác biểu thị quyền Xóa).
        *   **HR:** Check-green cho quản lý nhân sự, phòng ban, duyệt phép (nhưng đánh dấu X-red cho phần Lương, Hợp đồng và quyền Xóa).
        *   **Employee:** Chỉ check-green ở các chức năng cá nhân: chấm công, gửi phép, xem lương cá nhân.
*   **Nội dung Slide (Bullet points):**
    *   Cơ chế: Phân quyền truy cập dựa trên vai trò (Role) kiểm soát bằng Route Middleware.
    *   **Admin (Quản trị):** Quản lý tài chính (Lương, Hợp đồng), cấu trúc công ty và có đặc quyền XÓA dữ liệu.
    *   **HR (Nhân sự):** Quản lý hồ sơ nhân viên, cơ cấu phòng ban, duyệt phép. Không có quyền sửa Lương/Hợp đồng và không được xóa để tránh rò rỉ thông tin.
    *   **Employee (Nhân viên):** Chấm công cá nhân, xin nghỉ phép, xem phiếu lương của chính mình.
*   **Kịch bản thoại (Speaker 2 - Dũng):**
    > *"Xin chào Thầy, em là Hoàng Dũng. Để bảo vệ an toàn thông tin tổ chức, hệ thống áp dụng cơ chế phân quyền dựa trên vai trò kiểm soát chặt chẽ thông qua Middleware. 
    > Quyền cao nhất thuộc về Admin, người duy nhất được quản lý hợp đồng lao động, phê duyệt bảng lương tài chính và thực hiện thao tác xóa dữ liệu. 
    > Vai trò HR tập trung vào nghiệp vụ quản lý hồ sơ nhân sự và phê duyệt phép, bị giới hạn hoàn toàn không được xem thông tin lương hay thực hiện thao tác xóa để tránh rò rỉ dữ liệu. 
    > Cuối cùng, nhân viên thông thường chỉ có quyền thao tác trên các tài nguyên cá nhân của chính họ. Tiếp theo, bạn Kim Long sẽ trình bày về phân hệ quản lý nhân sự."*

---

### SLIDE 6: PHÂN HỆ ADMIN/HR - QUẢN LÝ NHÂN SỰ & CƠ CẤU
*   **Bố cục trực quan:**
    *   Screenshot màn hình Quản lý danh sách nhân viên có bộ lọc theo phòng ban và trạng thái.
    *   Screenshot form thêm mới nhân viên, gán vị trí công việc (`position_id`) và người quản lý trực tiếp (`manager_id`).
*   **Nội dung Slide (Bullet points):**
    *   CRUD Phòng ban (`departments`) và Chức vụ (`positions`) linh hoạt.
    *   Quản lý Hồ sơ nhân viên (`employees`): Thông tin liên lạc, mã nhân viên duy nhất (`employee_code`), số căn cước công dân (`citizen_id`).
    *   Giao diện thân thiện, responsive, tích hợp bộ lọc tìm kiếm nhanh theo phòng ban.
*   **Kịch bản thoại (Speaker 4 - Long):**
    > *"Em xin quay lại để trình bày về giao diện Quản lý Nhân sự dành cho Admin và HR. Hệ thống hỗ trợ khởi tạo cơ cấu tổ chức động thông qua việc tạo phòng ban và các chức vụ tương ứng với mức lương mặc định. 
    > Khi tiếp nhận nhân viên mới, HR sẽ điền thông tin chi tiết vào form mẫu. Hệ thống tự động kiểm tra các ràng buộc duy nhất như mã nhân viên và CCCD để tránh trùng lặp thông tin, đồng thời cho phép lựa chọn người quản lý trực tiếp từ danh sách nhân viên hiện hữu. Sau đây, xin mời bạn Nhật Minh trình bày phân hệ hợp đồng và lương."*

---

### SLIDE 7: PHÂN HỆ ADMIN - QUẢN LÝ HỢP ĐỒNG & BẢNG LƯƠNG
*   **Bố cục trực quan:**
    *   Screenshot danh sách Hợp đồng lao động và màn hình Bảng lương tháng.
    *   Hình vẽ công thức tính lương trực quan dạng sơ đồ dòng tiền.
*   **Nội dung Slide (Bullet points):**
    *   *Quản lý hợp đồng:* Lưu vết loại hợp đồng (thử việc, xác định thời hạn, không xác định thời hạn) và mức lương thỏa thuận.
    *   *Công thức tính lương tự động:*
        $$\text{Lương Gross} = \text{Lương cơ bản} + \text{Phụ cấp} + \text{Thưởng}$$
        $$\text{Lương Thực lĩnh (Net)} = \text{Lương Gross} - \text{Khấu trừ}$$
    *   *Quy trình trạng thái lương:* Tạo nháp (Draft) -> Rà soát số công thực tế -> Admin xác nhận thanh toán (Paid) thì nhân viên mới được xem.
*   **Kịch bản thoại (Speaker 5 - Minh):**
    > *"Xin chào Thầy và các bạn, em là Trần Nhật Minh. Em xin phép trình bày Phân hệ quản lý Hợp đồng và Lương của Admin. Mỗi nhân viên khi làm việc sẽ gắn liền với một Hợp đồng lao động quy định mức lương cơ bản và loại hợp đồng. 
    > Bảng lương hàng tháng được tính toán tự động dựa trên mức lương hợp đồng, cộng với phụ cấp và tiền thưởng dự án, đồng thời trừ đi các khoản phạt đi muộn hoặc nghỉ không phép được lấy ra từ dữ liệu chấm công. Bảng lương sẽ được lưu ở trạng thái Nháp (Draft) để Admin rà soát kỹ lưỡng, và chỉ khi Admin đổi trạng thái sang Đã thanh toán (Paid) thì nhân viên mới có thể tra cứu trực tuyến phiếu lương của mình. Sau đây, xin mời bạn Trung Nguyên trình bày về phân hệ chấm công."*

---

### SLIDE 8: PHÂN HỆ NHÂN VIÊN - CHẤM CÔNG VÀ XIN NGHỈ PHÉP
*   **Bố cục trực quan:**
    *   Screenshot nút bấm Check-in/Check-out lớn trên giao diện Mobile.
    *   Screenshot form tạo đơn xin nghỉ phép cá nhân (chọn loại nghỉ phép, ngày bắt đầu, ngày kết thúc và nhập lý do).
*   **Nội dung Slide (Bullet points):**
    *   *Chấm công một chạm:* Tự động ghi nhận thời gian thực tế.
        *   Check-in sau **08:00:00** -> Ghi nhận đi muộn (`late`).
        *   Check-out trước **17:00:00** -> Ghi nhận về sớm (`Về sớm` trong cột ghi chú).
    *   *Phân tích dữ liệu công:* Tính toán chính xác thời gian làm việc thực tế (`worked_minutes`) và thời gian làm thêm giờ (`overtime_minutes`).
    *   *Đơn nghỉ phép:* Đăng ký loại nghỉ phép, hệ thống tự động tính số ngày nghỉ thực tế và gửi duyệt trực tuyến.
*   **Kịch bản thoại (Speaker 3 - Nguyên):**
    > *"Xin chào Thầy, em là Nguyễn Trung Nguyên. Đối với phân hệ Nhân viên, chúng em thiết kế giao diện tối giản, tập trung vào hai tác vụ cốt lõi hàng ngày là Chấm công và Nghỉ phép. 
    > Khi nhân viên bấm Check-in, backend sẽ đối chiếu với mốc thời gian 8 giờ sáng, nếu trễ hơn sẽ tự động chuyển trạng thái ngày công thành đi muộn (late). Khi Check-out, hệ thống tự động so khớp giờ ra về, nếu trước 17 giờ chiều sẽ đánh dấu ghi chú về sớm, ngược lại sẽ tính số phút làm việc thực tế và quy đổi số phút tăng ca (overtime) chính xác làm căn cứ tính lương."*

---

### SLIDE 9: KIẾN TRÚC CODE & XỬ LÝ NGHIỆP VỤ NỔI BẬT
*   **Bố cục trực quan:**
    *   *Trái:* Sơ đồ luồng xử lý Request trong Laravel (Request -> Routing -> Custom Middleware -> Controller -> Blade View).
    *   *Phải:* Đoạn code thực tế của hàm `finalizeAttendance` (chốt công tự động quét vắng mặt và đối chiếu đơn phép được duyệt).
*   **Nội dung Slide (Bullet points):**
    *   *Bộ lọc quyền truy cập (Middleware):* Kiểm tra vai trò người dùng lưu trong session, chặn truy cập URL trái phép từ đầu vào.
    *   *Logic chốt công thông minh (`finalizeAttendance`):* Tự động quét toàn bộ nhân viên vào cuối ngày. Đối với nhân viên không chấm công:
        *   Có đơn nghỉ phép được duyệt (`approved`) -> Chuyển trạng thái công thành nghỉ phép (`leave`).
        *   Không có đơn xin phép -> Chuyển trạng thái công thành vắng không phép (`absent`).
*   **Kịch bản thoại (Speaker 3 - Nguyên):**
    > *"Về mặt kỹ thuật, nhóm xây dựng bộ lọc **Kiểm tra quyền truy cập** (Middleware). Khi người dùng nhấn vào bất kỳ liên kết nào, bộ lọc này sẽ đối chiếu vai trò của họ (Admin, HR hay Nhân viên) được lưu trong Session. Nếu không đúng quyền, hệ thống sẽ lập tức chặn lại và trả về lỗi từ chối truy cập. 
    > Một điểm sáng nghiệp vụ khác là thuật toán **Chốt công ngày** (`finalizeAttendance`). Cuối ngày làm việc, hệ thống tự động quét danh sách nhân sự không chấm công. Nếu họ đã có đơn nghỉ phép được duyệt, hệ thống ghi nhận là nghỉ có phép (`leave`), ngược lại sẽ ghi nhận vắng không phép (`absent`) để trừ lương tự động. Việc này giúp HR cắt giảm hoàn toàn thời gian đối chiếu thủ công. Tiếp theo, bạn Hoàng Dũng trình bày phần bảo mật thực tế và kiểm thử."*

---

### SLIDE 10: BẢO MẬT THỰC TẾ & KIỂM THỬ TỰ ĐỘNG
*   **Bố cục trực quan:**
    *   *Trái:* Danh sách 4 giải pháp bảo mật dữ liệu nhân sự thực tế.
    *   *Phải:* Screenshot cửa sổ Terminal chạy lệnh `php artisan test` với kết quả PASS toàn bộ 100%.
*   **Nội dung Slide (Bullet points):**
    *   **Bảo mật dữ liệu nhân sự:**
        1.  *Chống xem trộm lương:* Truy vấn lương trực tiếp qua Session tài khoản đăng nhập trên Server, người dùng không thể đổi tham số URL để xem lương người khác.
        2.  *Bảo mật phiên làm việc:* Làm mới định danh phiên (Session ID) ngay khi đăng nhập thành công để tránh bị đánh cắp tài khoản từ phiên cũ.
        3.  *Chống chèn mã độc:* Sử dụng Eloquent chống SQL Injection và Blade Engine tự động mã hóa dữ liệu hiển thị (chống XSS).
    *   **Kiểm thử tự động (Automated Test):** Viết 9 Feature Tests chạy qua PHPUnit giúp tự động kiểm tra các chức năng cốt lõi (Auth, Quyền truy cập, Gửi phép) để tránh lỗi phát sinh khi cập nhật code.
*   **Kịch bản thoại (Speaker 2 - Dũng):**
    > *"Em xin quay lại để trình bày về các giải pháp bảo mật và kiểm thử thực tế của hệ thống. Nhóm tập trung giải quyết các bài toán bảo mật dữ liệu nhân sự:
    > Thứ nhất, **Chống xem trộm lương:** Hệ thống không truyền mã nhân viên lên URL. Khi xem lương, code sẽ lấy trực tiếp ID tài khoản từ session trên máy chủ để truy vấn, ngăn chặn tuyệt đối việc đổi số trên URL để xem lương người khác. 
    > Thứ hai, **Bảo mật phiên:** Ngay khi đăng nhập thành công, hệ thống làm mới mã định danh session để bảo vệ tài khoản. 
    > Thứ ba, **Chống mã độc:** Chúng em tận dụng cơ chế lọc tham số của Eloquent và tự động mã hóa ký tự đặc biệt của Blade. 
    > Cuối cùng, nhóm viết 9 kịch bản kiểm thử tự động bằng công cụ PHPUnit để kiểm tra nhanh các chức năng cốt lõi mỗi khi có thay đổi code. Tiếp theo, bạn Nhật Minh sẽ trình bày phần phân công công việc."*

---

### SLIDE 11: PHÂN PHỐI CÔNG VIỆC NHÓM & TỶ LỆ HOÀN THÀNH
*   **Bố cục trực quan:**
    *   Bảng phân công nhiệm vụ (Task Matrix Table) rõ ràng gồm các cột: Thành viên, Nhiệm vụ chính đảm nhiệm, Kết quả đầu ra và Tỷ lệ đóng góp.
*   **Nội dung Slide (Bullet points):**
    *   **Chương (Leader):** Thiết kế CSDL; Lập trình logic Backend (tính lương, hợp đồng); Viết route, middleware và kiểm thử. (100%).
    *   **Nguyên:** Lập trình chấm công (Check-in/out), chốt công ngày tự động và logic duyệt phép. (100%).
    *   **Dũng:** Xây dựng module đăng nhập, quản lý session và bộ lọc phân quyền. (100%).
    *   **Long:** Thiết kế layout cơ sở, định cấu trúc CSS Components và responsive. (100%).
    *   **Minh:** Thiết kế UI/UX các trang nghỉ phép và liên kết Ajax cập nhật badge đếm số đơn phép chờ duyệt. (100%).
*   **Kịch bản thoại (Speaker 5 - Minh):**
    > *"Để hoàn thành dự án đúng thời hạn, nhóm chúng em đã phân chia công việc rõ ràng dựa trên thế mạnh của từng thành viên. Bạn Chương trưởng nhóm đảm nhiệm vai trò kiến trúc sư dữ liệu và lương hợp đồng. Bạn Nguyên chịu trách nhiệm chấm công và duyệt phép. Bạn Dũng phụ trách bảo mật, session và auth. Bạn Long thiết kế css layout và responsive, còn em phụ trách UI/UX và logic Ajax real-time. Toàn bộ các thành viên đều nỗ lực hoàn thành công việc xuất sắc với mức đóng góp đồng thuận là 100%. Sau đây, trưởng nhóm Chương sẽ tổng kết."*

---

### SLIDE 12: TỔNG KẾT, HƯỚNG PHÁT TRIỂN & Q&A
*   **Bố cục trực quan:**
    *   Thông điệp **"TRÂN TRỌNG CẢM ƠN THẦY VÀ CÁC BẠN ĐÃ LẮNG NGHE!"** hiển thị lớn trang trọng ở trung tâm.
    *   Góc phải bên dưới mở ra phần câu hỏi giao lưu Q&A.
*   **Nội dung Slide (Bullet points):**
    *   *Kết quả đạt được:* Hệ thống vận hành ổn định; phân quyền chặt chẽ; giao diện responsive hiện đại; đáp ứng 100% yêu cầu đồ án.
    *   *Định hướng nâng cấp:* Tích hợp chấm công sinh trắc học (FaceID); hỗ trợ xuất báo cáo lương ra PDF/Excel; gửi email tự động khi có đơn nghỉ phép mới.
*   **Kịch bản thoại (Speaker 1 - Chương):**
    > *"Tổng kết lại, sản phẩm Website Quản lý Nhân sự của nhóm đã đạt được các mục tiêu đề ra ban đầu, hoạt động trơn tru tất cả các tính năng cơ bản, bảo mật vững chắc và có giao diện responsive mượt mà. Trong tương lai, chúng em định hướng nâng cấp hệ thống để hỗ trợ xuất báo cáo lương ra file Excel và gửi email thông báo tự động cho quản lý mỗi khi có đơn phép mới. 
    > Sau đây, em xin phép đại diện nhóm tiến hành chạy **Demo trực tiếp trang web** trên máy tính để Thầy có cái nhìn trực quan nhất về sản phẩm. Nhóm chúng em rất mong nhận được những nhận xét và câu hỏi từ phía Thầy để nhóm hoàn thiện đồ án tốt hơn nữa. Em xin trân trọng cảm ơn Thầy!"*

---

## PHẦN 3: KỊCH BẢN LIVE DEMO CHI TIẾT (Thời gian: 3 - 4 phút)
*Chuẩn bị trước:* Bật sẵn trình duyệt Chrome ở chế độ 2 cửa sổ: Một cửa sổ hiển thị giao diện PC (vai trò Admin), một cửa sổ F12 giả lập giao diện Mobile (vai trò Nhân viên). Đã chạy lệnh `db:seed` để có sẵn dữ liệu mẫu thực tế.

1.  **Bước 1: Demo vai trò Nhân viên (Employee) trên Mobile (Thời gian: 1 phút)**
    *   Đăng nhập bằng tài khoản nhân viên (ví dụ: `employee@example.com`). Chỉ ra giao diện đã được responsive vừa vặn với màn hình điện thoại.
    *   Vào tab **Chấm công**: Nhấn nút **Check-in**. Chỉ ra thông báo thành công hiển thị giờ phút thực tế. Giải thích: *"Nếu trễ sau 8 giờ sáng, trạng thái ngày công của em sẽ được ghi nhận là late (đi muộn)"*. Bấm tiếp **Check-out** và chỉ ra hệ thống tính toán thời gian làm việc chính xác.
    *   Vào tab **Đơn xin nghỉ phép**: Tạo một đơn xin phép (chọn từ ngày mai đến ngày kia, chọn lý do 'Nghỉ ốm', viết nội dung lý do và bấm Gửi đơn). Cho thầy xem đơn mới tạo đang ở trạng thái `pending`.
2.  **Bước 2: Demo vai trò HR/Admin trên PC (Thời gian: 1.5 phút)**
    *   Chuyển sang cửa sổ PC của Admin (đăng nhập `admin@example.com`).
    *   Vào trang quản trị, chỉ ra thông báo số lượng đơn phép chờ duyệt tăng lên. Vào mục **Duyệt phép**, tìm đúng đơn xin phép của nhân viên vừa gửi ở Bước 1 và nhấn **Phê duyệt** (Approve).
    *   Vào mục **Chốt công** (Attendance): Nhấp nút **Chốt công hôm nay**. Giải thích cho thầy: *"Lúc này, hệ thống tự động quét và nhận thấy nhân viên này hôm nay vắng mặt nhưng có đơn phép đã duyệt nên trạng thái ngày công tự động chuyển thành 'leave' (nghỉ phép), thay vì 'absent' (vắng không phép) đối với những người khác"*
    *   Vào mục **Bảng Lương** (Salaries): Chỉ ra bảng lương tháng hiện tại của nhân viên. Bấm tạo bảng lương mới hoặc cập nhật lương, giải thích cách hệ thống trừ tiền tự động nếu có ngày công vắng không phép. Đổi trạng thái bảng lương của nhân viên từ `Draft` sang `Paid` (Đã thanh toán).
3.  **Bước 3: Đối chiếu kết quả của Nhân viên (Thời gian: 0.5 phút)**
    *   Quay lại cửa sổ nhân viên (Mobile), reload trang.
    *   Vào mục **Lịch sử phép** -> đơn phép đã chuyển sang trạng thái `approved`.
    *   Vào mục **Phiếu lương** -> phiếu lương tháng hiện tại đã xuất hiện (do Admin đã đổi sang trạng thái `Paid`). Bấm xem chi tiết để chứng minh tính bảo mật và minh bạch.

---

## PHẦN 4: BỘ CÂU HỎI VÀ CÂU TRẢ LỜI VẤN ĐÁP THÔNG THƯỜNG & AN TOÀN (QA CHEAT SHEET)

### Câu 1: Tại sao trong CSDL có cả bảng `leaves` và bảng `leave_requests` nhưng code chỉ dùng bảng `leaves`?
*   **Cách trả lời trung thực & cầu tiến (An toàn 100%):**
    > *"Dạ thưa Thầy, đây là thiếu sót của nhóm trong quá trình thiết kế cơ sở dữ liệu ban đầu. Ban đầu nhóm dự định làm tính năng duyệt phép phức tạp qua bảng `leave_requests`, nhưng sau đó để kịp tiến độ chạy thử nghiệm nghiệp vụ chấm công và tính lương nhanh nhất, nhóm đã tạm thời lưu thông tin nghỉ phép trực tiếp vào bảng phẳng `leaves`. Nhóm đã giữ lại cấu trúc bảng `leave_requests` trong database để định hướng nâng cấp quy trình duyệt phép đa cấp trong phiên bản tiếp theo. Chúng em xin tiếp thu ý kiến của Thầy để chuẩn hóa lại sơ đồ này ạ."*

### Câu 2: Tại sao trường `emp_id` trong bảng `leaves` lại lưu `user_id` của bảng `users` chứ không phải `id` của bảng `employees`?
*   **Cách trả lời trung thực & cầu tiến (An toàn 100%):**
    > *"Dạ thưa Thầy, đây là lỗi đặt tên trường dữ liệu chưa nhất quán của nhóm em khi thiết kế. Bản chất trường này liên kết đến bảng `users` để lấy thông tin tài khoản đăng nhập. Đáng lẽ nhóm phải đặt tên trường là `user_id` để phản ánh đúng liên kết và tránh gây nhầm lẫn với khóa `employee_id` của bảng `employees`. Nhóm em xin tiếp thu ý kiến của Thầy để chỉnh sửa lại tên trường này cho chuẩn hóa và đồng bộ hơn trong mã nguồn ạ."*

### Câu 3: Làm thế nào hệ thống ngăn chặn nhân viên sửa ID trên URL để xem trộm lương của người khác?
*   **Cách trả lời thực tế, dễ hiểu:**
    > *"Dạ thưa Thầy, hệ thống của chúng em không truyền ID nhân viên làm tham số trên URL hay trong request gửi đi khi xem phiếu lương cá nhân. 
    > Trong file `SalaryController.php` ở route xem lương, hệ thống sẽ tự động lấy trực tiếp thông tin tài khoản đang đăng nhập từ Session được lưu trữ an toàn trên Server (`session('user_id')`). Do người dùng ở Client không thể thay đổi được thông tin Session trên máy chủ, nên nhân viên hoàn toàn không có cách nào sửa đổi ID để xem trộm lương của người khác."*

### Câu 4: Em viết PHPUnit test như thế nào? Có chạy thực tế không?
*   **Cách trả lời thực tế, dễ hiểu:**
    > *"Dạ thưa Thầy, nhóm viết các Feature Test để giả lập hành vi cơ bản của người dùng trên hệ thống. Ví dụ: Giả lập một nhân viên đăng nhập vào hệ thống, sau đó gửi yêu cầu xem phiếu lương cá nhân để kiểm tra xem hệ thống có trả về kết quả thành công (mã trạng thái 200) hay không; hoặc giả lập một tài khoản nhân viên cố truy cập trang Admin xem có bị hệ thống chặn lại (trả về mã lỗi 403) hay không. Nhóm chạy các test tự động này bằng dòng lệnh `php artisan test` trước khi cập nhật code để đảm bảo các tính năng đăng nhập và phân quyền không bị lỗi logic."*

### Câu 5: Hệ thống của nhóm xử lý vấn đề bảo mật dữ liệu đầu vào và hiển thị như thế nào?
*   **Cách trả lời thực tế, dễ hiểu:**
    > *"Dạ thưa Thầy:
    > 1. Về dữ liệu đầu vào: Nhóm sử dụng Eloquent ORM của Laravel. Eloquent tự động áp dụng cơ chế tham số hóa truy vấn (Parameter Binding), tách biệt dữ liệu người dùng nhập với câu lệnh SQL, nên ngăn chặn được lỗi SQL Injection.
    > 2. Về dữ liệu hiển thị: Nhóm dùng cú pháp Blade `{{ ... }}`. Cú pháp này tự động chuyển đổi các ký tự đặc biệt (như `<` hay `>`) thành dạng thực thể HTML an toàn, ngăn chặn việc chèn và thực thi các đoạn mã script độc hại (tấn công XSS)."*

### Câu 6: Mối quan hệ đệ quy `manager_id` trong bảng `employees` hoạt động như thế nào khi quản lý nghỉ việc?
*   **Cách trả lời thực tế, dễ hiểu:**
    > *"Dạ thưa Thầy, trường `manager_id` trong bảng `employees` liên kết đến chính khóa chính của bảng `employees` (để chỉ ra ai là người quản lý của nhân viên đó) và cho phép giá trị Null. 
    > Nhóm cấu hình khóa ngoại này với thuộc tính `onDelete('set null')`. Khi một quản lý nghỉ việc và hồ sơ của họ bị xóa khỏi hệ thống, cơ sở dữ liệu sẽ tự động cập nhật trường `manager_id` của các nhân viên cấp dưới trực thuộc về giá trị `Null`. Sau đó, HR có thể dễ dàng phân công lại quản lý mới cho các nhân viên này trên giao diện mà không gặp bất kỳ lỗi xung đột dữ liệu nào."*
