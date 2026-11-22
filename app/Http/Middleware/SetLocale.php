<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

/**
 * Applies the visitor's chosen language (English or Bangla) from the session.
 */
class SetLocale
{
    public const SUPPORTED = ['en', 'bn'];

    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->session()->get('locale', config('app.locale'));

        if (in_array($locale, self::SUPPORTED, true)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
