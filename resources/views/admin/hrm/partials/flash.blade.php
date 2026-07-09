@if(session('success') || session('error') || $errors->any())
    @once
        <div id="toast-container"></div>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            let container = document.getElementById('toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'toast-container';
                document.body.appendChild(container);
            }
            
            function createToast(type, title, message, errors = []) {
                const toast = document.createElement('div');
                toast.className = `toast-card toast-${type}`;
                
                let iconClass = 'fa-info-circle';
                if (type === 'success') iconClass = 'fa-circle-check';
                if (type === 'error') iconClass = 'fa-circle-exclamation';
                
                let errorsHtml = '';
                if (errors.length > 0) {
                    errorsHtml = '<ul class="toast-error-list">';
                    errors.forEach(err => {
                        errorsHtml += `<li>${err}</li>`;
                    });
                    errorsHtml += '</ul>';
                }
                
                toast.innerHTML = `
                    <div class="toast-icon"><i class="fas ${iconClass}"></i></div>
                    <div class="toast-content">
                        <div class="toast-title">${title}</div>
                        <div class="toast-message">${message}</div>
                        ${errorsHtml}
                    </div>
                    <button class="toast-close"><i class="fas fa-times"></i></button>
                `;
                
                container.appendChild(toast);
                
                // Trigger show animation
                setTimeout(() => toast.classList.add('show'), 50);
                
                // Auto remove
                const autoDismiss = setTimeout(() => {
                    removeToast(toast);
                }, 5000);
                
                // Manual close
                toast.querySelector('.toast-close').addEventListener('click', () => {
                    clearTimeout(autoDismiss);
                    removeToast(toast);
                });
            }
            
            function removeToast(toast) {
                toast.classList.remove('show');
                toast.classList.add('hide');
                toast.addEventListener('transitionend', () => {
                    toast.remove();
                });
            }

            @if(session('success'))
                createToast('success', 'Thành công', '{!! addslashes(session('success')) !!}');
            @endif

            @if(session('error'))
                createToast('error', 'Lỗi', '{!! addslashes(session('error')) !!}');
            @endif

            @if($errors->any())
                const errors = [];
                @foreach($errors->all() as $error)
                    errors.push('{!! addslashes($error) !!}');
                @endforeach
                createToast('error', 'Lỗi nhập liệu', 'Vui lòng kiểm tra lại dữ liệu nhập.', errors);
            @endif
        });
        </script>
    @endonce
@endif
