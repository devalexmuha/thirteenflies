<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceListResource;
use App\Http\Resources\ServiceResource;
use App\Models\Content\Service;
use App\Services\SeoMetaResolver;

class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::query()
            ->active()
            ->with(['slug', 'author.slug', 'media'])
            ->orderBy('id')
            ->get();

        return ServiceListResource::collection($services);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service, SeoMetaResolver $seoMetaResolver)
    {
        abort_unless($service->is_active, 404);

        $service->load(['slug', 'slugs', 'seoMeta', 'media', 'author.slug']);

        $service->setRelation('seoMeta', $seoMetaResolver->resolve($service));

        return ServiceResource::make($service);
    }
}
