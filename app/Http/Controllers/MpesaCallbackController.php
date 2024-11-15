<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\MpesaCallbackRegistrationService;

class MpesaCallbackController extends Controller
{
    //

    /**
     * Handle the registration of M-PESA callback URLs.
     *
     * @param \Illuminate\Http\Request $request The incoming request containing callback URL data.
     * 
     * @return \Illuminate\Http\JsonResponse A JSON response with the result of the registration.
     */


     public function registerCallback(Request $request): JsonResponse
     {
 
 
         $validateData = Validator::make($request->all(),[
             'confirmation_url' => 'required|url',
             'validation_url' => 'required|url',
             'consumer_key' => 'required|string',
             'consumer_secret' => 'required|string',
             'shortcode' => 'required|numeric'
         ]);
 
         if ($validateData->fails()) {
             return response()->json($validateData->errors(), 422);
         }
 
         $requestData = $validateData->validated();
 
         $callbackUrlData = [
             'confirmation_url' => $requestData['confirmation_url'],
             'validation_url' => $requestData['validation_url'],
             'consumer_key' => $requestData['consumer_key'],
             'consumer_secret' => $requestData['consumer_secret'],
             'shortcode' => $requestData['shortcode'],
         ];
 
         $mpesaCallbackRegistration = new MpesaCallbackRegistrationService;
 
 
         $response = $mpesaCallbackRegistration->registerCallBackUrl($callbackUrlData);
 
         if (isset($response['error'])) {
             Log::channel('mpesa')->error('Callback URL registration failed: ' . $response['error']);
 
             return response()->json([
                 'status' => 'error',
                 'message' => $response['error']
             ], 500);
         }
 
         return response()->json([
             'status' => 'success',
             'message' => $response['success'] ?? 'Callback URL registered successfully'
         ], 200);
     }
}
