<?php
/**
 * Creator htm
 * Created by 2020/10/29 13:56.
 **/

namespace Szkj\Rbac\Requests\RouteCatalog;

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
            //
            'id'        => 'required|exists:routes_catalogs,id',
            'route_ids' => 'sometimes|json',
        ];
    }
}
