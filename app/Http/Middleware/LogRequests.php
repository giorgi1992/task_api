<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use App\User_tokens;
use App\User_request_logs;

class LogRequests
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
        $request->start = microtime(true);
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $this->log($request, $response);
    }

    protected function log($request, $response)
    {
        $tokenHeader = $request->header('Auth');

        $userToken = User_tokens::where('access_token', $tokenHeader)->first();
        if($userToken) {
            $user = User::where('id', $userToken->user_id)->first();
            if($user) {
                $request_params = json_encode($request->all());
                $data = ['user_id' => $user->id, 'token_id' => $tokenHeader, 'request_method' => $request->getMethod(), 'request_params' => $request_params];

                $user->increment('requests_count');
                $requestLogs = User_request_logs::insert($data);

            }
        }
    }
}