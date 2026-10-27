<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageListResource;
use App\Http\Resources\PageResource;
use App\Models\Content\Page;
use App\Services\SeoMetaResolver;

class PagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::query()
            ->active()
            ->with('slug')
            ->orderBy('id')
            ->get();

        return PageListResource::collection($pages);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page, SeoMetaResolver $seoMetaResolver)
    {
        abort_unless($page->is_active, 404);

        $page->load(['slug', 'slugs', 'seoMeta', 'media']);

        $page->setRelation('seoMeta', $seoMetaResolver->resolve($page));

        return PageResource::make($page);
    }
}
