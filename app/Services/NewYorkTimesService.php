<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class NewYorkTimesService extends BaseService
{
    private $url = 'https://api.nytimes.com/svc/search/v2/articlesearch.json';
    private $apiKey = 'NYT_API_KEY';

    public function fetchNewsData($category)
    {
        $response = Http::get($this->url, [
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
        return Arr::get($newsData, 'response.docs', []);
    }
    public function getArticleSourceName($newsArticle)
    {
        return 'The New York Times';
    }
    public function getArticleUrl($newsArticle)
    {
        return Arr::get($newsArticle, 'web_url');
    }
    public function getArticleAuthorName($newsArticle)
    {
        $fullName = Arr::get($newsArticle, 'byline.person.firstname') . " " . Arr::get($newsArticle, 'byline.person.lastname');
        return substr($fullName, 0, 254);
    }
    public function getArticleTitleName($newsArticle)
    {
        return  substr(Arr::get($newsArticle, 'abstract'), 0,254);
    }
    public function getArticleDescription($newsArticle)
    {
        return Arr::get($newsArticle, 'lead_paragraph');
    }
    public function getArticleImageLink($newsArticle)
    {
        $multimedia = Arr::get($newsArticle, 'multimedia');

        $item = null;
        if (is_array($multimedia)) {
            foreach ($multimedia as $media) {
                if (isset($media['type']) && $media['type'] === 'image') {
                    $item = $media;
                    break; // Stop the loop after finding the first 'image'
                }
            }
        }

        return "https://www.nytimes.com/" . Arr::get($item, 'url');
    }
    public function getArticlePublishedDate($newsArticle)
    {
        return Arr::get($newsArticle, 'pub_date');
    }
}
