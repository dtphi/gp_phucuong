<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class HandlerMsgCommon extends Exception
{
    /**
     * @author : dtphi .
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            'code'    => Response::HTTP_BAD_REQUEST,
            'message' => 'Có lỗi đầu vào',
            'result'  => []
        ], Response::HTTP_OK);
    }
}
