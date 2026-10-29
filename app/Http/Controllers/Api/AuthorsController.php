<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleListResource;
use App\Http\Resources\AuthorListResource;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\ServiceListResource;
use App\Models\Content\Author;
use App\Services\SeoMetaResolver;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::query()
            ->active()
            ->with(['slug', 'media'])
            ->orderBy('name')
            ->get();

        return AuthorListResource::collection($authors);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author, SeoMetaResolver $seoMetaResolver)
    {
        abort_unless($author->is_active, 404);

        $author->load(['slug', 'slugs', 'seoMeta', 'media']);

        $author->setRelation('seoMeta', $seoMetaResolver->resolve($author));

        return AuthorResource::make($author);
    }

    /**
     * Listing of all articles written by this author
     */
    public function articles(Author $author)
    {
        abort_unless($author->is_active, 404);

        $articles = $author->articles()
            ->active()
            ->with(['slug', 'author.slug', 'media'])
            ->orderByDesc('updated_at')
            ->paginate(12);

        return ArticleListResource::collection($articles);
    }

    /**
     * Listing of all services provided by this author
     */
    public function services(Author $author)
    {
        abort_unless($author->is_active, 404);

        $services = $author->services()
            ->active()
            ->with(['slug', 'author.slug', 'media'])
            ->orderByDesc('updated_at')
            ->paginate(12);

        return ServiceListResource::collection($services);
    }
}
