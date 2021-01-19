<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $token = $request->header( 'Api-Key' );

        if($token){

            $decryptedToken  = decryptToken($token);
            $accessToken = explode(".", $decryptedToken);

            // Check static auth key
            if ($accessToken[0] != config('openapikey.static_auth_key')) {

                return response()->json([
                    'result'=> null,
                    'statusCode'=> 40101,
                    'message'=> trans('message.tokenInvalid')
                ]);
            }

            // Check timeStamp
            $startTime = Carbon::createFromTimeStamp($accessToken[1]);

            $now = Carbon::now('UTC');
        
            $totalDuration = $startTime->diffInMinutes($now); 
    
            if ($totalDuration >= config('openapikey.diffDuration')) {

                return response()->json([
                    'result' => null,
                    'statusCode' => 40101,
                    'message' => trans('message.tokenExpire')
                ]);
            }
        } else{
            return response()->json([
                'result' => null,
                'statusCode' => 40101,
                'message' => trans('message.tokenInvalidOrExpire')
            ],401);

        }
        return $next($request);
    }
}
