<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $comment = Comment::forceCreate($request->all());
        return response()->json($comment, 201);
    }

    /**
     * Update the specified resource in storage.
     * @throws Exception
     */
    public function update(Request $request, Comment $comment): JsonResponse
    {
        $this->checkOwnership($comment);
        $comment->update($request->all());
        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     * @throws Exception
     */
    public function destroy(Comment $comment): JsonResponse
    {
        $this->checkOwnership($comment);
        $comment->delete();
        return response()->json(null, 204);
    }

    /**
     * Simulate authentication via user 1
     * @throws Exception
     */
    private function checkOwnership(Comment $comment): void
    {
        if ($comment->user_id != 1){
            throw new Exception('', 403);
        }
    }
}
