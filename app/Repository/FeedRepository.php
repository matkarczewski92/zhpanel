<?php

namespace App\Repository;

use App\Interfaces\FeedRepositoryInterface;
use App\Models\Feed;

class FeedRepository implements FeedRepositoryInterface
{
    public function all()
    {
        return Feed::all();
    }

    public function getById(int $feedId)
    {
        return Feed::findOrFail($feedId);
    }
}
