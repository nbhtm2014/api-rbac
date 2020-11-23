<?php
/**
 * Creator htm
 * Created by 2020/11/23 15:19
 **/

namespace Szkj\Rbac\Requests\Users;


use Illuminate\Validation\Rule;
use Szkj\Rbac\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $array = [
            'name'     => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:16', 'confirmed'],
            'phone'    => ['required', 'min:11', 'max:11', 'unique:users'],
            'email'    => ['sometimes', 'email', Rule::unique('users', 'email')],
            'role_id'  => ['required', 'exists:roles,id'],
        ];
       $pcd = config('szkj.rbac');
       foreach ($pcd as $k=>$v){
           if ($v) {
               $array[$k] = ['required'];
           }
       }
       return  $array;
    }
}