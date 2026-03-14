<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Services\CommentService;

class CommentController extends Controller
{
    public function __construct(protected CommentService $commentService) {}

    public function index()
    {
        return $this->commentService->all(['user', 'task']);
    }

    public function store(StoreCommentRequest $request)
    {
        $data = $request->all();

        $data['user_id'] = auth()->id();

        return $this->commentService->create($data);
    }

    public function show($id)
    {
        return $this->commentService->find($id, ['user', 'task']);
    }

    public function update(UpdateCommentRequest $request, $id)
    {
        return $this->commentService->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->commentService->delete($id);
    }
}
