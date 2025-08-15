@extends('layouts.auth')

@section('title', 'إنشاء حساب')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow p-4" style="width: 500px;">
            <h3 class="text-center mb-4">إنشاء حساب جديد</h3>

            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="name">الاسم الكامل</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label for="password">كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="age">العمر</label>
                    <input type="number" name="age" class="form-control" value="{{ old('age') }}" required>
                    @error('age')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label for="gender">الجنس</label>
                    <select name="gender" class="form-control" required>
                        <option value="">اختر</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                    @error('gender')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label for="profile_image">الصورة الشخصية (اختياري)</label>
                    <input type="file" name="profile_image" class="form-control">
                    @error('profile_image')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <button type="submit" class="btn btn-success w-100">تسجيل</button>

                <div class="mt-3 text-center">
                    <a href="{{ route('login') }}">هل لديك حساب؟ تسجيل الدخول</a>
                </div>
            </form>
        </div>
    </div>
@endsection
