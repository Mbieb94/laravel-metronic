<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class LogsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, $response) {
        $url = $request->fullUrl();
        $ip = $request->ip();

        if($request->method() == 'GET') return;

        $data = [
            'ip'         => $ip,
            'url'        => $url,
            'method'     => $request->method(),
            'request'    => json_encode($request->all()),
            'response'   => $response->getStatusCode(),
            'created_by' => auth()->user() ? auth()->user()->id : NULL,
            'updated_by' => auth()->user() ? auth()->user()->id : NULL,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        DB::table('logs')->insert($data);
    }
}
