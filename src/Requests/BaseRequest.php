<?php
/**
 * Creator htm
 * Created by 2020/10/29 9:49.
 **/

namespace Szkj\Rbac\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Szkj\Rbac\Exceptions\RbacBadRequestExceptions;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new RbacBadRequestExceptions(200, $validator->errors()->first());
    }

    public function failedAuthorization()
    {
        throw  new RbacBadRequestExceptions(200, '您没有权限');
    }
}
