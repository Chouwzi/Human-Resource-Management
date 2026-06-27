<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HRM - Admin Duyệt Nghỉ Phép</title>
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
                        <i class="fa-solid fa-chart-pie text-lg"></i> Overview
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 bg-teal-50 text-teal-600 rounded-xl transition font-semibold">
                        <i class="fa-solid fa-calendar-check text-lg"></i> Duyệt nghỉ phép
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-50 rounded-xl transition font-medium">
                        <i class="fa-solid fa-users text-lg"></i> Quản lý Nhân sự
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
                <h1 class="text-xl font-bold text-slate-800">Dashboard Quản Lý (Admin/HR)</h1>
                <div class="flex items-center gap-3">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-slate-700">{{ $user->name ?? $user->email ?? 'Chưa đăng nhập' }}</p>
                        <p class="text-xs text-teal-600 font-semibold uppercase">{{ $user->role->description ?? 'QUẢN LÝ' }}</p>
                    </div>
                    <img src="https://i.pravatar.cc/100?img={{ $user->id ?? 33 }}" class="w-10 h-10 rounded-full border-2 border-teal-100" alt="Avatar">
                </div>
            </header>

            <main class="p-8 max-w-7xl w-full mx-auto">
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-bold text-slate-800"><i class="fa-solid fa-clipboard-list text-teal-600 mr-2"></i>Danh Sách Đơn Cần Phê Duyệt</h3>
                        <span id="new-request-badge" class="bg-teal-50 text-teal-600 text-xs font-bold px-3 py-1 rounded-full">0 Đơn mới nhận</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 text-slate-400 text-xs font-bold uppercase">
                                    <th class="pb-3 min-w-[200px]">Nhân viên</th>
                                    <th class="pb-3">Loại phép</th>
                                    <th class="pb-3">Thời gian</th>
                                    <th class="pb-3">Lý do</th>
                                    <th class="pb-3 text-center">Trạng thái</th>
                                    <th class="pb-3 text-center min-w-[180px]">Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="admin-table-body" class="text-sm text-slate-600 divide-y divide-slate-50">
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        const defaultRequests = [
            { id: 1, empName: "Nguyễn Văn A", department: "Phòng Công nghệ", avatar: "https://i.pravatar.cc/80?img=12", type: "Nghỉ phép năm", duration: "26/06/2026 - 28/06/2026", reason: "Giải quyết công việc gia đình ở quê.", status: "pending" },
            { id: 2, empName: "Phạm Minh Dập", department: "Phòng Kế toán", avatar: "https://i.pravatar.cc/80?img=59", type: "Việc riêng cá nhân", duration: "29/06/2026 (1 ngày)", reason: "Gia đình có giỗ lớn.", status: "pending" },
            { id: 3, empName: "Trần Thị Bích", department: "Phòng Nhân sự", avatar: "https://i.pravatar.cc/80?img=47", type: "Nghỉ bệnh", duration: "24/06/2026 (1 ngày)", reason: "Đi khám sức khỏe định kỳ.", status: "approved", adminNote: "Đã duyệt bởi HR" }
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

        function renderAdminTable() {
            const requests = getRequests();
            const tbody = document.getElementById('admin-table-body');
            tbody.innerHTML = '';
            let pendingCount = 0;

            const sortedRequests = [...requests].reverse();

            sortedRequests.forEach(req => {
                if (req.status === 'pending') pendingCount++;

                let statusBadge = '';
                let actionContent = '';

                if (req.status === 'pending') {
                    statusBadge = `<span class="px-2.5 py-1 text-xs font-semibold bg-amber-50 text-amber-600 rounded-full border border-amber-100">pending</span>`;
                    actionContent = `
                        <div class="flex justify-center gap-2">
                            <button type="button" onclick="handleApprove(${req.id}, '${req.empName}')" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition shadow-sm cursor-pointer">
                                <i class="fa-solid fa-check mr-1"></i> Duyệt
                            </button>
                            <button type="button" onclick="handleReject(${req.id}, '${req.empName}')" class="px-3 py-1.5 bg-rose-500 hover:bg-rose-600 text-white text-xs font-semibold rounded-lg transition shadow-sm cursor-pointer">
                                <i class="fa-solid fa-xmark mr-1"></i> Từ chối
                            </button>
                        </div>
                    `;
                } else if (req.status === 'approved') {
                    statusBadge = `<span class="px-2.5 py-1 text-xs font-semibold bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100">approved</span>`;
                    actionContent = `<span class="text-slate-400 text-xs font-medium italic">${req.adminNote || 'Đã duyệt bởi HR'}</span>`;
                } else if (req.status === 'rejected') {
                    statusBadge = `<span class="px-2.5 py-1 text-xs font-semibold bg-rose-50 text-rose-600 rounded-full border border-rose-100">rejected</span>`;
                    actionContent = `<span class="text-rose-500 text-xs font-medium italic">${req.adminNote || 'Đã từ chối'}</span>`;
                } else if (req.status === 'cancelled') {
                    statusBadge = `<span class="px-2.5 py-1 text-xs font-semibold bg-slate-100 text-slate-600 rounded-full border border-slate-200">cancelled</span>`;
                    actionContent = `<span class="text-slate-400 text-xs font-medium italic">Nhân viên tự hủy đơn</span>`;
                }

                const tr = document.createElement('tr');
                tr.className = "hover:bg-slate-50/50 transition";
                tr.innerHTML = `
                    <td class="py-4 flex items-center gap-3">
                        <img src="${req.avatar}" class="w-8 h-8 rounded-full" alt="Avatar">
                        <div>
                            <p class="font-semibold text-slate-800">${req.empName}</p>
                            <p class="text-xs text-slate-400">${req.department}</p>
                        </div>
                    </td>
                    <td class="py-4 font-medium">${req.type}</td>
                    <td class="py-4 text-slate-500">${req.duration}</td>
                    <td class="py-4 text-slate-500 max-w-xs truncate" title="${req.reason}">${req.reason}</td>
                    <td class="py-4 text-center">${statusBadge}</td>
                    <td class="py-4 text-center">${actionContent}</td>
                `;
                tbody.appendChild(tr);
            });

            const badge = document.getElementById('new-request-badge');
            if (pendingCount > 0) {
                badge.className = "bg-teal-50 text-teal-600 text-xs font-bold px-3 py-1 rounded-full";
                badge.innerText = `${pendingCount} Đơn chờ duyệt`;
            } else {
                badge.className = "bg-slate-100 text-slate-500 text-xs font-bold px-3 py-1 rounded-full";
                badge.innerText = "Đã xử lý hết đơn";
            }
        }

        function handleApprove(id, empName) {
            if (confirm(`Bạn có chắc chắn muốn PHÊ DUYỆT đơn nghỉ phép của nhân viên [ ${empName} ] không?`)) {
                let requests = getRequests();
                const index = requests.findIndex(r => r.id === id);
                if (index !== -1) {
                    requests[index].status = 'approved';
                    requests[index].adminNote = 'Đã duyệt';
                    saveRequests(requests);
                    renderAdminTable();
                }
            }
        }

        function handleReject(id, empName) {
            let reason = prompt(`Bạn có chắc muốn TỪ CHỐI đơn của [ ${empName} ]?\nNhập lý do từ chối:`, "Trùng lịch dự án");
            if (reason !== null) {
                let requests = getRequests();
                const index = requests.findIndex(r => r.id === id);
                if (index !== -1) {
                    requests[index].status = 'rejected';
                    requests[index].adminNote = `Từ chối (${reason.trim() || 'Không có lý do'})`;
                    saveRequests(requests);
                    renderAdminTable();
                }
            }
        }

        window.addEventListener('storage', (e) => {
            if (e.key === 'leave_requests') {
                renderAdminTable();
            }
        });

        document.addEventListener('DOMContentLoaded', renderAdminTable);
    </script>
</body>
</html>