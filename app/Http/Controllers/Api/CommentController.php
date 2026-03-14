<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index()
    {
        return $this->commentService->all(['user', 'task']);
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $data['user_id'] = auth()->id();

        return $this->commentService->create($data);
    }

    public function show($id)
    {
        return $this->commentService->find($id, ['user', 'task']);
    }

    public function update(Request $request, $id)
    {
        return $this->commentService->update($id, $request->all());
    }

    public function destroy($id)
    {
        return $this->commentService->delete($id);
    }
}
