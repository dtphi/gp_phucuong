<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class AccessDeniedCommon extends Exception
{
    /**
     * @author : dtphi .
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            'code'    => Response::HTTP_FORBIDDEN,
            'message' => 'Bạn chưa có quyền thực hiện',
            'results'  => []
        ], Response::HTTP_OK);
    }

    public function getJsonArray()
    {
        return json_encode(['data' => [
            'code'    => Response::HTTP_FORBIDDEN,
            'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => 'Bạn chưa có quyền thực hiện',
            'results'  => []
        ]]);
    }
}
