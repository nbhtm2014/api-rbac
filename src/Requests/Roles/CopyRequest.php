<?php
/**
 * Creator htm
 * Created by 2020/10/29 13:36
 **/

namespace Szkj\Rbac\Requests\Roles;


use Szkj\Rbac\Requests\BaseRequest;

class CopyRequest extends BaseRequest
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
            'id'=>'required|exists:roles,id',
            'name'=>'required|unique:roles,name'
        ];
    }
}