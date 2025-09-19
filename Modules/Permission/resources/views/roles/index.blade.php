@extends('core::layout\master')

@section('content')
<div class="row">
    <div class="col-md-12 col-lg-12">
        <div class="card">

            {{-- Display Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Display Session Messages --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card-header d-flex justify-content-between">
                <div class="card-title">لیست همه نقش ها ({{ $roles->total() }})</div>
                
                @can('make role')
                <div class="text-bg-primary position-absolute" style="border-radius: 5px; left: 15px; top: 10px;">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-indigo text-light">
                        ثبت نقش جدید
                    </a>
                </div>
                @endcan

                <div class="card-options">
                    <a href="#" class="card-options-collapse" data-toggle="card-collapse">
                        <i class="fe fe-chevron-up"></i>
                    </a>
                    <a href="#" class="card-options-fullscreen" data-toggle="card-fullscreen">
                        <i class="fe fe-maximize"></i>
                    </a>
                    <a href="#" class="card-options-remove" data-toggle="card-remove">
                        <i class="fe fe-x"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-nowrap text-center">
                        <thead>
                            <tr>
                                <th>شناسه</th>
                                <th>نام</th>
                                <th>نام قابل مشاهده</th>
                                <th>تاریخ ثبت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->label ?? '-' }}</td>
                                <td>{{ \Morilog\Jalali\Jalalian::fromCarbon($role->created_at)->format('Y/m/d') }}</td>
                                <td>
                                    {{-- Edit --}}
                                    @can('edit role')
                                        @php
                                            $superAdminRoleId = 1; // replace with actual Super Admin role id
                                            $isSuperAdminRole = $role->id === $superAdminRoleId;
                                            $currentUserIsSuperAdmin = auth()->user()->hasRole('super admin');
                                        @endphp

                                        @if(!$isSuperAdminRole || ($isSuperAdminRole && $currentUserIsSuperAdmin))
                                            <a href="{{ route('admin.roles.edit', [$role->id]) }}"
                                               class="btn btn-warning btn-sm text-white" data-toggle="tooltip"
                                               data-original-title="ویرایش">
                                                ویرایش
                                            </a>
                                        @endif
                                    @endcan

                                    {{-- Delete --}}
                                    @can('delete role')
                                        @php
                                            $protectedRoles = ['super admin']; // Cannot delete super admin
                                        @endphp
                                        <button class="btn btn-danger btn-sm text-white"
                                            onclick="confirmDelete('delete-{{ $role->id }}')"
                                            @disabled(in_array($role->name, $protectedRoles))>
                                            حذف
                                        </button>

                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="post"
                                            id="delete-{{ $role->id }}" style="display: none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">
                                    <p class="text-danger"><strong>در حال حاضر هیچ نقشی یافت نشد!</strong></p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(formId) {
    Swal.fire({
        title: 'آیا مطمئن هستید؟',
        text: "این عمل قابل بازگشت نیست!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'بله، حذف کن!',
        cancelButtonText: 'لغو'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}
</script>
@endsection
