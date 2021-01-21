<?php

namespace App\Helpers;

use Illuminate\Http\Response;

/**
 * Class Helper
 *
 * @package App\Helpers
 */
class Helper
{
    /**
     * Return success response
     *
     * @param array $data
     * @param int   $status
     *
     * @return \Illuminate\Http\JsonResponse
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
     * Return error response
     *
     * @param array $errors
     * @param int   $status
     *
     * @return \Illuminate\Http\JsonResponse
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
     * Random password
     *
     * @return string
     */
    public static function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;

        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }
}