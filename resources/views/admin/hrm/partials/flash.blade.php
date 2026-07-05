@if(session('success'))
    <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-error"><i class="fas fa-triangle-exclamation"></i> {{ session('error') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-error">
        <i class="fas fa-circle-exclamation"></i> Vui lòng kiểm tra lại dữ liệu nhập.
        <ul class="validation-error-list">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
