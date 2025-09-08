@extends('core::layout.master')

@section('content')
<h1>{{ isset($admin) ? 'ویرایش ادمین' : 'ایجاد ادمین جدید' }}</h1>

<form action="{{ isset($admin) ? route('admin.admins.update', $admin) : route('admin.admins.store') }}" method="POST">
    @csrf
    @if(isset($admin)) @method('PATCH') @endif

    <div class="form-group">
        <label>نام</label>
        <input type="text" name="name" class="form-control" value="{{ $admin->name ?? '' }}" required>
    </div>

    <div class="form-group">
        <label>ایمیل</label>
        <input type="email" name="email" class="form-control" value="{{ $admin->email ?? '' }}" required>
    </div>

    <div class="form-group">
        <label>شماره تلفن</label>
        <input type="text" name="phone_number" class="form-control" value="{{ $admin->phone_number ?? '' }}" required>
    </div>

    <div class="form-group">
        <label>رمز عبور {{ isset($admin) ? '(خالی بگذارید تا تغییر نکند)' : '' }}</label>
        <input type="password" name="password" class="form-control" {{ isset($admin) ? '' : 'required' }}>
    </div>

    <div class="form-group">
        <label>وضعیت</label>
        <select name="status" class="form-control">
            <option value="1" {{ (isset($admin) && $admin->status) ? 'selected' : '' }}>فعال</option>
            <option value="0" {{ (isset($admin) && !$admin->status) ? 'selected' : '' }}>غیرفعال</option>
        </select>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label>نقش</label>
            <select name="role" class="form-control" required>
                @foreach($roles as $role)
                    @if($role->name !== 'super admin') 
                        <option value="{{ $role->name }}"
                            {{ isset($admin) && $admin->hasRole($role->name) ? 'selected' : '' }}>
                            {{ $role->label ?? $role->name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <br>

    <button type="submit" class="btn {{ isset($admin) ? 'btn-primary' : 'btn-success' }}">
        {{ isset($admin) ? 'بروزرسانی' : 'ایجاد' }}
    </button>
</form>

<style>
    form {
        max-width: 600px;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 6px 18px rgba(0,0,0,0.1);
    }
    .form-group label {
        font-weight: 600;
        color: #333;
    }
    .form-control {
        border-radius: 8px;
        padding: 10px;
        border: 1px solid #ccd0d5;
        transition: 0.3s;
    }
    .form-control:focus {
        border-color: #5563DE;
        box-shadow: 0 0 5px rgba(85, 99, 222, 0.4);
    }
    button.btn-primary {
        background-color: #5563DE;
        border: none;
    }
    button.btn-primary:hover {
        background-color: #3f4bb5;
    }
    button.btn-success {
        background-color: #28a745;
        border: none;
    }
    button.btn-success:hover {
        background-color: #218838;
    }
</style>
@endsection
