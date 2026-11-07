<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RedirectResource;
use App\Models\Seo\Redirect;
use Illuminate\Http\Request;

class RedirectsController extends Controller
{
    /**
     * Every active redirect, so the client can keep the list and check paths itself.
     */
    public function index()
    {
        $redirects = Redirect::query()
            ->active()
            ->get();

        return RedirectResource::collection($redirects);
    }

    /**
     * Where the client should send a visitor who opened ?path=..., or 404 when there is no redirect for it.
     */
    public function show(Request $request)
    {
        $validated = $request->validate([
            'path' => ['required', 'string', 'max:500'],
        ]);

        // /old-page and /old-page/ are the same page
        $path = rtrim($validated['path'], '/');

        $redirect = Redirect::query()
            ->active()
            ->whereIn('from_path', [$path, $path.'/'])
            ->firstOrFail();

        $redirect->increment('hits', 1, ['last_hit_at' => now()]);

        return RedirectResource::make($redirect);
    }
}
