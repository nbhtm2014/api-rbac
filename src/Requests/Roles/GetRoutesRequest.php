<?php
/**
 * Creator htm
 * Created by 2020/10/29 13:38.
 **/

namespace Szkj\Rbac\Requests\Roles;

use Szkj\Rbac\Requests\BaseRequest;

class GetRoutesRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:roles,id',
        ];
    }
}
