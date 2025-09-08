@extends('core::layout.master')

@section('content')
<h1>ادمین‌ها</h1>

@can('make admin')
    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary mb-3">ایجاد ادمین جدید</a>
@endcan

<table class="table table-hover table-striped shadow-sm">
    <thead class="thead-dark">
        <tr>
            <th>نام</th>
            <th>ایمیل</th>
            <th>شماره تلفن</th>
            <th>وضعیت</th>
            <th>نقش</th>
            <th>عملیات</th>
        </tr>
    </thead>
    <tbody>
        @foreach($admins as $admin)
        <tr @if($admin->hasRole('super-admin')) class="table-warning" @endif>
            <td>{{ $admin->name }}</td>
            <td>{{ $admin->email }}</td>
            <td>{{ $admin->phone_number }}</td>
            <td>{{ $admin->status ? 'فعال' : 'غیرفعال' }}</td>
            <td>{{ $admin->roles->pluck('label')->join(', ') }}</td>
            <td>
                @can('view admin')
                    <a href="{{ route('admin.admins.show', $admin) }}" class="btn btn-info btn-sm">مشاهده</a>
                @endcan

                @can('edit admin')
                    @if(!$admin->hasRole('super admin') || (auth()->user()->hasRole('super admin') && auth()->user()->id === $admin->id))
                        <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-warning btn-sm">ویرایش</a>
                    @endif
                @endcan

                @can('delete admin')
                    @if(!$admin->hasRole('super admin'))
                        <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" style="display:inline;" class="delete-admin-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" data-name="{{ $admin->name }}">حذف</button>
                        </form>
                    @endif
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<style>
    .table-hover tbody tr:hover {
        background-color: #d0e4ff;
    }
    .table-warning {
        font-weight: bold;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-admin-form button');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');
                const adminName = this.dataset.name;

                Swal.fire({
                    title: 'آیا مطمئن هستید؟',
                    text: `ادمین "${adminName}" حذف خواهد شد!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'بله، حذف کن!',
                    cancelButtonText: 'لغو'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>


@endsection
