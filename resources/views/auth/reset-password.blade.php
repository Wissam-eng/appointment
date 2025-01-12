@extends('layouts.app')

@section('content')
<div class="container">
    <h2>إعادة تعيين كلمة المرور</h2>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-group">
            <label for="password">كلمة المرور الجديدة</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">تأكيد كلمة المرور الجديدة</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
        </div>
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <button type="submit" class="btn btn-primary">إعادة تعيين كلمة المرور</button>
    </form>
</div>
@endsection
