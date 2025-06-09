<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class CheckManajemen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response{

        // ambil jwt di session nya
        $token = Session::get('jwt');

        if(!$token){
            return $this->redirectToLogin("Anda harus login terlebih dahulu");
        }

        // ambil data payload dari tokennya
        $payload = JWTAuth::setToken($token)->getPayload();
        // ambil level admin/user
        $level = $payload->get('level');

        // cek apakah levelnya admin?
        $cekLevel = $level === 'Administrator' || $level === 'Manajemen';


        if(!$cekLevel){
            return $this->redirectToLogin("Silahkan login sebagai Admin/Manajemen");
        }

        return $next($request);
    }

    private function redirectToLogin($message){
        return redirect()->route('auth.index')->withErrors($message);
    }
}
