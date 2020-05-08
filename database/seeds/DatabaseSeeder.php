<?php

use App\Author;
use App\Comment;
use App\Like;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Author::class, 15)->create()->each(function ($author) {
            factory(Post::class, rand(1, 3))->make()->each(
                function ($post) use ($author) {
                    $post->author_id = $author->id;
                    $post->save();

                    factory(User::class, rand(1, 5))->create()->each(
                        function ($user) use ($post) {
                            $is_liked = rand(0, 1);

                            if ($is_liked) {
                                $like = new Like;
                                $like->post_id = $post->id;
                                $like->user_id = $user->id;
                                $like->save();
                            }

                            factory(Comment::class, rand(1, 3))->make()->
                                each(function(Comment $comment) use ($user, $post) {
                                    $comment->post_id = $post->id;
                                    $comment->user_id = $user->id;
                                    $comment->save();
                            });
                    });
            });
        });
    }
}
