<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
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

    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('published_at', [$request->date_from, $request->date_to]);
        }

        if ($request->has('source_name')) {
            $query->whereHas('source', function($q) use ($request) {
                $q->where('name', $request->source_name);
            });
        }

        if ($request->has('author_name')) {
            $query->whereHas('author', function($q) use ($request) {
                $q->where('name', $request->author_name);
            });
        }

        if ($request->has('category_name')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('name', $request->category_name);
            });
        }

        $articles = $query->with(['source', 'author', 'categories'])->paginate(10);

        return ArticleResource::collection($articles);
    }

}
