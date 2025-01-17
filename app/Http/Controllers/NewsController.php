<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\GuardianService;
use App\Services\NewsService;
use App\Services\NewYorkTimesService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    private $newsService;
    private $newYorkTimesService;
    private $guardianService;
    public function __construct(NewsService $newsService, NewYorkTimesService $newYorkTimesService, GuardianService $guardianService)
    {
        $this->newsService = $newsService;
        $this->newYorkTimesService = $newYorkTimesService;
        $this->guardianService = $guardianService;
    }

    public function fetchNews()
    {
        $categories = Category::whereNotNull('parent_id')->take(1)->get();
        foreach ($categories as $category) {
            ($this->newYorkTimesService)->saveNewsData($category);
            ($this->newsService)->saveNewsData($category);
            ($this->guardianService)->saveNewsData($category);
        }
    }
}
