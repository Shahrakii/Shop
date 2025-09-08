@extends('core::layout\master')

@section('content')

<!-- row opened -->
<div class="row">
    <div class="col-md">

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

        <div class="card overflow-hidden">
            <div class="card-header">
                <h3 class="card-title">ویرایش نقش</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.roles.update', $role->id) }}" method="post">
                    @csrf
                    @method('PATCH')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="control-label">نام (به انگلیسی) <span class="text-danger">&starf;</span></label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="نام را به انگلیسی اینجا وارد کنید" value="{{ old('name', $role->name) }}" required autofocus>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="label" class="control-label">نام قابل مشاهده (به فارسی) <span class="text-danger">&starf;</span></label>
                                <input type="text" class="form-control" name="label" id="label" placeholder="نام قابل مشاهده را به فارسی اینجا وارد کنید" value="{{ old('label', $role->label) }}" required>
                            </div>
                        </div>
                    </div>

                    <br>

                    @if($role->name !== 'super admin')
                        <h4 class="header p-2">مجوزها</h4>
                            <div class="row">
                                @foreach($permissions as $permission)
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="permissions[]" value="{{ $permission->id }}" 
                                                    @checked($role->permissions->contains('id', $permission->id))>
                                                <span class="custom-control-label">{{ $permission->label ?? $permission->name }}</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                    @endif

                    <div class="row">
                        <div class="col">
                            <div class="text-center">
                                <button class="btn btn-warning" type="submit">به روزرسانی</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- col end -->
</div>
<!-- row closed -->
@endsection
