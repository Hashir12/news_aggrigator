<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function fetchNews()
    {
        $url = 'https://newsapi.org/v2/everything';
        $categories = Category::whereNotNull('parent_id')
            ->get();
        foreach ($categories as $category) {
            $response = Http::get($url, [
                'apiKey' => env('NEWS_API_KEY'),
                'language' => 'en',
                'from' => Carbon::yesterday(),
                'q' => $category->parentCategory->name . " " . $category->name,
            ]);
            if ($response->failed()) {
                log::error("Request failed". $response->status());
                return;
            }

            dump($response->json());

        }
    }
}
