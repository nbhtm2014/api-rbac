<?php
/**
 * Creator htm
 * Created by 2020/10/29 10:35
 **/

namespace Szkj\Rbac\Requests\Menus;


use Szkj\Rbac\Requests\BaseRequest;

class MenuUpdateRequest extends BaseRequest
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
            'pid'  => 'required',
            'path' => 'sometimes',
            'icon' => 'sometimes',
        ];
    }
}