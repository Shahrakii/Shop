@extends('core::layout.master')

@section('content')
<h1>ویرایش ادمین</h1>

<form action="{{ route('admin.admins.update', $admin) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="form-group">
        <label>نام</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
    </div>

    <div class="form-group">
        <label>ایمیل</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
    </div>

    <div class="form-group">
        <label>شماره تلفن</label>
        <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number', $admin->phone_number) }}" required>
    </div>

    <div class="form-group">
        <label>رمز عبور (خالی بگذارید تا تغییر نکند)</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="form-group">
        <label>وضعیت</label>
        <select name="status" class="form-control">
            <option value="1" @if($admin->status) selected @endif>فعال</option>
            <option value="0" @if(!$admin->status) selected @endif>غیرفعال</option>
        </select>
    </div>

    {{-- Roles --}}
    <div class="form-group">
        <label>نقش</label>
        <select name="role" class="form-control" required>
            @foreach($roles as $role)
                <option value="{{ $role->name }}"
                    @if($admin->hasRole($role->name)) selected @endif>
                    {{ $role->label ?? $role->name }}
                </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn btn-primary">بروزرسانی</button>
</form>
@endsection
