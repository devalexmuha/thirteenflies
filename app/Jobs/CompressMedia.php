<?php

namespace App\Jobs;

use App\Services\ImageCompressor;
use Awcodes\Curator\Models\Media;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CompressMedia implements ShouldQueue
{
    use Queueable;

    public int $tries = 2;

    public int $timeout = 120;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private readonly Media $media
    ){}

    /**
     * Execute the job.
     */
    public function handle(ImageCompressor $compressor): void
    {
        $compressor->compress($this->media);
    }
}
