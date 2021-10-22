<?php

namespace App\Helpers;

use Illuminate\Http\Response;

/**
 * Class Helper
 *
 * @package App\Helpers
 */
final class Helper
{
    /**
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     *
     * Return success response
     */
    public static function successResponse(array $data = [], int $status = Response::HTTP_OK)
    {
        $response = [
            'success' => true,
            'status'  => $status,
            'data'    => $data
        ];

        return response()->json($response);
    }

    /**
     * @param array $errors
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     *
     * Return error response
     */
    public static function errorResponse(array $errors = [], int $status = Response::HTTP_NOT_FOUND)
    {
        $response = [
            'success' => false,
            'status'  => $status,
            'errors'  => $errors
        ];

        return response()->json($response);
    }

    /**
     * @return string
     *
     * Random password
     */
    public static function randomPassword()
    {
        $alphabet    = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $pass        = [];
        $alphaLength = strlen($alphabet) - 1;

        for ($i = 0; $i < 8; $i++) {
            $n      = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass);
    }
}
