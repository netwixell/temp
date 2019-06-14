<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

use App\Post;

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
    protected $description = 'Generate the sitemap.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $sitemap = Sitemap::create()
      ->add(Url::create('/')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
      ->add(Url::create('/dream-team')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
      ->add(Url::create('/dream-team/rules')->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
      ->add(Url::create('/privacy')->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY))
      ->add(Url::create('/recreation')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
      ->add(Url::create('/schedule')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
      ->add(Url::create('/throwback')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
      ->add(Url::create('/news')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

      $news = Post::published()->latest()->take(300)->get();

      $news->each(function($post) use ($sitemap){
        $sitemap->add(Url::create("/news/{$post->slug}")->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
      });

      $sitemap->writeToFile(public_path('sitemap.xml'));

    }
}
