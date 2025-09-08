@extends('core::layout.master')

@section('content')
<h1>جزئیات ادمین</h1>

<p><strong>نام:</strong> {{ $admin->name }}</p>
<p><strong>ایمیل:</strong> {{ $admin->email }}</p>
<p><strong>شماره تلفن:</strong> {{ $admin->phone_number }}</p>
<p><strong>نقش:</strong> 
    {{ $admin->roles->pluck('label')->join(', ') }}
</p>
<p><strong>وضعیت:</strong> {{ $admin->status ? 'فعال' : 'غیرفعال' }}</p>

<a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">بازگشت به لیست</a>
@endsection
