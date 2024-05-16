<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Collection
    {
        $posts = Post::query()->select('id', 'title', 'created_at', 'user_id')
            ->with(['user' => function ($query) {
                $query->select('id', 'name');
            }]);
        // TODO filters
        return new Collection($posts->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $post = Post::forceCreate($request->all());
        return response()->json($post, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $iPostId): JsonResponse
    {
        return response()->json(
            Post::with([
                'user' => function ($query) {
                    $query->select('id', 'name');
                },
                'comments' => function ($query) {
                    $query->with(['user' => function ($query) {
                        $query->select('id', 'name');
                    }]);
                },
            ])->find($iPostId)
        );
    }

    /**
     * Update the specified resource in storage.
     * @throws Exception
     */
    public function update(Request $request, Post $post): JsonResponse
    {
        $this->checkOwnership($post);
        $post->update($request->all());
        return response()->json($post);
    }

    /**
     * Simulate authentication via user 1
     * @throws Exception
     */
    private function checkOwnership(Post $post): void
    {
        if ($post->user_id != 1){
            throw new Exception('', 403);
        }
    }
}
