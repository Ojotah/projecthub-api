<?php

namespace App\Services;

use App\Models\Comment;

class CommentService extends BaseService
{
    public function __construct(protected Comment $comment) {}

    public function getModel(): Comment
    {
        return $this->comment;
    }
}
