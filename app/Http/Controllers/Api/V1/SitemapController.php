<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SitemapGenerator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rule;

class SitemapController extends Controller
{
    /**
     * Every sitemap section the client has to build, with how many pages each one has.
     */
    public function index(SitemapGenerator $sitemapGenerator)
    {
        return JsonResource::collection($sitemapGenerator->index());
    }

    /**
     * One page (?page=) of the ?section= with the slugs and update dates of its active records.
     */
    public function show(Request $request, SitemapGenerator $sitemapGenerator)
    {
        $validated = $request->validate([
            'section' => ['required', Rule::in(array_keys(SitemapGenerator::SECTIONS))],
        ]);

        return JsonResource::collection($sitemapGenerator->show($validated['section']));
    }
}
