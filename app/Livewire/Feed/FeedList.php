<?php

namespace App\Livewire\Feed;

use App\Models\Feed;
use Livewire\Attributes\On;
use Livewire\Component;

class FeedList extends Component
{

    #[On('receipt')]
    public function render()
    {
        return view('livewire.feed.feed-list', [
            'feed' => Feed::all(),
        ]);
    }
}
