# SỔ TAY GIẢI THÍCH THUẬT NGỮ KỸ THUẬT
*Tài liệu học nhanh dành riêng cho bạn Chương để tự tin làm chủ kiến thức và trả lời câu hỏi của Giảng viên & các bạn sinh viên khi báo cáo bài tập lớn.*

---

## MỤC 1: KIẾN TRÚC & KHUNG PHÁT TRIỂN (FRAMEWORK)

### 1. Framework & Laravel 11 là gì?
*   **Cách hiểu đơn giản:** Giống như **khung nhà lắp ghép** đã xây sẵn móng, cột nhà, đường điện và ống nước cơ bản. Nhóm mình không cần tự đi đúc từng viên gạch (tự viết code xử lý socket, kết nối DB từ số 0), mà chỉ việc thiết kế tường, lắp cửa và sơn màu (code nghiệp vụ HRM).
*   **Khi thuyết trình nói thế nào:** 
    > *"Laravel 11 là một PHP Framework mã nguồn mở theo mô hình MVC, cung cấp sẵn các thư viện chuẩn hóa về bảo mật, kết nối DB và định tuyến, giúp nhóm mình đẩy nhanh tiến độ phát triển dự án."*
*   **Câu hỏi có thể gặp:** *"Tại sao không tự viết PHP thuần mà phải dùng Laravel?"*
    *   *Cách trả lời:* *"Dạ, dùng Laravel giúp mã nguồn được tổ chức chuẩn hóa theo chuẩn quốc tế, bảo mật cao hơn chống SQL Injection/XSS tự động và giúp các thành viên trong nhóm dễ dàng làm việc chung trên một cấu trúc code đồng nhất."*

### 2. Mô hình MVC (Model - View - Controller)
*   **Cách hiểu đơn giản (Ví dụ Nhà hàng):**
    *   **View (Giao diện):** Là không gian bàn ăn và thực đơn (nơi người dùng nhìn thấy, điền thông tin và bấm nút).
    *   **Controller (Phục vụ bàn):** Khi khách gọi món, phục vụ ghi nhận, chạy vào bếp yêu cầu làm, rồi bê món ăn ra cho khách (điều hướng request từ Client, gọi Model xử lý rồi trả kết quả về View).
    *   **Model (Nhà bếp/Kho nguyên liệu):** Đầu bếp lấy thực phẩm trong kho để chế biến (truy xuất, xử lý dữ liệu dưới MySQL).
*   **Khi thuyết trình nói thế nào:**
    > *"Hệ thống HRM của nhóm mình tổ chức theo mô hình MVC để phân tách rõ ràng giữa giao diện hiển thị (View), logic điều hướng (Controller) và nghiệp vụ xử lý dữ liệu (Model), giúp code dễ bảo trì và nâng cấp."*

### 3. Eloquent ORM là gì?
*   **Cách hiểu đơn giản:** Cơ sở dữ liệu MySQL chỉ hiểu câu lệnh SQL (ví dụ: `SELECT * FROM employees`). Nhưng lập trình viên lại viết code PHP. **Eloquent ORM đóng vai trò là người phiên dịch**. Nó dịch các câu lệnh PHP dạng đối tượng (ví dụ: `Employee::find($id)`) thành câu lệnh SQL tương ứng để chạy dưới database.
*   **Khi thuyết trình nói thế nào:**
    > *"Eloquent ORM là công cụ ánh xạ cơ sở dữ liệu dạng quan hệ sang hướng đối tượng của Laravel. Giúp nhóm mình thao tác với dữ liệu MySQL thông qua cú pháp PHP ngắn gọn, an toàn và dễ đọc hơn."*

---

## MỤC 2: CƠ SỞ DỮ LIỆU (DATABASE)

### 1. Chuẩn hóa CSDL 3NF là gì?
*   **Cách hiểu đơn giản:** Là cách thiết kế các bảng dữ liệu sao cho **không có thông tin nào bị trùng lặp thừa thãi** và dữ liệu phụ thuộc logic vào khóa chính. Ví dụ: Không lưu trực tiếp tên phòng ban vào bảng nhân viên, mà tạo bảng `departments` riêng và dùng `department_id` để liên kết.
*   **Khi thuyết trình nói thế nào:**
    > *"CSDL của hệ thống được chuẩn hóa để đảm bảo toàn vẹn dữ liệu, tránh hiện tượng dư thừa hoặc dị thường khi thêm, sửa, xóa bản ghi."*

### 2. Khóa ngoại đệ quy `manager_id` (Tự liên kết)
*   **Cách hiểu đơn giản:** Thông thường khóa ngoại của bảng này trỏ sang khóa chính bảng kia. Nhưng trường `manager_id` trong bảng `employees` lại **trỏ ngược lại trường `id` của chính bảng `employees`**. 
    *   *Vì sao?* Vì người quản lý (Manager) bản chất cũng là một nhân viên (Employee). Thiết kế này giúp quản lý cây sơ đồ tổ chức công ty.
*   **Khi thuyết trình nói thế nào:**
    > *"Để quản lý cơ cấu báo cáo công việc, nhóm mình thiết kế khóa ngoại đệ quy `manager_id` tự liên kết lại chính bảng nhân viên. Giúp hệ thống xác định được cấp trên trực tiếp của mỗi nhân sự mà không cần tạo bảng trung gian."*

### 3. Khóa phức hợp (Composite Key) & Ràng buộc Unique
*   **Cách hiểu đơn giản:** Thông thường mỗi bảng chỉ có 1 trường làm khóa chính (như `id`). Khóa phức hợp là **kết hợp từ 2 trường trở lên để tạo thành một giá trị duy nhất không được trùng**.
    *   *Ví dụ:* Kết hợp `employee_id` + `salary_month` làm khóa duy nhất cho bảng lương. Hệ thống sẽ chặn ngay nếu bạn tạo trùng 2 phiếu lương cho cùng 1 người trong 1 tháng.
*   **Khi thuyết trình nói thế nào:**
    > *"Nhóm mình sử dụng ràng buộc duy nhất trên tổ hợp khóa phức hợp gồm mã nhân viên và tháng lương ở tầng cơ sở dữ liệu để ngăn chặn hoàn toàn lỗi nghiệp vụ tạo trùng lặp bảng lương."*

---

## MỤC 3: PHÂN QUYỀN & BẢO MẬT (SECURITY)

### 1. Middleware là gì? (QUAN TRỌNG NHẤT)
*   **Cách hiểu đơn giản:** Hãy tưởng tượng **Middleware giống như anh bảo vệ đứng ở cửa quán Bar**. 
    *   Khi có khách muốn đi vào (người dùng gửi request truy cập URL), anh bảo vệ sẽ chặn lại kiểm tra chứng minh nhân dân (kiểm tra vai trò Role trong Session của máy chủ).
    *   Nếu đủ tuổi/hợp lệ (là Admin/HR), anh bảo vệ mở cửa cho vào (cho tiếp tục thực thi Controller).
    *   Nếu không đúng quyền (là Nhân viên thông thường cố vào trang duyệt lương), anh bảo vệ chặn đứng lại và đuổi đi (trả về lỗi `403 Forbidden`).
*   **Khi thuyết trình nói thế nào:**
    > *"Middleware trong hệ thống hoạt động như một bộ lọc trung gian, đứng trước các request để kiểm tra quyền truy cập của người dùng dựa trên Session trước khi cho phép đi vào Controller xử lý."*

### 2. Role-based Access Control (RBAC) là gì?
*   **Cách hiểu đơn giản:** Là cách **phân quyền dựa trên chức vụ/vai trò** thay vì phân quyền cho từng cá nhân. Ví dụ: Cứ có vai trò là "HR" thì tự động được duyệt phép, có vai trò là "Admin" thì được quản lý lương.
*   **Khi thuyết trình nói thế nào:**
    > *"Hệ thống áp dụng cơ chế RBAC để quản lý quyền hạn của người dùng một cách khoa học theo các vai trò xác định: Admin, HR và Employee."*

### 3. SQL Injection & XSS (Mã độc) là gì?
*   **SQL Injection:** Kẻ tấn công nhập các đoạn mã SQL phá hoại vào ô tìm kiếm hoặc đăng nhập (ví dụ: `' OR 1=1 --`) để ép máy chủ chạy lệnh SQL ngoài ý muốn nhằm đánh cắp dữ liệu.
    *   *Laravel chống thế nào:* Eloquent ORM tự động sử dụng cơ chế PDO binding, biến toàn bộ dữ liệu nhập vào thành dạng chuỗi thuần túy (string) chứ không thực thi như lệnh SQL.
*   **XSS (Cross-Site Scripting):** Kẻ tấn công nhập các đoạn mã JavaScript độc hại vào form. Khi người dùng khác mở trang lên xem, trình duyệt tự chạy đoạn mã này để ăn cắp Session Cookie.
    *   *Laravel chống thế nào:* Cú pháp Blade `{{ $variable }}` của Laravel tự động lọc và chuyển đổi các ký tự đặc biệt (như `<` thành `&lt;`) khiến mã độc chỉ hiển thị thành văn bản thường chứ không chạy được trên trình duyệt.

---

## MỤC 4: GIAO DIỆN & TRẢI NGHIỆM NGƯỜI DÙNG (FRONTEND)

### 1. AJAX là gì?
*   **Cách hiểu đơn giản:** Bình thường khi bạn bấm nút gửi form, trang web sẽ bị trắng màn hình một lát để load lại toàn bộ trang từ đầu. **AJAX giúp tải dữ liệu ngầm bên dưới**. Chỉ có khu vực cần hiển thị kết quả được cập nhật dữ liệu mới mà toàn bộ trang web không bị load lại.
*   **Khi thuyết trình nói thế nào:**
    > *"Nhóm mình ứng dụng AJAX để gửi các yêu cầu bất đồng bộ lên máy chủ, giúp giao diện cập nhật trạng thái chấm công và thông báo lỗi tức thời mà không cần tải lại toàn bộ trang web, nâng cao trải nghiệm người dùng."*

### 2. Toast Notification & SweetAlert là gì?
*   **Toast:** Là những **khung thông báo nhỏ tự động trượt ra ở góc màn hình** (màu xanh khi thành công, đỏ khi lỗi) và tự biến mất sau vài giây để không làm gián đoạn trải nghiệm người dùng.
*   **SweetAlert:** Là các **hộp thoại pop-up cảnh báo đẹp mắt** hiện ra ở giữa màn hình yêu cầu xác nhận trước khi làm tác vụ nguy hiểm (như Duyệt phép hoặc Xóa).

---

## PHỤ LỤC: MẸO GHI NHỚ CHO BẠN CHƯƠNG KHI BỊ CHẤT VẤN BẤT CHỢT

| Thuật ngữ | Liên tưởng nhanh trong đầu | Từ khóa cần trả lời |
| :--- | :--- | :--- |
| **Laravel** | Khung nhà lắp ghép | PHP Framework, bảo mật, chuẩn hóa code |
| **MVC** | Quy trình nhà hàng (View-Phục vụ-Bếp) | Phân tách giao diện và logic |
| **Middleware** | Bảo vệ quán Bar | Bộ lọc request, phân quyền, chặn truy cập |
| **ORM** | Người phiên dịch PHP sang SQL | Ánh xạ cơ sở dữ liệu sang hướng đối tượng |
| **Composite Key** | Khóa đôi (Mã NV + Tháng) | Chống tạo trùng lặp bảng lương |
| **AJAX** | Bình luận Facebook không load lại trang | Truy xuất bất đồng bộ, không tải lại trang |
| **SQL Injection** | Tiêm mã độc vào ô nhập liệu | Chống tự động bằng PDO Parameter Binding |
| **XSS** | Chèn mã JS vào giao diện | Mã hóa ký tự đầu ra bằng công cụ Blade |
