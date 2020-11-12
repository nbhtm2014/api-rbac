<?php
/**
 * Creator htm
 * Created by 2020/10/29 13:50.
 **/

namespace Szkj\Rbac\Requests\RouteCatalog;

use Szkj\Rbac\Requests\BaseRequest;

class RouteCatalogStoreRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:routes_catalogs',
        ];
    }
}
