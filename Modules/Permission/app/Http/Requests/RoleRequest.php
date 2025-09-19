<?php

namespace Modules\Permission\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Spatie\Permission\Models\Role;

class RoleRequest extends FormRequest
{
    public function authorize()
    {
        // Allow only admins to create/update roles
        return auth()->guard('admin')->check();
    }

    public function rules()
    {
        $roleId = $this->route('role') ? $this->route('role')->id : null;

        return [
            'name' => 'required|string|unique:roles,name,' . $roleId,
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'نام نقش الزامی است.',
            'name.unique' => 'این نام نقش قبلاً ثبت شده است.',
            'permissions.array' => 'مجوزها باید به صورت آرایه ارسال شوند.',
            'permissions.*.exists' => 'یکی از مجوزهای انتخاب شده معتبر نیست.',
        ];
    }
}
