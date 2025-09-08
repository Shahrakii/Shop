<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // We can just allow authorization here; actual permission checks are handled in the controller
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $adminId = $this->route('admin') ? $this->route('admin')->id : null;

        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $adminId,
            'phone_number' => 'required|string|max:20|unique:admins,phone_number,' . $adminId,
            'password' => $this->isMethod('post') 
                ? 'required|string|min:6' 
                : 'nullable|string|min:6',
            'status' => 'required|boolean',
            'role' => 'required|string|exists:roles,name',
        ];
    }

    /**
     * Custom messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'نام مدیر الزامی است.',
            'email.required' => 'ایمیل الزامی است.',
            'email.email' => 'ایمیل وارد شده معتبر نیست.',
            'email.unique' => 'این ایمیل قبلا ثبت شده است.',
            'phone_number.required' => 'شماره تلفن الزامی است.',
            'phone_number.unique' => 'این شماره تلفن قبلا ثبت شده است.',
            'password.required' => 'رمز عبور الزامی است.',
            'password.min' => 'رمز عبور باید حداقل 6 کاراکتر باشد.',
            'status.required' => 'وضعیت الزامی است.',
            'role.required' => 'نقش الزامی است.',
            'role.exists' => 'نقش انتخاب شده معتبر نیست.',
        ];
    }
}
