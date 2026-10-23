<?php

namespace Database\Factories\Traits\Seo;

use Database\Factories\Data\Sentences\CatalogTexts;
use Database\Factories\Data\Seo\CategoryMetaTags;

/**
 * SEO meta for categories (SeoTemplateType::Category): title, description, h1
 * and the top/bottom texts shown by SeoContentBlock, in every locale.
 * Behavior lives in FillsSeoMeta; the texts come from Factories\Data.
 */
trait FillsCategorySeoMeta
{
    use FillsSeoMeta;

    protected function seoTemplates(): array
    {
        return CategoryMetaTags::get();
    }

    protected function seoTextSentences(): array
    {
        return CatalogTexts::get();
    }
}
