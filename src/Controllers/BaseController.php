<?php
/**
 * Creator htm
 * Created by 2020/10/28 17:23
 **/

namespace Szkj\Rbac\Controllers;


use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    /**
     * @param null $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data = null,string $message = '操作成功',  int $code = 200)
    {
        $success = [
            'code'    => $code,
            'message' => $message,
        ];
        if (!empty($data)) $success['data'] = $data;
        return  response()->json($success);
    }

    /**
     * @param int $code
     * @param string $message
     * @param mixed ...$array
     * @return \Illuminate\Http\JsonResponse
     */
    public function error(int $code, string $message = '操作失败', ...$array)
    {
        $error = [
            'code'    => $code,
            'message' => $message,
        ];
        if (!empty($array)) {
            array_push($error, json_encode($array));
        }
        return  response()->json($error);
    }
}