<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response{
        $token = Session::get('jwt');

        if(!$token){
            return $this->redirectToLogin("Anda harus login terlebih dahulu");
        }

        $payload = JWTAuth::setToken($token)->getPayload();
        $validity = $payload->get('exp');
        $expiration = Carbon::createFromTimestamp($validity);

        $cekValidity = Carbon::now()->greaterThan($expiration);

        if($cekValidity){
            return $this->redirectToLogin("Sesi telah berakhir, silakan login kembali");
        }

        $request->attributes->set('payload', $payload);
        return $next($request);
    }

    private function redirectToLogin($message){
        return redirect()->route('auth.index')->withErrors($message);
    }
}
