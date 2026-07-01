<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Chức vụ</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased min-h-screen flex flex-col md:flex-row">

    <aside class="w-full md:w-64 bg-slate-900 text-white flex flex-col shrink-0 shadow-xl">
        <div class="p-5 flex items-center justify-between border-b border-slate-800">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-indigo-600 rounded-lg"><i class="fa-solid fa-sitemap text-xl"></i></div>
                <span class="font-bold text-lg tracking-wide">HR Manager</span>
            </div>
            <button id="mobile-menu-btn" class="md:hidden text-gray-400 hover:text-white"><i class="fa-solid fa-bars text-xl"></i></button>
        </div>
        <nav id="sidebar-menu" class="hidden md:flex flex-col p-4 space-y-2 flex-1">
            <a href="{{ route('departments.index') }}" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg font-medium text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-building w-5 text-center"></i><span>Quản lý Phòng ban</span>
            </a>
            <a href="{{ route('positions.index') }}" class="w-full flex items-center space-x-3 px-4 py-3 rounded-lg font-medium transition bg-indigo-600 text-white">
                <i class="fa-solid fa-briefcase w-5 text-center"></i><span>Quản lý Chức vụ</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-4 md:p-8 overflow-x-hidden">
        <header class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-6 mb-6 border-b border-gray-200 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 md:text-3xl">Quản lý Chức vụ</h1>
                <p class="text-sm text-gray-500 mt-1">Quản lý danh sách chức danh và gán trực thuộc phòng ban tương ứng.</p>
            </div>
            <div>
                <button onclick="openAddModal()" class="w-full sm:w-auto inline-flex items-center justify-center space-x-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-sm transition cursor-pointer">
                    <i class="fa-solid fa-plus text-sm"></i><span>Thêm Chức vụ</span>
                </button>
            </div>
        </header>

        <div class="bg-white rounded-xl shadow-xs border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[600px]">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                            <th class="px-6 py-4">Mã chức vụ</th>
                            <th class="px-6 py-4">Tên chức vụ</th>
                            <th class="px-6 py-4">Thuộc phòng ban</th>
                            <th class="px-6 py-4">Trạng thái</th>
                            <th class="px-6 py-4 text-right">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm text-gray-700">
                        @forelse($positions as $p)
                            <tr class="hover:bg-gray-50/70 transition">
                                <td class="px-6 py-4 font-mono font-medium text-indigo-600">{{ $p->code }}</td>
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $p->name }}</td>
                                <td class="px-6 py-4 text-gray-500 flex items-center space-x-2">
                                    <i class="fa-solid fa-building text-gray-400 text-xs"></i>
                                    <span>{{ $p->department->name ?? 'Không xác định' }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $p->status === 'Hoạt động' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button onclick="openEditModal({{ json_encode($p) }})" class="text-slate-600 hover:text-indigo-600 p-1.5 hover:bg-gray-100 rounded transition cursor-pointer"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button onclick="triggerDelete({{ $p->id }})" class="text-slate-600 hover:text-rose-600 p-1.5 hover:bg-gray-100 rounded transition cursor-pointer"><i class="fa-solid fa-trash-can"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-400">Không có dữ liệu chức vụ nào.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <div id="toast-container" class="fixed top-5 right-5 z-50 flex flex-col space-y-3">
        @if(session('success'))
            <div class="toast-item flex items-center space-x-3 px-4 py-3 rounded-xl shadow-lg text-sm font-medium text-white bg-emerald-600 transition-all duration-300">
                <i class="fa-solid fa-circle-check"></i><span>{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="toast-item flex items-center space-x-3 px-4 py-3 rounded-xl shadow-lg text-sm font-medium text-white bg-rose-600 transition-all duration-300">
                <i class="fa-solid fa-circle-xmark"></i><span>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <div id="crud-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 z-40 hidden">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                <h3 id="modal-title" class="text-lg font-semibold text-gray-900">Thêm chức vụ</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
            <form id="modal-form" method="POST" class="p-6 space-y-4">
                @csrf
                <input type="hidden" id="method-field" name="_method" value="POST">
                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2 tracking-wide">Mã định danh <span class="text-red-500">*</span></label>
                    <input type="text" id="form-code" name="code" required class="w-full px-3.5 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2 tracking-wide">Tên chức vụ <span class="text-red-500">*</span></label>
                    <input type="text" id="form-name" name="name" required class="w-full px-3.5 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2 tracking-wide">Thuộc phòng ban <span class="text-red-500">*</span></label>
                    <select id="form-dept-select" name="department_id" required class="w-full px-3.5 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm bg-white">
                        <option value="" disabled selected>-- Chọn phòng ban --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-2 tracking-wide">Trạng thái</label>
                    <select id="form-status" name="status" class="w-full px-3.5 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm bg-white">
                        <option value="Hoạt động">Hoạt động</option>
                        <option value="Tạm ngưng">Tạm ngưng</option>
                    </select>
                </div>
                <div class="pt-4 flex items-center justify-end space-x-3 border-t border-gray-100">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50">Hủy</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium shadow-xs">Lưu dữ liệu</button>
                </div>
            </form>
        </div>
    </div>

    <div id="confirm-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 z-40 hidden">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-sm overflow-hidden p-6 text-center">
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4 text-xl"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Xác nhận xóa bỏ?</h3>
            <p class="text-sm text-gray-500 mb-6">Hành động này sẽ xóa chức vụ vĩnh viễn khỏi cơ sở dữ liệu hệ thống.</p>
            <form id="delete-form" method="POST" class="flex items-center justify-center space-x-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeConfirmModal()" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-50">Hủy</button>
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium shadow-xs">Xác nhận xóa</button>
            </form>
        </div>
    </div>

    <script>
        const modal = document.getElementById('crud-modal');
        const confirmModal = document.getElementById('confirm-modal');
        const form = document.getElementById('modal-form');
        const methodField = document.getElementById('method-field');

        function openAddModal() {
            form.reset();
            document.getElementById('modal-title').innerText = "Thêm chức vụ mới";
            form.action = "{{ route('positions.store') }}";
            methodField.value = "POST";
            modal.classList.remove('hidden');
        }

        function openEditModal(position) {
            document.getElementById('modal-title').innerText = "Cập nhật chức vụ";
            form.action = `/positions/${position.id}`;
            methodField.value = "PUT";
            
            document.getElementById('form-code').value = position.code;
            document.getElementById('form-name').value = position.name;
            document.getElementById('form-dept-select').value = position.department_id;
            document.getElementById('form-status').value = position.status;
            modal.classList.remove('hidden');
        }

        function closeModal() { modal.classList.add('hidden'); }

        function triggerDelete(id) {
            document.getElementById('delete-form').action = `/positions/${id}`;
            confirmModal.classList.remove('hidden');
        }

        function closeConfirmModal() { confirmModal.classList.add('hidden'); }

        document.getElementById('mobile-menu-btn').addEventListener('click', () => {
            document.getElementById('sidebar-menu').classList.toggle('hidden');
        });

        document.querySelectorAll('.toast-item').forEach(toast => {
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        });
    </script>
</body>
</html>