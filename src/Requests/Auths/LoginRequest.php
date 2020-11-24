<?php
/**
 * Creator htm
 * Created by 2020/11/24 9:28
 **/

namespace Szkj\Rbac\Requests\Auths;


use Szkj\Rbac\Requests\BaseRequest;

class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'password' => 'required',
        ];
    }
}