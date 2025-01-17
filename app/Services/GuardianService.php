<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GuardianService extends BaseService
{
    private $url = 'https://content.guardianapis.com/search';
    private $apiKey = 'GUARDIAN_API_KEY';

    public function fetchNewsData($category)
    {
        $response = Http::get($this->url,[
            'api-key' => env($this->apiKey),
            'language' => 'en',
            'begin_date' => Carbon::yesterday()->toDateString(),
            'q' => $category->parentCategory->name . " " . $category->name,
        ]);

        if ($response->failed()) {
            Log::error("Request failed: ". $response->status() . ". message: " . $response->body());
        }

        return $response->json();
    }

    public function getNewsArticles($newsData)
    {
        return Arr::get($newsData, 'response.results', []);
    }
    public function getArticleSourceName($newsArticle)
    {
        return 'The Guardian';
    }
    public function getArticleUrl($newsArticle)
    {
        return Arr::get($newsArticle, 'webUrl');
    }
    public function getArticleAuthorName($newsArticle)
    {
        return substr(Arr::get($newsArticle, 'fields.byline'), 0, 254);
    }
    public function getArticleTitleName($newsArticle)
    {
        return substr(Arr::get($newsArticle, 'fields.headline'), 0, 254);
    }
    public function getArticleDescription($newsArticle)
    {
        return substr(strip_tags(Arr::get($newsArticle, 'fields.body')), 0, 200);
    }
    public function getArticleImageLink($newsArticle)
    {
        return Arr::get($newsArticle, 'fields.thumbnail');
    }
    public function getArticlePublishedDate($newsArticle)
    {
        return Arr::get($newsArticle, 'webPublicationDate');
    }
}
