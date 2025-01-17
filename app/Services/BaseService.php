<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Source;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

abstract class BaseService
{
    abstract protected function fetchNewsData($category);
    abstract protected function getNewsArticles($newsData);
    abstract protected function getArticleSourceName($newsArticle);
    abstract protected function getArticleTitleName($newsArticle);
    abstract protected function getArticleAuthorName($newsArticle);
    abstract protected function getArticleDescription($newsArticle);
    abstract protected function getArticleImageLink($newsArticle);
    abstract protected function getArticlePublishedDate($newsArticle);
    private function shouldSkipArticle($articleSourceName, $articleUrl)
    {
        return !$articleSourceName || Str::contains($articleSourceName, 'Removed') || !preg_match('/^(https:\/\/.+?)\//', $articleUrl);
    }
    public function saveNewsData($category) {
        $newsData = $this->fetchNewsData($category);
        $newsArticles = $this->getNewsArticles($newsData);

        foreach ($newsArticles as $newsArticle) {
            $articleSourceName = $this->getArticleSourceName($newsArticle);
            $articleUrl = $this->getArticleUrl($newsArticle);

            if ($this->shouldSkipArticle($articleSourceName, $articleUrl)) {
                continue;
            }

            $parsedUrl = parse_url($articleUrl);
            $sourceUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];

            $source = Source::where('name',$articleSourceName)->first();
            if (!$source) {
                $source = new Source();
                $source->name = $articleSourceName;
                $source->website = $sourceUrl;
                $source->save();
            }

            $article = Article::where('news_link',$articleUrl)->first();
            if (!$article) {
                $articleData = [
                    'name' => $this->getArticleTitleName($newsArticle),
                    'reporter' => $this->getArticleAuthorName($newsArticle),
                    'description' => $this->getArticleDescription($newsArticle),
                    'news_link' => $articleUrl,
                    'img_link' => $this->getArticleImageLink($newsArticle),
                    'published_at' => $this->getArticlePublishedDate($newsArticle),
                    'source_id' => $source->id
                ];

                if (count(array_filter($articleData)) !== count($articleData)) {
                    continue;
                }
                $article = Article::create($articleData);
            }

            $article->categories()->syncWithoutDetaching([$category->id]);
            Log::info("Success");
        }
    }
}
