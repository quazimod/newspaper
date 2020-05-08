<?php

use App\Comment;
use App\Like;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('posts', function (Request $request) {
    try {
        if (!$request->post_id) {
             return response(['posts' =>
                Post::with(['comments', 'likes'])->get()], 200);
        } else {
            return response(['post' =>
                Post::with(['comments', 'likes'])->findOrFail($request->post_id)], 200);
        }
    } catch (Exception $e) {
        return response(
            ['error' => 'Failed to load posts: ' . $e->getMessage()], 418
        );
    }
});

Route::get('comments', function (Request $request) {
    try {
        if (!$request->comment_id) {
            return response(['comments' =>
                Comment::with(['user', 'post'])->get()], 200);
        } else {
            return response([
                'comment' => Comment::with(['user', 'post'])->
                    findOrFail($request->comment_id)
            ], 200);
        }
    } catch (Exception $e) {
        return response(
            ['error' => 'Failed to load comments: ' . $e->getMessage()], 418
        );
    }
});

Route::get('likes', function (Request $request) {
    try {
        if (!$request->like_id) {
            return response(['likes' =>
                Like::with(['user', 'post'])->get()], 200);
        } else {
            return response([
                'like' => Like::with(['user', 'post'])->
                findOrFail($request->like_id)
            ], 200);
        }
    } catch (Exception $e) {
        return response(
            ['error' => 'Failed to load likes: ' . $e->getMessage()], 418
        );
    }
});

Route::middleware(['auth:api'])->group(function () {
    Route::middleware('admin')->post('users/setAdmin',
        function (Request $request) {
            try {
                $user = User::findOrFail($request->user_id);

                if ($user->isAdmin()) {
                    response(['message' =>
                        'User has admin rights already.' . $user->id], 200);
                }

                $user->is_admin = true;
                $user->save();

                return response(
                    ['message' => 'Admin rights success added to user #' . $user->id], 200);
            } catch(Exception $e) {
                return response(
                    ['error' => 'Failed to create post: ' . $e->getMessage()], 418
                );
            }
    });

    Route::post('posts/add', function (Request $request) {
        try {
            if (!Auth::user()->can('create', Post::class)) {
                throw new Exception('Authorization failed.');
            }

            $post = new Post;
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->image_url = $request->input('image_url');
            $post->source_url = $request->input('source_url');
            $post->author_id = $request->input('author_id');
            $post->save();

            return response([
                'message' => 'Post success created #' . $post->id
            ], 200);
        } catch (Exception $e) {
            return response(
                ['error' => 'Failed to create post: ' . $e->getMessage()], 418
            );
        }
    });

    Route::post('posts/update', function (Request $request) {
        try {
            $post = Post::findOrFail($request->post_id);

            if (!Auth::user()->can('update', $post)) {
                throw new Exception('Authorization failed.');
            }

            $post->title = $request->input('title');
            $post->content = $request->input('content');
            $post->image_url = $request->input('image_url');
            $post->source_url = $request->input('source_url');
            $post->author_id = $request->input('author_id');

            if ($post->isClean())
                return response(['message' => 'Nothing to update.']);

            $post->save();

            return response([
                'message' => 'Post#' . $post->id . ' success updated.',
                'post' => $post], 200);

        } catch (Exception $e) {
            return response(
                ['error' => 'Failed to update post: ' . $e->getMessage()], 418
            );
        }
    });

    Route::post('posts/delete', function (Request $request) {
        try {
            $post = Post::findOrFail($request->post_id);

            if (Auth::user()->can('delete', $post)) {
                $post->delete();
            }

            return response(['message' => 'Post#' . $post->id . ' was deleted!'], 200);
        } catch (Exception $e) {
            return response(
                ['error' => 'Failed to delete post: ' . $e->getMessage()], 418
            );
        }
    });

    Route::post('comments/add', function (Request $request) {
        try {
            $comment = new Comment;
            $comment->text = $request->input('text');
            $comment->post_id = $request->input('post_id');
            $comment->user_id = Auth::user()->id;
            $comment->user_comment_id = $request->input('user_comment_id');
            $comment->save();

            return response([
                'message' => 'Comment success created #' . $comment->id,
                'comment' => $comment,
            ], 200);
        } catch (Exception $e) {
            return response(
                ['error' => 'Failed to add comment: ' . $e->getMessage()], 418
            );
        }
    });

    Route::post('comments/update', function (Request $request) {
        try {
            $comment = Comment::findOrFail($request->comment_id);
            $comment->text = $request->text;
            $comment->user_id = $request->user_id;
            $comment->post_id = $request->post_id;
            $comment->user_comment_id = $request->user_comment_id;

            if ($comment->isClean())
                return response(['message' => 'Nothing to update.']);

            $comment->save();

            return response([
                'message' => 'Comment#' . $comment->id . ' success updated',
                'comment' => $comment], 200);
        } catch (Exception $e) {
            return response(
                ['error' => 'Failed to update comment: ' . $e->getMessage()], 418
            );
        }
    });

    Route::post('comments/delete', function (Request $request) {
        try {
            $comment = Comment::findOrFail($request->comment_id);
            $comment->delete();

            return response('Comment#' . $comment->id . ' was deleted!', 200);
        } catch (Exception $e) {
            return response(
                ['error' => 'Failed to delete comment: ' . $e->getMessage()], 418
            );
        }
    });

    Route::post('likes/add', function (Request $request) {
        try {
            if (Auth::user()->likes->firstWhere('post_id', $request->post_id)) {
                throw new Exception('User already liked this post.');
            }

            $like = new Like;
            $like->post_id = $request->input('post_id');
            $like->user_id = Auth::user()->id;
            $like->save();

            return response([
                'message' => 'Like success created #' . $like->id,
                'like' => $like,
            ], 200);
        } catch (Exception $e) {
            return response(
                ['error' => 'Failed to add like: ' . $e->getMessage()], 418
            );
        }
    });

    Route::post('likes/remove', function (Request $request) {
        try {
            $like = Auth::user()->likes->firstWhere('post_id', $request->post_id);

            if (!$like) {
                throw new Exception('User not liked this post yet.');
            }

            $like->delete();

            return response(['message' => 'Like has been removed!'], 200);
        } catch (Exception $e) {
            return response(
                ['error' => 'Failed to remove like: ' . $e->getMessage()], 418
            );
        }
    });
});
