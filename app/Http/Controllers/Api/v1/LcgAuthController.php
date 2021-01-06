<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 9/23/2020
 * Time: 9:12 AM
 */

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LcgAuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * @author : Phi .
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @author : Phi .
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginToken(Request $request)
    {
        $json = [
            'message' => '',
            'errors'  => '',
            'code'    => 200,
            'results' => [
                'id'    => 1,
                'name'  => 'Admin',
                'email' => 'admin@gmail.com'
            ]
        ];

        return \response()->json($json);
    }
}
