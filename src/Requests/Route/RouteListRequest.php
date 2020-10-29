<?php
/**
 * Creator htm
 * Created by 2020/10/29 14:17
 **/

namespace Szkj\Rbac\Requests\Route;


use Szkj\Rbac\Requests\BaseRequest;

class RouteListRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'sometimes|string',
            'pid' =>'required'
        ];
    }
}