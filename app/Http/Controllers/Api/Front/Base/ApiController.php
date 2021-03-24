<?php

namespace App\Http\Controllers\Api\Front\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // Success
    const RESPONSE_OK = 2000;
    const RESPONSE_CREATED = 2001;
    const RESPONSE_UPDATED = 2002;
    const RESPONSE_DELETED = 2003;
    const RESPONSE_IN_PROGRESS = 2004;

    /**
     * @author : dtphi .
     * ApiController constructor.
     * @param array $middleware
     */
    public function __construct(array $middleware = [])
    {
        parent::__construct($middleware);
    }
}
