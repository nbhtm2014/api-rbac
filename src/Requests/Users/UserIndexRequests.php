<?php
/**
 * Creator htm
 * Created by 2020/11/24 13:25
 **/

namespace Szkj\Rbac\Requests\Users;


use Szkj\Rbac\Requests\BaseRequest;

class UserIndexRequests extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'name'      => 'sometimes',
            'role_id'   => ['sometimes', 'exists:roles,id'],
            'unit_name' => 'sometimes',
        ];
    }
}