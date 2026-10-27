<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleListResource;
use App\Http\Resources\ArticleResource;
use App\Models\Content\Article;
use App\Services\SeoMetaResolver;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::query()
            ->active()
            ->with(['slug', 'author.slug', 'media'])
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(12);

        return ArticleListResource::collection($articles);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article, SeoMetaResolver $seoMetaResolver)
    {
        abort_unless($article->is_active, 404);

        $article->load(['slug', 'slugs', 'seoMeta', 'media', 'author.slug']);

        $article->setRelation('seoMeta', $seoMetaResolver->resolve($article));

        return ArticleResource::make($article);
    }
}
