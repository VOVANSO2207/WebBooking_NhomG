@extends('layouts.app')

@section('content')
<div class="container">
    <div class="alert alert-danger" role="alert">
        Bạn không có quyền truy cập vào trang này. Vui lòng liên hệ với quản trị viên nếu cần hỗ trợ.
    </div>
    <a href="{{ route('auth.login') }}" class="btn btn-primary">Quay lại trang đăng nhập</a>
</div>
@endsection
