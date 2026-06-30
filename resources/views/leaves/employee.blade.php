<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRM - Nghỉ Phép Của Tôi</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-[#f8fafc] font-sans antialiased">

    <div class="flex h-screen overflow-hidden">
        <div class="w-64 bg-white border-r border-slate-100 flex flex-col justify-between">
            <div>
                <div class="p-6 flex items-center gap-3">
                    <div class="w-9 h-9 bg-teal-600 rounded-xl flex items-center justify-center text-white font-bold text-lg">
                        <i class="fa-solid fa-layer-group"></i>
                    </div>
                    <span class="font-bold text-xl text-slate-800 tracking-tight">HRM Group</span>
                </div>
                <nav class="px-4 space-y-1">
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-50 rounded-xl transition font-medium">
                        <i class="fa-solid fa-house text-lg"></i> Trang chủ
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 bg-teal-50 text-teal-600 rounded-xl transition font-semibold">
                        <i class="fa-solid fa-calendar-minus text-lg"></i> Nghỉ phép của tôi
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-50 rounded-xl transition font-medium">
                        <i class="fa-solid fa-user text-lg"></i> Hồ sơ cá nhân
                    </a>
                </nav>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="p-4 border-t border-slate-50">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl transition font-medium cursor-pointer">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Đăng xuất
                </button>
            </form>
        </div>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white border-b border-slate-100 h-16 flex items-center justify-between px-8 sticky top-0 z-10">
                <h1 class="text-xl font-bold text-slate-800">Quản Lý Nghỉ Phép</h1>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-slate-700">{{ $user->name ?? $user->email ?? 'Nhân viên' }}</p>
                        <p class="text-xs text-slate-400 font-medium">Mã NV: #NV{{ sprintf('%02d', $user->id ?? 1) }}</p>
                    </div>
                    <img src="https://i.pravatar.cc/100?img={{ $user->id ?? 3 }}" class="w-10 h-10 rounded-full border-2 border-teal-100" alt="Avatar">
                </div>
            </header>

            <main class="p-8 max-w-7xl w-full mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                        <h3 class="text-lg font-bold text-slate-800 mb-4"><i class="fa-solid fa-pen-to-square text-teal-600 mr-2"></i>Tạo Đơn Mới</h3>
                        
                        <form id="leave-form" class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Loại nghỉ phép</label>
                                <select id="leave-type" class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition">
                                    <option value="Nghỉ phép năm">Nghỉ phép năm (Có lương)</option>
                                    <option value="Nghỉ bệnh">Nghỉ bệnh (Có BHXH)</option>
                                    <option value="Việc riêng cá nhân">Việc riêng (Không lương)</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Thời gian nghỉ (Chi tiết)</label>
                                <input type="text" id="leave-duration" placeholder="VD: 25/06 - 27/06 (3 ngày)" class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-1">Lý do chi tiết</label>
                                <textarea id="leave-reason" rows="3" placeholder="Nhập lý do nghỉ phép..." class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition resize-none" required></textarea>
                            </div>

                            <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-semibold py-2.5 rounded-lg transition shadow-sm cursor-pointer">
                                Gửi Đơn Nghỉ Phép
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm h-full">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-slate-800"><i class="fa-solid fa-clock-rotate-left text-teal-600 mr-2"></i>Lịch Sử Đơn Của Tôi</h3>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-slate-100 text-slate-400 text-xs font-bold uppercase">
                                        <th class="pb-3">Loại phép</th>
                                        <th class="pb-3">Thời gian</th>
                                        <th class="pb-3">Lý do</th>
                                        <th class="pb-3 text-center">Trạng thái</th>
                                        <th class="pb-3 text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody id="employee-table-body" class="text-sm text-slate-600 divide-y divide-slate-50">
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script>
        // Lấy thông tin user hiện tại từ Laravel truyền sang
        const currentUserName = "{{ $user->name ?? $user->email ?? 'Nhân viên' }}";
        const currentUserAvatar = "https://i.pravatar.cc/80?img={{ $user->id ?? 3 }}";
        const currentUserId = {{ $user->id ?? 0 }};
        
        // Data mẫu (chỉ dùng nếu localStorage trống)
        const defaultRequests = [
            { id: 1, empId: 101, empName: "Nguyễn Văn A", department: "Phòng Công nghệ", avatar: "https://i.pravatar.cc/80?img=12", type: "Nghỉ phép năm", duration: "26/06/2026 - 28/06/2026", reason: "Giải quyết công việc gia đình ở quê.", status: "pending" },
        ];

        function getRequests() {
            if (!localStorage.getItem('leave_requests')) {
                localStorage.setItem('leave_requests', JSON.stringify(defaultRequests));
            }
            return JSON.parse(localStorage.getItem('leave_requests'));
        }

        function saveRequests(requests) {
            localStorage.setItem('leave_requests', JSON.stringify(requests));
        }

        function renderEmployeeTable() {
            const allRequests = getRequests();
            const tbody = document.getElementById('employee-table-body');
            tbody.innerHTML = '';

            // Chỉ lọc những đơn của người đang đăng nhập (dựa vào Tên hoặc ID)
            const myRequests = allRequests.filter(req => req.empName === currentUserName || req.empId === currentUserId).reverse();

            if (myRequests.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="py-8 text-center text-slate-400 italic">Bạn chưa tạo đơn nghỉ phép nào.</td></tr>`;
                return;
            }

            myRequests.forEach(req => {
                let statusBadge = '';
                let actionContent = '';

                if (req.status === 'pending') {
                    statusBadge = `<span class="px-2.5 py-1 text-xs font-semibold bg-amber-50 text-amber-600 rounded-full border border-amber-100">Chờ duyệt</span>`;
                    actionContent = `
                        <button onclick="cancelRequest(${req.id})" class="text-xs text-rose-500 hover:bg-rose-50 px-2 py-1 rounded transition font-medium cursor-pointer">
                            Hủy đơn
                        </button>`;
                } else if (req.status === 'approved') {
                    statusBadge = `<span class="px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100">Đã duyệt</span>`;
                    actionContent = `<span class="text-slate-400 text-xs italic">-</span>`;
                } else if (req.status === 'rejected') {
                    statusBadge = `<span class="px-2.5 py-1 text-xs font-semibold bg-rose-50 text-rose-600 rounded-full border border-rose-100">Từ chối</span>`;
                    actionContent = `<span class="text-slate-400 text-xs italic">-</span>`;
                } else if (req.status === 'cancelled') {
                    statusBadge = `<span class="px-2.5 py-1 text-xs font-semibold bg-slate-100 text-slate-600 rounded-full border border-slate-200">Đã hủy</span>`;
                    actionContent = `<span class="text-slate-400 text-xs italic">-</span>`;
                }

                const tr = document.createElement('tr');
                tr.className = "hover:bg-slate-50/50 transition";
                tr.innerHTML = `
                    <td class="py-4 font-medium text-slate-700">${req.type}</td>
                    <td class="py-4 text-slate-500">${req.duration}</td>
                    <td class="py-4 text-slate-500 max-w-[200px] truncate" title="${req.reason}">${req.reason}</td>
                    <td class="py-4 text-center">${statusBadge}</td>
                    <td class="py-4 text-center">${actionContent}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Xử lý Gửi form tạo đơn mới
        document.getElementById('leave-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const type = document.getElementById('leave-type').value;
            const duration = document.getElementById('leave-duration').value;
            const reason = document.getElementById('leave-reason').value;
            
            const requests = getRequests();
            const newRequest = {
                id: Date.now(), // Tạo ID ngẫu nhiên bằng thời gian
                empId: currentUserId,
                empName: currentUserName,
                department: "Nhân sự / Kỹ thuật", // Có thể thay bằng biến nếu có
                avatar: currentUserAvatar,
                type: type,
                duration: duration,
                reason: reason,
                status: 'pending'
            };
            
            requests.push(newRequest);
            saveRequests(requests);
            
            // Reset form và render lại bảng
            this.reset();
            renderEmployeeTable();
            alert('Gửi đơn nghỉ phép thành công! Vui lòng chờ phê duyệt.');
        });

        // Xử lý Hủy đơn
        window.cancelRequest = function(id) {
            if(confirm("Bạn có chắc chắn muốn hủy đơn nghỉ phép này không?")) {
                let requests = getRequests();
                const index = requests.findIndex(r => r.id === id);
                if(index !== -1) {
                    requests[index].status = 'cancelled';
                    saveRequests(requests);
                    renderEmployeeTable();
                }
            }
        };

        // Lắng nghe sự thay đổi từ LocalStorage (VD: khi Admin duyệt đơn ở tab khác)
        window.addEventListener('storage', (e) => {
            if (e.key === 'leave_requests') {
                renderEmployeeTable();
            }
        });

        // Chạy hàm hiển thị dữ liệu khi tải trang
        document.addEventListener('DOMContentLoaded', renderEmployeeTable);
    </script>
</body>
</html>