<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;
use Exception;

trait ApiResponder
{
    public function success($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    public function error($message, $code = 500)
    {
        return response()->json(['message' => $message, 'code' => $code], $code);
    }
}