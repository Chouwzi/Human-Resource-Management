# CẨM NANG THUYẾT TRÌNH BÁO CÁO BÀI TẬP LỚN HRM
**Người thuyết trình & Demo:** Nguyễn Trần Đình Chương (Trưởng nhóm)
**Thời lượng tối ưu:** 12-15 phút tổng (Thuyết trình: 8 phút | Live Demo: 4 phút | Hỏi đáp: 2 phút)

---

## PHẦN 1: KỸ NĂNG VẬT LÝ & TƯ THẾ TRÊN SÂN KHẤU

*   **Tư thế đứng chéo 45 độ:** Đứng nghiêng so với màn hình LCD. Một vai hướng về màn hình để chỉ thông tin, một vai hướng xuống giảng viên và các bạn sinh viên. Tuyệt đối không quay lưng 100% về phía người nghe.
*   **Chỉ màn hình bằng lòng bàn tay ngửa:** Đứng bên trái màn hình thì dùng tay phải để chỉ, đứng bên phải thì dùng tay trái. Chỉ bằng lòng bàn tay ngửa hướng lên trên, tránh dùng ngón trỏ chỉ trỏ.
*   **Vừa thuyết trình vừa Demo một mình:** Chỉ định 1 thành viên trong nhóm (ví dụ bạn Long hoặc Minh) ngồi máy tính thao tác click chuột/gõ phím theo lời nói của bạn để bạn rảnh cả hai tay cầm mic và thuyết minh trước lớp. Nếu tự bấm máy, hãy kẹp mic vào chân đế đặt sẵn trên bàn.

---

## PHẦN 2: KỊCH BẢN THOẠI & GIẢI THÍCH THUẬT NGỮ TỪNG SLIDE

### SLIDE 1: GIỚI THIỆU ĐỀ TÀI & THÀNH VIÊN
*   **Bố cục hiển thị:** Logo trường, Tên đề tài: **"HỆ THỐNG QUẢN LÝ NHÂN SỰ (HRM SYSTEM)"**. Danh sách 5 thành viên Nhóm 14 kèm MSSV. Logo công nghệ: Laravel, PHP, Bootstrap, MySQL.
*   **Cử chỉ:** Đứng thẳng ở trung tâm, tay cầm mic cách cằm 5cm. Tay tự do mở rộng tự nhiên. Mắt nhìn bao quát cả lớp, mỉm cười chào tự tin.
*   **Kịch bản thoại:**
    > *"Kính chào giảng viên cùng toàn thể các bạn sinh viên. Nhóm mình là Nhóm 14. Hôm nay, mình xin đại diện nhóm báo cáo bài tập lớn môn Lập trình Web với đề tài: **'Hệ thống Quản lý Nhân sự - HRM'**. 
    > Sản phẩm được nhóm mình xây dựng trên nền tảng framework Laravel 11 kết hợp cơ sở dữ liệu MySQL và thư viện giao diện Bootstrap 5, hướng tới việc tự động hóa chấm công và tính lương cho các doanh nghiệp vừa và nhỏ."*
*   **💡 Giải thích thuật ngữ cho Chương:**
    *   **Framework (Laravel 11):** Giống như *khung nhà lắp ghép* có sẵn móng, cột, điện nước. Nhóm chỉ việc xây tường và sơn (viết logic nhân sự) chứ không cần tự code lại từ đầu.
    *   **PHP:** Ngôn ngữ lập trình backend dùng để xử lý logic trên máy chủ.
    *   **MySQL:** Cơ sở dữ liệu dùng để lưu trữ thông tin (thông tin nhân viên, ngày công, lương).

---

### SLIDE 2: LÝ DO CHỌN ĐỀ TÀI & MỤC TIÊU HỆ THỐNG
*   **Bố cục hiển thị:** Bento Grid 2 cột: Cột 1 (Nỗi đau Excel thủ công, sai sót ngày công, rò rỉ lương) đối lập với Cột 2 (Hệ thống HRM chấm công trực tuyến, tự động tính lương, duyệt phép tức thời).
*   **Cử chỉ:** Tay phải mở ngửa chỉ cột "Nỗi đau" (nét mặt nghiêm túc), sau đó xoay tay chỉ sang cột "Giải pháp" (mỉm cười nhẹ).
*   **Kịch bản thoại:**
    > *"Thưa giảng viên và các bạn, phần lớn doanh nghiệp vừa và nhỏ hiện nay vẫn quản lý nhân sự qua file Excel thủ công, rất tốn thời gian, dễ sai lệch ngày công và rò rỉ bảng lương nhạy cảm. 
    > Mục tiêu của hệ thống HRM này là số hóa toàn bộ quy trình: lưu dữ liệu tập trung, cho phép nhân viên chấm công trực tuyến bằng điện thoại, tự động đối chiếu ngày nghỉ phép để tính lương cuối tháng chính xác 100%."*
*   **💡 Giải thích thuật ngữ cho Chương:**
    *   **Số hóa:** Chuyển đổi toàn bộ quy trình giấy tờ, file Excel rời rạc sang lưu trữ dữ liệu số trên máy chủ để máy tính tự động xử lý.

---

### SLIDE 3: CÔNG NGHỆ CHỦ ĐẠO & KIẾN TRÚC HỆ THỐNG
*   **Bố cục hiển thị:** Sơ đồ khối kiến trúc 3 lớp: Client (Giao diện hiển thị) <=> Backend Laravel (Logic xử lý & Bộ lọc) <=> Database MySQL (Lưu trữ dữ liệu).
*   **Cử chỉ:** Đứng chếch 45 độ, chỉ vào khối trung tâm "Backend Laravel" trên màn hình.
*   **Kịch bản thoại:**
    > *"Về mặt kiến trúc, nhóm mình lựa chọn mô hình MVC được hỗ trợ bởi Laravel 11. Giao diện được thiết kế responsive bằng Bootstrap 5 để hiển thị tối ưu trên cả máy tính lẫn di động. Dữ liệu được lưu trữ có cấu trúc trong MySQL và được quản lý nhất quán qua hệ thống migrations."*
*   **💡 Giải thích thuật ngữ cho Chương:**
    *   **MVC (Model - View - Controller):** Chia code làm 3 phần như quy trình nhà hàng: View là bàn ăn nơi khách ngồi (giao diện), Controller là phục vụ bàn (nhận yêu cầu, điều hướng logic), Model là nhà bếp (truy xuất dữ liệu).
    *   **Responsive:** Khả năng tự động co giãn giao diện cho vừa vặn với kích thước màn hình PC, máy tính bảng hoặc điện thoại di động.
    *   **Migrations:** Lịch sử phiên bản của cơ sở dữ liệu giúp cả nhóm tạo bảng đồng bộ bằng lệnh mà không cần gửi file SQL thủ công.

---

### SLIDE 4: THIẾT KẾ CƠ SỞ DỮ LIỆU (CSDL - ERD)
*   **Bố cục hiển thị:** Sơ đồ ERD phóng lớn. Làm nổi bật các bảng chính và các liên kết khóa ngoại.
*   **Cử chỉ:** Chỉ vào trường `manager_id` tự liên kết và chỉ mục duy nhất của bảng lương.
*   **Kịch bản thoại:**
    > *"CSDL của hệ thống gồm 11 bảng được chuẩn hóa để tránh trùng lặp thông tin. Điểm nổi bật là trường `manager_id` tự liên kết lại chính bảng nhân viên để quản lý cây sơ đồ tổ chức công ty. Nhóm cũng thiết lập các chỉ mục duy nhất ở mức cơ sở dữ liệu để ngăn ngừa tuyệt đối lỗi tạo trùng lặp bảng lương của nhân viên trong cùng một tháng."*
*   **💡 Giải thích thuật ngữ cho Chương:**
    *   **Chuẩn hóa CSDL:** Sắp xếp các bảng dữ liệu khoa học để không có thông tin nào bị trùng lặp thừa thãi.
    *   **Khóa ngoại đệ quy `manager_id`:** Nhân viên trỏ đến ID của quản lý, mà quản lý cũng là nhân viên. Giúp tạo sơ đồ phân cấp trực tiếp trong cùng một bảng.
    *   **Chỉ mục duy nhất (Unique Index):** Ràng buộc ở tầng database không cho phép lưu trùng lặp dữ liệu (ví dụ: không cho phép tạo 2 phiếu lương trùng nhân viên + trùng tháng).

---

### SLIDE 5: THIẾT HỆ HỆ THỐNG PHÂN QUYỀN (RBAC)
*   **Bố cục hiển thị:** Bảng ma trận quyền hạn của 3 vai trò: Admin (Toàn quyền), HR (Quản lý hồ sơ & Duyệt phép, không được xóa/sửa lương), Employee (Chỉ thao tác trên thông tin cá nhân).
*   **Cử chỉ:** Nhìn thẳng cả lớp để nhấn mạnh tính bảo mật thông tin.
*   **Kịch bản thoại:**
    > *"Hệ thống áp dụng cơ chế phân quyền dựa trên vai trò, viết tắt là RBAC. Cơ chế này được kiểm soát chặt chẽ thông qua Route Middleware. 
    > Nhờ đó, Admin có toàn quyền quản lý tài chính; HR chỉ quản lý hồ sơ và duyệt phép mà không được xem lương; còn Nhân viên chỉ xem được thông tin của chính mình, đảm bảo an toàn thông tin tối đa."*
*   **💡 Giải thích thuật ngữ cho Chương:**
    *   **RBAC (Role-based Access Control):** Phân quyền dựa trên vai trò chức vụ chứ không phân quyền cho từng cá nhân riêng lẻ.
    *   **Middleware:** Hoạt động như **anh bảo vệ đứng ở cửa quán Bar**. Khi người dùng nhấn vào đường dẫn nhạy cảm, Middleware sẽ chặn lại kiểm tra quyền truy cập. Nếu không phải Admin, Middleware sẽ chặn đứng lại và trả về lỗi `403 Forbidden`.

---

### SLIDE 6: PHÂN HỆ ADMIN/HR - QUẢN LÝ NHÂN SỰ & CƠ CẤU
*   **Bố cục hiển thị:** Screenshot danh sách nhân viên có bộ lọc phòng ban và chức vụ. Screenshot form thêm nhân viên mới.
*   **Cử chỉ:** Chỉ vào bộ lọc thông minh trên màn hình để minh họa thao tác tìm kiếm nhanh.
*   **Kịch bản thoại:**
    > *"Ở phân hệ nhân sự, HR có thể khởi tạo cơ cấu phòng ban và các chức vụ động. Khi thêm nhân viên mới, hệ thống tự động kiểm tra tính duy nhất của mã nhân viên và CCCD để tránh trùng lặp dữ liệu, đồng thời cho phép gán người quản lý trực tiếp từ danh sách nhân sự hiện có."*
*   **💡 Giải thích thuật ngữ cho Chương:**
    *   **Cơ cấu tổ chức động:** Người dùng có thể tự thêm/sửa/xóa phòng ban trực tiếp trên giao diện và hệ thống tự động cập nhật, không cần can thiệp vào code.

---

### SLIDE 7: PHÂN HỆ ADMIN - QUẢN LÝ HỢP ĐỒNG & BẢNG LƯƠNG
*   **Bố cục hiển thị:** Screenshot hợp đồng lao động và bảng lương tự động cuối tháng (Base salary, Allowance, Bonus, Deduction, Net).
*   **Cử chỉ:** Thực hiện cử chỉ nâng tay lên khi nói về "Lương Gross" và hạ tay xuống khi nói đến "Khấu trừ".
*   **Kịch bản thoại:**
    > *"Mỗi nhân viên sẽ gắn liền với một hợp đồng lao động để làm căn cứ tính lương cơ bản. Bảng lương hàng tháng được tính toán tự động dựa trên mức lương hợp đồng, cộng với phụ cấp và tiền thưởng, đồng thời trừ đi các khoản khấu trừ như phạt đi muộn lấy từ dữ liệu chấm công."*
*   **💡 Giải thích thuật ngữ cho Chương:**
    *   **Lương Gross:** Tổng thu nhập chưa trừ các khoản phí đóng góp.
    *   **Lương Net (Thực lĩnh):** Số tiền thực tế nhân viên được cầm về tay sau khi lấy Lương Gross trừ đi các khoản khấu trừ (phạt đi muộn, nghỉ không phép).

---

### SLIDE 8: PHÂN HỆ NHÂN VIÊN - CHẤM CÔNG VÀ XIN NGHỈ PHÉP
*   **Bố cục hiển thị:** Screenshot nút bấm Check-in/Check-out trên giao diện di động. Screenshot biểu mẫu xin nghỉ phép.
*   **Cử chỉ:** Mắt quét qua giảng viên và các bạn sinh viên để giữ sự tương tác.
*   **Kịch bản thoại:**
    > *"Giao diện di động dành cho nhân viên được tối giản hóa. Khi nhân viên nhấn Check-in/Check-out, hệ thống tự động ghi nhận thời gian thực từ máy chủ, đối chiếu với mốc 8h00 sáng để xác định trạng thái đi muộn. Nhân viên cũng có thể làm đơn xin nghỉ phép trực tuyến gửi lên HR phê duyệt."*
*   **💡 Giải thích thuật ngữ cho Chương:**
    *   **Check-in/Check-out:** Thao tác điểm danh giờ bắt đầu làm và giờ ra về của nhân viên.
    *   **Giờ thực từ máy chủ:** Thời gian lấy từ máy chủ hệ thống chạy backend chứ không lấy từ giờ của điện thoại người dùng (để tránh việc nhân viên chỉnh giờ trên điện thoại để gian lận chấm công).

---

### SLIDE 9: KIẾN TRÚC CODE & XỬ LÝ NGHIỆP VỤ NỔI BẬT
*   **Bố cục hiển thị:** Đoạn code thực tế chứa hàm chốt công tự động `finalizeAttendance`.
*   **Cử chỉ:** Chỉ vào đoạn code điều kiện kiểm tra đơn nghỉ phép trên màn hình LCD.
*   **Kịch bản thoại:**
    > *"Về mặt kỹ thuật, nhóm mình xây dựng thuật toán chốt công tự động chạy cuối ngày. Hệ thống sẽ quét danh sách nhân viên không chấm công. Nếu họ đã có đơn xin nghỉ phép được duyệt, hệ thống ghi nhận là Nghỉ phép có lương, ngược lại sẽ ghi nhận là Vắng không phép và trừ lương tự động."*
*   **💡 Giải thích thuật ngữ cho Chương:**
    *   **Hàm chốt công tự động:** Đoạn code tự động quét và cập nhật trạng thái công cho những người vắng mặt cuối ngày, giải phóng HR khỏi việc đối soát thủ công hàng ngày.

---

### SLIDE 10: BẢO MẬT THỰC TẾ & KIỂM THỬ TỰ ĐỘNG
*   **Bố cục hiển thị:** Danh sách giải pháp bảo mật và screenshot terminal chạy **47 tests passed**.
*   **Cử chỉ:** Chỉ tay vào dòng chữ kết quả kiểm thử màu xanh trên màn hình.
*   **Kịch bản thoại:**
    > *"Hệ thống được bảo mật chặt chẽ: chống xem trộm lương bằng cách truy vấn ID trực tiếp từ session máy chủ thay vì truyền tham số lên URL; chống tấn công SQL Injection và XSS. Nhóm mình cũng viết 47 kịch bản kiểm thử tự động qua PHPUnit để đảm bảo logic chạy đúng và không phát sinh lỗi."*
*   **💡 Giải thích thuật ngữ cho Chương:**
    *   **SQL Injection:** Kẻ tấn công nhập lệnh SQL phá hoại vào các ô input để hack database.
    *   **XSS:** Kẻ tấn công chèn mã JavaScript độc hại vào form nhằm ăn cắp thông tin người xem.
    *   **PHPUnit:** Công cụ giúp viết code tự động giả lập hành vi người dùng để chạy test nhanh toàn bộ hệ thống trong 2 giây.

---

### SLIDE 11: PHÂN PHỐI CÔNG VIỆC NHÓM & TỶ LỆ HOÀN THÀNH
*   **Bố cục hiển thị:** Bảng phân công nhiệm vụ của 5 thành viên (Họ tên, Vai trò chính, Module đảm nhiệm, Tỷ lệ đóng góp 100%).
*   **Cử chỉ:** Mỉm cười, chỉ tay nhẹ vào bảng phân công để thể hiện sự cảm ơn và tinh thần đồng lòng của nhóm.
*   **Kịch bản thoại:**
    > *"Để hoàn thành bài tập lớn đúng hạn, nhóm mình đã phân chia công việc rõ ràng dựa trên thế mạnh của từng thành viên. Mình phụ trách kiến trúc dữ liệu và lương hợp đồng. Bạn Nguyên lo chấm công và duyệt phép. Bạn Dũng quản lý bảo mật và auth. Bạn Long thiết kế css responsive, còn bạn Minh phát triển UI/UX và Ajax."*
*   **💡 Giải thích thuật ngữ cho Chương:**
    *   **UI/UX:** UI (User Interface) là giao diện người dùng nhìn thấy (màu sắc, nút bấm). UX (User Experience) là trải nghiệm người dùng (bấm có mượt không, thông báo có rõ ràng dễ hiểu không).

---

### SLIDE 12: TỔNG KẾT, HƯỚNG PHÁT TRIỂN & Q&A
*   **Bố cục hiển thị:** Chữ lớn: **"TRÂN TRỌNG CẢM ƠN THẦY VÀ CÁC BẠN ĐÃ LẮNG NGHE!"** và định hướng tương lai.
*   **Cử chỉ:** Đứng thẳng ở trung tâm, nói chậm lại. Sau khi kết thúc, cúi đầu nhẹ chào lịch sự và bắt đầu bước sang phần Live Demo.
*   **Kịch bản thoại:**
    > *"Tóm lại, ứng dụng HRM của nhóm mình đã vận hành ổn định các tính năng cốt lõi, giao diện responsive mượt mà và bảo mật tốt. Hướng phát triển tiếp theo là tích hợp chấm công sinh trắc học và xuất file báo cáo lương. 
    > Sau đây, mình xin phép chạy **Demo trực tiếp trang web** trên máy tính để giảng viên và các bạn có cái nhìn trực quan nhất. Nhóm mình rất mong nhận được những câu hỏi và nhận xét từ giảng viên cùng các bạn. Nhóm xin trân trọng cảm ơn!"*

---

## PHẦN 3: KỊCH BẢN LIVE DEMO CHI TIẾT (Thời gian: 3 - 4 phút)

### 1. Thiết lập kỹ thuật ban đầu
*   Mở sẵn trình duyệt Chrome chia đôi màn hình:
    *   *Bên trái (PC View):* Đăng nhập tài khoản Admin/HR (`admin@example.com` / `password`).
    *   *Bên phải (Mobile View - F12 di động):* Đăng nhập tài khoản Nhân viên (`employee@example.com` / `password`).
*   **Phân công:** Bạn Long hoặc bạn Minh ngồi máy tính click chuột theo lời thoại. Bạn Chương đứng cầm mic thuyết minh và chỉ màn hình LCD.

### 2. Luồng thao tác & Lời thuyết minh

#### Tác vụ 1: Nhân viên thao tác trên điện thoại di động (Cửa sổ di động bên phải - 1 phút)
1.  **Click chuột:** Vào phần **Chấm công** -> Nhấn nút **Check-in**. Toast thông báo xanh lá hiện lên báo thành công.
    *   *Lời thoại:* *"Đầu tiên, nhân viên đi làm và truy cập cổng chấm công trên di động. Khi nhấn Check-in, hệ thống ghi nhận thời gian thực trên server. Do bây giờ đã trễ hơn mốc quy định, hệ thống tự động ghi nhận trạng thái ngày công là đi muộn."*
2.  **Click chuột:** Nhấn nút **Check-out** -> Vào phần **Đơn xin nghỉ phép** -> Chọn nghỉ phép năm từ ngày mai, nhập lý do: `"Giải quyết công việc gia đình"` và bấm **Gửi**.
    *   *Lời thoại:* *"Cuối ngày nhân viên nhấn Check-out để tính giờ làm thực tế. Sau đó, nhân viên gửi một đơn xin nghỉ phép trực tuyến. Trạng thái đơn lúc này là Chờ duyệt (Pending)."*

#### Tác vụ 2: Quản lý/HR phê duyệt và Chốt công trên máy tính (Cửa sổ PC bên trái - 1.5 phút)
1.  **Click chuột:** Reload trang Admin bên trái -> Vào danh sách đơn chờ duyệt -> Nhấn **Duyệt**. SweetAlert hiện lên xác nhận -> Bấm đồng ý.
    *   *Lời thoại:* *"Bây giờ ở giao diện máy tính của HR, hệ thống tự động cập nhật số đếm đơn phép chờ duyệt. HR kiểm tra đơn xin nghỉ vừa rồi và nhấn Duyệt. Hệ thống sẽ hiển thị một hộp thoại xác nhận chuyên nghiệp trước khi chính thức phê duyệt đơn."*
2.  **Click chuột:** Vào mục **Chốt công** -> Nhấn nút **Chốt công hôm nay**.
    *   *Lời thoại:* *"Cuối ngày, Admin nhấn Chốt công. Thuật toán hệ thống tự động quét dữ liệu: nhân viên vắng mặt nhưng có đơn phép đã duyệt sẽ được chuyển trạng thái thành Nghỉ phép có lương, thay vì bị tính vắng không phép."*

#### Tác vụ 3: Admin tính lương & Nhân viên tra cứu (PC & Mobile - 1 phút)
1.  **Click chuột:** Vào mục **Bảng lương** trên PC -> Chọn nhân viên -> Bấm **Lưu bảng lương** -> Thay đổi trạng thái bảng lương từ `Draft` (Nháp) sang `Paid` (Đã thanh toán).
    *   *Lời thoại:* *"Admin truy cập phân hệ lương để tạo bảng lương tháng hiện tại cho nhân viên. Lương Net thực nhận được tính toán tự động sau khi đã khấu trừ tiền đi muộn lấy từ dữ liệu chấm công. Sau khi kiểm tra, Admin chuyển trạng thái bảng lương sang Đã thanh toán."*
2.  **Click chuột:** Quay lại trình duyệt di động bên phải, reload trang -> Vào mục **Lịch sử phép** chỉ ra trạng thái đã là `Approved`. Vào mục **Bảng lương** cá nhân xem chi tiết phiếu lương.
    *   *Lời thoại:* *"Quay lại màn hình di động của nhân viên, khi tải lại trang, đơn nghỉ phép đã chuyển sang trạng thái Đã duyệt và phiếu lương tháng này đã hiển thị chi tiết, hoàn toàn bảo mật. Phần demo của nhóm 14 xin được kết thúc tại đây."*

---

## PHẦN 4: BỘ CÂU HỎI VẤN ĐÁP THÔNG THƯỜNG & AN TOÀN (QA CHEAT SHEET)

*   **Câu 1: Tại sao trong CSDL có cả bảng `leaves` và bảng `leave_requests` nhưng code chỉ dùng bảng `leaves`?**
    *   *Trả lời:* *"Thưa thầy/cô, đây là tàn dư trong thiết kế ban đầu của nhóm mình. Ban đầu, nhóm định làm tính năng duyệt phép đa cấp qua bảng trung gian `leave_requests`. Tuy nhiên, để ưu tiên hoàn thành luồng nghiệp vụ cốt lõi của bài tập lớn đúng tiến độ, nhóm đã đơn giản hóa quy trình và lưu thẳng đơn vào bảng `leaves`. Nhóm giữ lại bảng kia làm định hướng nâng cấp sau này."*
*   **Câu 2: Tại sao trường `emp_id` trong bảng `leaves` lại lưu `user_id` của bảng `users` chứ không phải `id` của bảng `employees`?**
    *   *Trả lời:* *"Thưa thầy/cô, đây quả thực là một lỗi thiếu nhất quán trong cách đặt tên trường của nhóm mình. Đúng ra trường này phải đặt tên là `user_id` để tránh gây nhầm lẫn với bảng `employees`. Nhóm mình xin tiếp thu và sẽ tiến hành refactor lại tên trường này trong migrations."*
*   **Câu 3: Làm thế nào ngăn chặn nhân viên sửa ID trên URL để xem trộm lương của người khác?**
    *   *Trả lời:* *"Hệ thống không truyền ID nhân viên lên URL. Khi xem lương, Controller sẽ tự động lấy ID tài khoản trực tiếp từ Session được lưu trữ an toàn trên Server (`session('user_id')`). Do đó người dùng không thể sửa đổi tham số để xem trộm lương người khác."*
*   **Câu 4: Em viết PHPUnit test như thế nào? Có chạy thực tế không?**
    *   *Trả lời:* *"Nhóm viết các Feature Test để giả lập hành vi người dùng. Ví dụ: giả lập một nhân viên đăng nhập thành công và gửi yêu cầu xem lương xem có trả về trạng thái 200 (thành công) hay không, hoặc giả lập nhân viên cố truy cập trang Admin xem có bị trả về lỗi 403 (chặn truy cập) hay không. Nhóm chạy các test này bằng lệnh `php artisan test` trước khi cập nhật code."*
*   **Câu 5: Nếu database có hàng triệu bản ghi chấm công, hệ thống của em sẽ bị chậm. Em giải quyết thế nào?**
    *   *Trả lời:* *"Khi dữ liệu lớn, nhóm mình đề xuất 2 giải pháp: 1. Thiết lập **Index** cho tổ hợp khóa ngoại và ngày tháng (`employee_id`, `work_date`) vì đây là các trường lọc nhiều nhất trong mệnh đề `WHERE`. 2. Áp dụng kỹ thuật **Database Partitioning** để phân vùng bảng chấm công theo năm hoặc tháng để hệ thống chỉ quét dữ liệu trong tháng hiện tại thay vì quét hàng triệu dòng."*
