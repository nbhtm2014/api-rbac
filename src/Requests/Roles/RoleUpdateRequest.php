<?php
/**
 * Creator htm
 * Created by 2020/10/29 13:10.
 **/

namespace Szkj\Rbac\Requests\Roles;

use Illuminate\Validation\Rule;
use Szkj\Rbac\Requests\BaseRequest;

class RoleUpdateRequest extends BaseRequest
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
            'name' => ['required', Rule::unique('roles')->ignore($this->id)],
        ];
    }
}
