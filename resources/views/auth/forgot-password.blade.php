@extends('layouts.app')

@section('content')
<div class="container">
    <h2>نسيت كلمة المرور؟</h2>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">إرسال رابط إعادة تعيين كلمة المرور</button>
    </form>
</div>
@endsection
