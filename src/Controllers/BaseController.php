<?php
/**
 * Creator htm
 * Created by 2020/10/28 17:23.
 **/

namespace Szkj\Rbac\Controllers;

use Dingo\Api\Http\Response;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;

class BaseController extends Controller
{
    use Helpers;

    /**
     * @param null   $data
     * @param string $message
     * @param int    $code
     *
     * @return Response
     */
    public function success($data = null, string $message = '操作成功', int $code = 200)
    {
        $success = [
            'code'    => $code,
            'message' => $message,
        ];
        if (!empty($data)) {
            $success['data'] = $data;
        }

        return $this->response->array($success);
    }

    /**
     * @param int    $code
     * @param string $message
     * @param mixed  ...$array
     *
     * @return Response
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

        return $this->response->array($error);
    }
}
