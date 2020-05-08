<?php

namespace App\Console\Commands\Services;
use App\Author;
use App\Post;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;

class UpdateNewsService {
    public function handle()
    {
        try {
            $host_url = 'https://yandex.ru';
            $html = Http::get($host_url . '/news')->body();
            $crawler = new Crawler($html);
            $news = $crawler->filter('.story');

            if ($news) {
                DB::table('posts')->truncate();
                DB::table('authors')->truncate();
            }

            foreach ($news as $story) {
                $crawler = new Crawler($story);
                $post_annot_uri = $crawler->filter('.story__title a.link')->attr('href');
                $annot_html = Http::get($host_url . $post_annot_uri)->body();
                $annot_crawler = new Crawler($annot_html);
                $annot_crawler = $annot_crawler->filter('.story__annot, .news-story');
                $post_title = $annot_crawler->filter('.story__head-wrap,
                        .news-story__title')->text();
                $post_content = $annot_crawler->filter('.story__main .doc__text,
                        .news-story__content')->text();
                $post_source_url = $annot_crawler->filter('.story__main a.link,
                        .news-story__content a.link')->first()->link()->getUri();
                $post_image_url = !strstr($crawler->attr('class'), 'story_view_short')
                    ? $crawler->filter('.story__image img, .story__image iframe')->first()->attr('src')
                    : null;
                $author_name = $annot_crawler->filter('.story__head-agency,
                        .news-story__subtitle .news-story__subtitle-text')->text();
                preg_match("/https?:\/\/[a-z]*.?[a-z0-9.\-]+.[a-z]+\//i",
                    $post_source_url, $matches, PREG_UNMATCHED_AS_NULL);

                if ($matches == null) {
                    print "Failed to parse author URL: No matches " . $post_source_url;
                    continue;
                }

                $author_site_url = $matches[0];
                $author = Author::where('name', $author_name)->first();

                if (!$author) {
                    $author = new Author;
                    $author->name = $author_name;
                    $author->url = $author_site_url;
                    $author->save();
                }

                $author->posts()->where('title', $post_title)->existsOr(
                    function () use
                    ($author, $post_title, $post_content, $post_image_url, $post_source_url) {
                        $post = new Post;
                        $post->title = $post_title;
                        $post->content = $post_content;
                        $post->image_url = $post_image_url;
                        $post->source_url = $post_source_url;
                        $post->author_id = $author->id;
                        $post->save();
                    }
                );
            }

            if (env('APP_ENV') == 'dev') {
                $authors = Author::all();
                foreach ($authors as $author) {
                    $posts = $author->posts;

                    print 'Author name=: ' . $author->name . PHP_EOL .
                        "Author Id=" . $author->id . PHP_EOL .
                        "Post count=" . $posts->count() . PHP_EOL;

                    foreach ($posts as $post) {
                        print "\tTitle: " . $post->title . PHP_EOL .
                            "\tContent: " . $post->content . PHP_EOL .
                            "\tAuthor ID: " . $post->author_id . PHP_EOL .
                            "\tURL: " . $post->source_url . PHP_EOL;
                    }
                }
            }
        } catch(Exception $e) {
            echo "Failed to update newspaper database from source. Reason: \r\n" . $e->getMessage();
            return false;
        }

        return true;
    }
}
