<?php

namespace App\Services;

use App\Models\Comment;

class CommentService extends BaseService
{
    public function __construct(Comment $comment)
    {
        $this->model = $comment;
    }
}
