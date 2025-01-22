<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Services\GuardianService;
use App\Services\NewsService;
use App\Services\NewYorkTimesService;
use Illuminate\Console\Command;

class GetNewsArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-news-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news articles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $categories = Category::whereNotNull('parent_id')->get();
        foreach ($categories as $category) {
            (new newYorkTimesService())->saveNewsData($category);
            (new newsService())->saveNewsData($category);
            (new guardianService())->saveNewsData($category);
        }
    }

}
