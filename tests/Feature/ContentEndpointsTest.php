<?php

use App\Models\Content\Article;
use App\Models\Content\Author;
use App\Models\Content\Page;
use App\Models\Content\Service;
use App\Models\Seo\SeoTemplate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

/**
 * A content record with an english slug and an SEO meta row, like the seeders create them.
 *
 * @param  class-string<Model>  $model
 * @param  array<string, mixed>  $attributes
 */
function contentRecord(string $model, string $slug, array $attributes = []): Model
{
    $record = $model::factory()->create($attributes);
    $record->slugs()->create(['locale' => 'en', 'slug' => $slug]);
    $record->seoMeta()->create(['h1' => ['en' => "{$slug} h1"]]);

    return $record;
}

dataset('content', [
    'articles' => ['articles', Article::class, ['name' => ['en' => 'Guide']]],
    'authors' => ['authors', Author::class, ['name' => 'Zachary']],
    'services' => ['services', Service::class, ['name' => ['en' => 'Setup']]],
    'pages' => ['pages', Page::class, ['name' => ['en' => 'About']]],
]);

// ---- every content route ----------------------------------------------------------------------

it('lists published records with their slug on /api/{route}', function (string $route, string $model, array $attributes) {
    contentRecord($model, 'first', $attributes);
    contentRecord($model, 'second', $attributes);

    $this->getJson("/api/{$route}")
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonFragment(['slug' => 'first'])
        ->assertJsonFragment(['slug' => 'second']);
})->with('content');

it('hides inactive records in the list', function (string $route, string $model, array $attributes) {
    contentRecord($model, 'visible', $attributes);
    contentRecord($model, 'hidden', $attributes + ['is_active' => false]);

    $this->getJson("/api/{$route}")
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonFragment(['slug' => 'visible'])
        ->assertJsonMissing(['slug' => 'hidden']);
})->with('content');

it('shows one record by slug with slugs and seo on /api/{route}/{slug}', function (string $route, string $model, array $attributes) {
    contentRecord($model, 'my-slug', $attributes);

    $this->getJson("/api/{$route}/my-slug")
        ->assertOk()
        ->assertJsonPath('data.slug.slug', 'my-slug')
        ->assertJsonPath('data.seo.h1', 'my-slug h1')
        ->assertJsonCount(1, 'data.slugs');
})->with('content');

it('answers 404 for an unknown slug and an inactive record', function (string $route, string $model, array $attributes) {
    contentRecord($model, 'hidden', $attributes + ['is_active' => false]);

    $this->getJson("/api/{$route}/nope")
        ->assertNotFound()
        ->assertJson(['message' => 'Sorry dude, there is no data for your request.']);
    $this->getJson("/api/{$route}/hidden")->assertNotFound();
})->with('content');

it('finds a record by the slug of the requested locale', function (string $route, string $model, array $attributes) {
    $record = contentRecord($model, 'about', $attributes);
    $record->slugs()->create(['locale' => 'es', 'slug' => 'sobre-nosotros']);

    $this->getJson("/api/{$route}/sobre-nosotros?locale=es")
        ->assertOk()
        ->assertJsonPath('data.slug.slug', 'sobre-nosotros');

    $this->getJson("/api/{$route}/sobre-nosotros")->assertNotFound();
})->with('content');

// ---- articles ---------------------------------------------------------------------------------

it('lists the newest articles first with the author card and pages of 12', function () {
    $author = contentRecord(Author::class, 'zachary', ['name' => 'Zachary']);
    $old = contentRecord(Article::class, 'old', ['name' => ['en' => 'Old'], 'published_at' => now()->subDays(5), 'author_id' => $author->id]);
    $new = contentRecord(Article::class, 'new', ['name' => ['en' => 'New'], 'published_at' => now()->subDay()]);

    $this->getJson('/api/articles')
        ->assertOk()
        ->assertJsonPath('data.0.slug.slug', 'new')
        ->assertJsonPath('data.1.slug.slug', 'old')
        ->assertJsonPath('data.1.author.name', 'Zachary')
        ->assertJsonPath('data.1.author.slug.slug', 'zachary')
        ->assertJsonPath('data.0.author', null)
        ->assertJsonPath('meta.per_page', 12);
});

it('paginates the articles', function () {
    foreach (range(1, 13) as $number) {
        contentRecord(Article::class, "article-{$number}", ['name' => ['en' => "Article {$number}"]]);
    }

    $this->getJson('/api/articles')->assertOk()->assertJsonCount(12, 'data')->assertJsonPath('meta.total', 13);
    $this->getJson('/api/articles?page=2')->assertOk()->assertJsonCount(1, 'data');
});

it('shows the article content, excerpt and publish date', function () {
    contentRecord(Article::class, 'guide', [
        'name' => ['en' => 'Guide'],
        'excerpt' => ['en' => '<p>Short</p>'],
        'content' => ['en' => '<p>Long text</p>'],
        'published_at' => '2026-01-15 10:00:00',
    ]);

    $this->getJson('/api/articles/guide')
        ->assertOk()
        ->assertJsonPath('data.name', 'Guide')
        ->assertJsonPath('data.excerpt', '<p>Short</p>')
        ->assertJsonPath('data.content', '<p>Long text</p>')
        ->assertJsonStructure(['data' => ['published_at', 'author', 'media']]);
});

// ---- authors ----------------------------------------------------------------------------------

it('shows the author profile with position, bios and social links', function () {
    contentRecord(Author::class, 'zachary', [
        'name' => 'Zachary',
        'position' => ['en' => 'Pianist'],
        'short_bio' => ['en' => 'Short'],
        'bio' => ['en' => 'Long'],
        'socials' => [['network' => 'youtube', 'url' => 'https://youtube.com/@zachary']],
    ]);

    $this->getJson('/api/authors/zachary')
        ->assertOk()
        ->assertJsonPath('data.name', 'Zachary')
        ->assertJsonPath('data.position', 'Pianist')
        ->assertJsonPath('data.short_bio', 'Short')
        ->assertJsonPath('data.bio', 'Long')
        ->assertJsonPath('data.socials.0.network', 'youtube');
});

it('fills the seo of an author without an seo meta row from the seo template', function () {
    SeoTemplate::create(['page_type' => 'author', 'h1' => ['en' => 'Articles by {name}']]);
    $author = Author::factory()->create(['name' => 'Zachary']);
    $author->slugs()->create(['locale' => 'en', 'slug' => 'zachary']);

    $this->getJson('/api/authors/zachary')
        ->assertOk()
        ->assertJsonPath('data.seo.h1', 'Articles by Zachary');
});

it('does not fail for a record without an seo meta row and without a seo template', function () {
    $author = Author::factory()->create(['name' => 'Zachary']);
    $author->slugs()->create(['locale' => 'en', 'slug' => 'zachary']);

    $this->getJson('/api/authors/zachary')->assertOk()->assertJsonPath('data.seo.h1', null);
});

it('lists only the published articles of the author on /api/authors/{slug}/articles', function () {
    $author = contentRecord(Author::class, 'zachary', ['name' => 'Zachary']);
    $other = contentRecord(Author::class, 'someone', ['name' => 'Someone']);

    contentRecord(Article::class, 'mine', ['name' => ['en' => 'Mine'], 'author_id' => $author->id]);
    contentRecord(Article::class, 'my-draft', ['name' => ['en' => 'Draft'], 'author_id' => $author->id, 'is_active' => false]);
    contentRecord(Article::class, 'not-mine', ['name' => ['en' => 'Not mine'], 'author_id' => $other->id]);

    $this->getJson('/api/authors/zachary/articles')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slug.slug', 'mine')
        ->assertJsonPath('meta.total', 1);
});

it('lists only the published services of the author on /api/authors/{slug}/services', function () {
    $author = contentRecord(Author::class, 'zachary', ['name' => 'Zachary']);

    contentRecord(Service::class, 'setup', ['name' => ['en' => 'Setup'], 'author_id' => $author->id]);
    contentRecord(Service::class, 'old-service', ['name' => ['en' => 'Old'], 'author_id' => $author->id, 'is_active' => false]);
    contentRecord(Service::class, 'other', ['name' => ['en' => 'Other']]);

    $this->getJson('/api/authors/zachary/services')
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.slug.slug', 'setup');
});

it('answers 404 for the articles and services of an unknown or unpublished author', function () {
    contentRecord(Author::class, 'hidden', ['name' => 'Hidden', 'is_active' => false]);

    $this->getJson('/api/authors/nope/articles')->assertNotFound();
    $this->getJson('/api/authors/hidden/articles')->assertNotFound();
    $this->getJson('/api/authors/hidden/services')->assertNotFound();
});

// ---- services ---------------------------------------------------------------------------------

it('shows the service price, author and content', function () {
    $author = contentRecord(Author::class, 'zachary', ['name' => 'Zachary']);
    contentRecord(Service::class, 'setup', [
        'name' => ['en' => 'Guitar Setup'],
        'content' => ['en' => '<p>We set it up</p>'],
        'price_from' => 68,
        'author_id' => $author->id,
    ]);

    $this->getJson('/api/services/setup')
        ->assertOk()
        ->assertJsonPath('data.name', 'Guitar Setup')
        ->assertJsonPath('data.price_from', 68)
        ->assertJsonPath('data.content', '<p>We set it up</p>')
        ->assertJsonPath('data.author.name', 'Zachary');
});

// ---- pages ------------------------------------------------------------------------------------

it('returns the template of the page', function () {
    contentRecord(Page::class, 'main', ['name' => ['en' => 'Home'], 'template' => 'home']);
    contentRecord(Page::class, 'about-us', ['name' => ['en' => 'About us']]);

    $this->getJson('/api/pages')
        ->assertOk()
        ->assertJsonPath('data.0.template', 'home')
        ->assertJsonPath('data.1.template', 'single');

    $this->getJson('/api/pages/main')->assertOk()->assertJsonPath('data.template', 'home');
});

it('shows the page content', function () {
    contentRecord(Page::class, 'about-us', ['name' => ['en' => 'About us'], 'content' => ['en' => '<p>Hello</p>']]);

    $this->getJson('/api/pages/about-us')
        ->assertOk()
        ->assertJsonPath('data.name', 'About us')
        ->assertJsonPath('data.content', '<p>Hello</p>');
});
