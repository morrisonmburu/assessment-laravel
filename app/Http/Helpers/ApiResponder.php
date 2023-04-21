<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\MessageBag;

trait ApiResponder
{
    public function success($data, $code = 200)
    {
        return response()->json($data, $code);
    }

    public function error($message, $code = 500)
    {
        if ($message instanceof Exception) {
            $message = $message->getMessage();
        }
        if ($message instanceof MessageBag) {
            $message = $message->getMessages();
            $message = is_array($message) ? array_values($message)[0] : $message;
        }
        if (is_array($message)) {
            $message = implode(' ', $message);
        }
        return response()->json(['message' => $message, 'code' => $code], $code);
    }
}