<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    protected function success($data, $message = 'Ok', $code = Response::HTTP_OK)
    {
        $default = ['message' => $message];

        // manipulate $data for pagination

        return response()->json($default + ['data' => $data], $code);
    }

    protected function error($message, $code)
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
        ], $code);
    }
}
