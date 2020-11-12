<?php
/**
 * Creator htm
 * Created by 2020/10/29 13:24.
 **/

namespace Szkj\Rbac\Requests\Roles;

use Szkj\Rbac\Requests\BaseRequest;

class DistributionRoutesRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'        => 'required|exists:roles,id',
            'route_ids' => 'required|json',
        ];
    }
}
