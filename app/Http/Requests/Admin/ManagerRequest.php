<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if (!request()->is('admin/users/create')) {
            return [
                //  'meter_id' => 'required|unique:users,meter_id',
                'address'=>'required',
                'username' => 'required|unique:users,username',
                'name' => 'required|max:150',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|numeric|digits:10|unique:users,phone|starts_with:1,2,3,4,5,6,7,8,9',
                'password' => 'required',
                'c_password' => 'same:password',
                'role' => 'required',
            ];

        } else {
            return [
                //  'meter_id' => 'required|unique:users,meter_id',
                'address'=>'required',
                'username' => 'unique:users,username',
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|numeric|digits:10|unique:users,phone|starts_with:1,2,3,4,5,6,7,8,9',
                'password' => 'required',
                'c_password' => 'same:password',
                'role' => 'required',
            ];
        }
    }

    public function messages()
    {
        return [
            // 'meater_id.required' => __('validation.required', ['attribute' => 'Manager Id']),
            'name.required' => __('validation.required', ['attribute' => 'Name']),
            'email.required' => __('validation.required', ['attribute' => 'Email']),
            'email.email' => __('validation.email', ['attribute' => 'Email']),
            'email.unique' => __('validation.unique', ['attribute' => 'Email']),
            'username.required' => __('validation.required', ['attribute' => 'Username']),
            'username.unique' => __('validation.unique', ['attribute' => 'Username']),
            'phone.required' => __('validation.required', ['attribute' => 'Phone']),
            'phone.phone' => __('validation.phone', ['attribute' => 'Phone']),
            'phone.unique' => __('validation.unique', ['attribute' => 'Phone']),
            'meter_id.required' => __('validation.required', ['attribute' => 'Manager Id']),
            'address.required' => __('validation.required', ['attribute' => 'Location']),
            'phone.required' => __('validation.required', ['attribute' => 'phone']),
            'password.required' => __('validation.required', ['attribute' => 'password']),
            'c_password.required' => __('validation.required', ['attribute' => 'confirm password']),
            'role.required' => __('validation.required', ['attribute' => 'role']),
        ];
    }
}
