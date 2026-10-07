<?php

namespace App\Http\Middleware;

use App\Enums\Locale;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/*')) {
            $locale = Locale::tryFrom((string) $request->query('locale', 'en'));

            abort_if(! $locale, 422, 'Allowed Locales are '.implode(', ', array_column(Locale::cases(), 'value')));

            app()->setLocale($locale->value);
        }

        return $next($request);
    }
}
