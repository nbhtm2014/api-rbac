<?php
/**
 * Creator htm
 * Created by 2020/10/29 9:50.
 **/

namespace Szkj\Rbac\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class RbacBadRequestExceptions extends HttpException
{
    public function __construct(int $statusCode, string $message = null, \Throwable $previous = null, array $headers = [], ?int $code = 422)
    {
        $origin = request()->server('HTTP_ORIGIN') ? request()->server('HTTP_ORIGIN') : '*';
        $headers = [
            'Access-Control-Allow-Origin' => $origin,
            'Access-Control-Allow-Headers' => 'Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN',
            'Access-Control-Expose-Headers' => 'Authorization, authenticated',
            'Access-Control-Allow-Methods' => 'GET, POST, PATCH, PUT, OPTIONS,DELETE',
            'Access-Control-Allow-Credentials' => 'true',
        ];
        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}
