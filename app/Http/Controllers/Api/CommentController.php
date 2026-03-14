<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Services\CommentService;

class CommentController extends Controller
{
    public function __construct(protected CommentService $commentService) {}

    public function index()
    {
        $comments = $this->commentService->all(['user', 'task']);

        return CommentResource::collection($comments);
    }

    public function store(StoreCommentRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        $comment = $this->commentService->create($data);

        return new CommentResource($comment->loadMissing(['user', 'task']));
    }

    public function show($id)
    {
        $comment = $this->commentService->find($id, ['user', 'task']);

        return new CommentResource($comment);
    }

    public function update(UpdateCommentRequest $request, $id)
    {
        $comment = $this->commentService->update($id, $request->validated());

        return new CommentResource($comment->loadMissing(['user', 'task']));
    }

    public function destroy($id)
    {
        $this->commentService->delete($id);

        return response()->json([
            'message' => 'Comment deleted successfully',
        ]);
    }
}
