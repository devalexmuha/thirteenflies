<?php

namespace Database\Factories\Traits\Sentences;

use Database\Factories\Data\Sentences\CatalogTexts;

/**
 * Catalog top/bottom SEO text sentences; the data itself lives in Data\Sentences\CatalogTexts.
 */
trait CatalogSentences
{
    protected function seoTextSentences(): array
    {
        return CatalogTexts::get();
    }
}
