<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Session\TokenMismatchException;

class VerifyCsrfToken
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * Misalnya: API, webhook, Midtrans callback, dll.
     *
     * @var array<int, string>
     */
    protected $except = [
        'midtrans/callback',
    ];


    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next): Response
    {
        // Jika route masuk dalam pengecualian, lewati token csrf
        foreach ($this->except as $except) {
            if ($request->is($except)) {
                return $next($request);
            }
        }

        // Validasi token
        if ($request->method() !== 'GET' && $this->tokensMismatch($request)) {
            throw new TokenMismatchException('CSRF token mismatch.');
        }

        return $next($request);
    }

    /**
     * Cek apakah token tidak cocok.
     */
    protected function tokensMismatch($request): bool
    {
        $token = $request->session()->token();        // token yang tersimpan di session
        $input = $request->input('_token') ?? $request->header('X-CSRF-TOKEN'); // token dari request

        return ! is_string($input) || ! hash_equals($token, $input);
    }
}
