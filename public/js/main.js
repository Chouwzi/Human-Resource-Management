/* ==========================================
   XỬ LÝ FORM TẠO ĐƠN NGHỈ PHÉP (USER)
   ========================================== */
document.addEventListener('DOMContentLoaded', function() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');

    if (startDateInput && endDateInput) {
        startDateInput.addEventListener('change', function() {
            const selectedStartDate = this.value;
            
            if (selectedStartDate) {
                // Ép Đến ngày tối thiểu phải bằng Từ ngày
                endDateInput.min = selectedStartDate;
                
                // Nếu Đến ngày đang nhỏ hơn Từ ngày thì reset lại cho bằng
                if (endDateInput.value && endDateInput.value < selectedStartDate) {
                    endDateInput.value = selectedStartDate;
                }
            }
        });
    }
});

/* ==========================================
   XỬ LÝ NÚT BẤM DUYỆT / TỪ CHỐI (ADMIN)
   ========================================== */
// Hàm bật bảng xác nhận Duyệt
function confirmApprove(id) {
    Swal.fire({
        title: 'Xác nhận phê duyệt',
        text: "Bạn có chắc chắn muốn duyệt đơn nghỉ phép này?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745', 
        cancelButtonColor: '#6c757d', 
        confirmButtonText: '<i class="fas fa-check"></i> Có, duyệt ngay',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-approve-' + id).submit();
        }
    });
}

// Hàm bật bảng xác nhận Từ chối
function confirmReject(id) {
    Swal.fire({
        title: 'Từ chối đơn này?',
        text: "Hành động này không thể hoàn tác. Bạn có chắc chắn không?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545', 
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-times"></i> Xác nhận từ chối',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-reject-' + id).submit();
        }
    });
}/* ==========================================
   XỬ LÝ NÚT HỦY ĐƠN (USER)
   ========================================== */
function confirmCancel(id) {
    Swal.fire({
        title: 'Bạn muốn hủy đơn này?',
        text: "Đơn sau khi hủy sẽ không thể khôi phục lại!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545', // Màu đỏ cảnh báo
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash-alt"></i> Xác nhận hủy',
        cancelButtonText: 'Đóng'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-cancel-' + id).submit();
        }
    });
}
/* ==========================================
   CẬP NHẬT SỐ LƯỢNG ĐƠN CHỜ DUYỆT (REAL-TIME)
   ========================================== */
document.addEventListener('DOMContentLoaded', function() {
    const badgeMenu = document.querySelector('.right.badge.badge-warning');

    if (badgeMenu) {
        function updatePendingBadge() {
            fetch('/api/leaves/pending-count')
                .then(response => response.json())
                .then(data => {
                    if (data.count > 0) {
                        badgeMenu.style.display = 'inline-block';
                        badgeMenu.textContent = data.count;
                    } else {
                        badgeMenu.style.display = 'none'; // Ẩn đi nếu không còn đơn nào
                    }
                })
                .catch(error => console.error('Lỗi cập nhật badge:', error));
        }

        // Cứ mỗi 10 giây (10000ms) sẽ tự động kiểm tra một lần
        setInterval(updatePendingBadge, 10000);
    }
});
/* ==========================================
   ĐẾM SỐ KÝ TỰ / CHẶN NHẬP QUÁ GIỚI HẠN LÝ DO
   ========================================== */
document.addEventListener('DOMContentLoaded', function() {
    const reasonTextarea = document.getElementById('reasonTextarea');
    const charCountNotice = document.getElementById('charCountNotice');
    
    if (reasonTextarea && charCountNotice) {
        const maxChars = 50; // Giới hạn tương đương 50 chữ

        reasonTextarea.addEventListener('input', function() {
            const currentLength = reasonTextarea.value.length;
            const charsLeft = maxChars - currentLength;

            if (charsLeft <= 0) {
                charCountNotice.style.color = 'var(--danger, #dc3545)';
                charCountNotice.textContent = 'Bạn đã đạt giới hạn tối đa cho phép!';
            } else {
                charCountNotice.style.color = 'var(--text-muted, #6c757d)';
                charCountNotice.textContent = `Còn lại ${charsLeft} ký tự.`;
            }
        });
    }
});
// Hàm bật bảng xác nhận Xóa đơn nghỉ phép
function confirmDeleteLeave(id) {
    Swal.fire({
        title: 'Xác nhận xóa?',
        text: "Bạn có chắc chắn muốn xóa vĩnh viễn đơn nghỉ phép này không?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33', // Màu đỏ
        cancelButtonColor: '#6c757d', // Màu xám
        confirmButtonText: '<i class="fas fa-trash-alt"></i> Xóa bỏ',
        cancelButtonText: 'Hủy'
    }).then((result) => {
        if (result.isConfirmed) {
            // Tìm form xóa tương ứng và submit ngầm
            document.getElementById('form-delete-' + id).submit();
        }
    });
}