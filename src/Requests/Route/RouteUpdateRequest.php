<?php
/**
 * Creator htm
 * Created by 2020/10/29 14:19.
 **/

namespace Szkj\Rbac\Requests\Route;

use Illuminate\Validation\Rule;
use Szkj\Rbac\Requests\BaseRequest;

class RouteUpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:routes,id',
            'path' => 'required',
            'name' => 'required',
            'default' => 'required',
            'pid' => 'required',
            'methods' => ['required', Rule::in(['POST', 'DELETE', 'GET', 'PUT'])],
        ];
    }
}
