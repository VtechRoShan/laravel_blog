<?php

namespace App\Console\Commands;

use App\Models\Blog;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/'));

        Blog::get()->each(function (Blog $post) use ($sitemap) {
            $sitemap->add(
                Url::create("{$post->slug}")
                    ->setLastModificationDate(Carbon::create($post->updated_at ?? $post->created_at))
                    ->setPriority(0.6)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        Category::get()->each(function (Category $post) use ($sitemap) {
            $sitemap->add(
                Url::create("{$post->slug}")
                    ->setLastModificationDate(Carbon::create($post->updated_at ?? $post->created_at))
                    ->setPriority(0.8)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
