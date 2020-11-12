<?php
/**
 * Creator htm
 * Created by 2020/10/29 9:56.
 **/

namespace Szkj\Rbac\Requests\Menus;

use Szkj\Rbac\Requests\BaseRequest;

class MenuStoreRequest extends BaseRequest
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
            'pid'  => 'required',
            'name' => 'required',
            'path' => 'sometimes',
            'icon' => 'sometimes',
        ];
    }
}
