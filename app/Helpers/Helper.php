<?php

namespace App\Helpers;

use App\Models\Linhmuc;
use Illuminate\Http\Response;
use Log;
use Illuminate\Support\Facades\Hash;

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

    public static function getLinhMucAll($data = [])
    {
        if (request()->isMethod('post')) {
            Log::info($data);
            return self::updateAccountLinhMuc($data['params']);
        } else {
            return Linhmuc::all(['id', 'ten', 'email']);
        }
    }

    public static function getLinhMucAllFilter($data = [])
    {
        if (isset($data['uid'])) {
            return Linhmuc::where('code', '=', $data['uid'])->first();
        }
        return Linhmuc::select(['id', 'ten', 'email'])
        ->where('ten', 'LIKE', "%{$data['name']}%")
        ->orderBy('ten')
        ->get();
    }

    public static function updateAccountLinhMuc($data = [])
    {
        Log::info(json_encode($data));
        $linhMuc = Linhmuc::find($data['id']);
        if ($linhMuc->email != $data['email']) {
            $linhMuc->email = $data['email'];
        }
        $linhMuc->uuid = $data['uid'];
        $linhMuc->code = $data['uid'];
        $linhMuc->password = Hash::make($data['passw']);
        $linhMuc->save();

        return [
            'code' => 1000,
            'message' => 'OK'
        ];
    }
}
