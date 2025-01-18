<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewsService extends BaseService
{
    private $url = 'https://newsapi.org/v2/everything';
    private $apiKey = 'NEWS_API_KEY';

    public function fetchNewsData($category)
    {
        $response = Http::get($this->url, [
            'apiKey' => env($this->apiKey),
            'language' => 'en',
            'from' => Carbon::yesterday()->toDateString(),
            'q' => $category->parentCategory->name . " " . $category->name,
        ]);

        if ($response->failed()) {
            Log::error("Request failed: ". $response->status() . ". message: " . $response->body());
            return [];
        }

        return $response->json();
    }
    public function getNewsArticles($newsData)
    {
        return Arr::get($newsData,'articles',[]);
    }
    public function getArticleSourceName($newsArticle)
    {
        return Arr::get($newsArticle, 'source.name');
    }
    public function getArticleUrl($newsArticle)
    {
        return Arr::get($newsArticle, 'url');
    }
    public function getArticleAuthorName($newsArticle)
    {
        return substr(Arr::get($newsArticle, 'author'), 0, 254);
    }
    public function getArticleTitleName($newsArticle)
    {
        return substr(Arr::get($newsArticle, 'title'), 0, 254);
    }
    public function getArticleDescription($newsArticle)
    {
        return Arr::get($newsArticle, 'description');
    }
    public function getArticleImageLink($newsArticle)
    {
        return Arr::get($newsArticle, 'urlToImage');
    }
    public function getArticlePublishedDate($newsArticle)
    {
        return Arr::get($newsArticle, 'publishedAt');
    }
}
