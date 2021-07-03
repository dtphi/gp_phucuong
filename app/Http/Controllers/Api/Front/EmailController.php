<?php

namespace App\Http\Controllers\Api\Front;

use App\Http\Controllers\Api\Front\Base\ApiController as Controller;
use App\Http\Resources\EmailSubscribe\EmailCollection;
use App\Models\EmailSubscribe;
use Dotenv\Exception\ValidationException;
use Error;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as ValidationValidationException;
use PhpParser\Node\Stmt\TryCatch;

class EmailController extends Controller
{
  public function store(Request $request)
  {
    // validation request 
    $request->validate([
      'email' => 'required|email|max:255|unique:email_subscribes',
    ]);

    $email_sub = new EmailSubscribe([
      'email' => $request->get('email'),
    ]);
    
    $email_sub->save();

    return response()->json('success');
  }
}