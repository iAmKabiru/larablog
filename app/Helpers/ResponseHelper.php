<?php

namespace App\Helpers;

class ResponseHelper
{

    public static function success($message, $status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message
        ], $status);
    }

    public static function fail($message, $status = 500): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], $status);
    }

    public static function successWithData($message, $data, $staus = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $staus);
    }

    public static function failWithData($message, $data, $status = 500): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
