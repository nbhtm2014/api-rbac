<?php
/**
 * Creator htm
 * Created by 2020/11/24 14:03
 **/

namespace Szkj\Rbac\Requests\Users;


use Illuminate\Validation\Rule;
use Szkj\Rbac\Requests\BaseRequest;

class UserUpdateRequests extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required',
            'phone'    => ['required', 'min:11', 'max:11', Rule::unique('users', 'phone')->ignore($this->id, 'id')],
            'email'    => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($this->id, 'id')],
            'password' => ['sometimes', 'string', 'min:8', 'max:16', 'confirmed'],
            'role_id'  => ['required', 'exists:roles,id'],
        ];
    }
}