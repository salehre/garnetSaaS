@extends('admin.layouts.guest')

@section('title', 'ورود به پنل مدیریت')

@section('content')
    <div class="login-box">
        <h2>ورود به پنل مدیریت</h2>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <label for="email">ایمیل</label>
            <input type="text" id="email" name="email" value="{{ old('email') }}" autofocus>

            <label for="password">رمز عبور</label>
            <input type="password" id="password" name="password">

            <label style="display:flex; align-items:center; gap:6px; margin-top:16px;">
                <input type="checkbox" name="remember" style="width:auto;"> مرا به خاطر بسپار
            </label>

            <button type="submit" class="btn btn-primary" style="width:100%; margin-top:20px; padding:10px;">
                ورود
            </button>
        </form>
    </div>
@endsection
