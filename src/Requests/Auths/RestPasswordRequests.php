<?php
/**
 * Creator htm
 * Created by 2020/11/24 14:35
 **/

namespace Szkj\Rbac\Requests\Auths;


use Szkj\Rbac\Requests\BaseRequest;

class RestPasswordRequests extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => ['required', 'string', 'min:8', 'max:16', 'confirmed'],
        ];
    }
}