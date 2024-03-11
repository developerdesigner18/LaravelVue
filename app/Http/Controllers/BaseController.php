<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    // Send Success
    function sendSuccess($message){
        return response()->json([
            'status' => true,
            'message' => $message
        ],200);
    }

    // Send Error
    function sendError($message){
        return response()->json([
            'status' => false,
            'message' => $message
        ],403);
    }

    // Send Response
    function sendResponse($message, $content){
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $content
        ], 200);
    }
}
