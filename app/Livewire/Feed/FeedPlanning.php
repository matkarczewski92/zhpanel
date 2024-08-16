<?php

namespace App\Livewire\Feed;

use App\Models\Feed;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class FeedPlanning extends Component
{
    public $order = [];
    public $orders = [
        'price'
    ];
    public $text = "";
    public $sum;

    #[On('receipt')]
    public function render()
    {
        $this->planning();
        return view('livewire.feed.feed-planning', [
            'feed' => Feed::all(),
        ]);
    }

    public function planning()
    {
        $this->sum = 0;
        $leadTime = systemConfig('feedLeadTime');
        $feed = Feed::all();
        foreach ($feed as $f) {
            if ($f->animalsFeed?->where('animal_category_id', '<>', '5')->where('animal_category_id', '<>', '3')->count() > 0) $dk = $this->order[$f->id]['dk'] = floor($f->amount / $f->animalsFeed?->where('animal_category_id', '<>', '5')->where('animal_category_id', '<>', '3')->count());
            else $dk = 0;
            $dZ = ($dk > 0) ? Carbon::now()->addDays($dk * $f->feeding_interval - $leadTime)->format("Y-m-d") : '';
            $this->order[$f->id]['dz'] = $dZ;
            if (!empty($this->order[$f->id]['qty']) and $this->order[$f->id]['qty'] > 0) {
                $this->order[$f->id]['price'] = $price = $this->order[$f->id]['qty'] * $f->last_price;
                $this->order[$f->id]['ndk'] = ($f->animalsFeed?->where('animal_category_id', '<>', '5')->where('animal_category_id', '<>', '3')->count() > 0) ? $ndk = floor(($f->amount + $this->order[$f->id]['qty']) / $f->animalsFeed?->where('animal_category_id', '<>', '5')->where('animal_category_id', '<>', '3')->count()) : '';
                $this->order[$f->id]['ndz'] = ($f->animalsFeed?->where('animal_category_id', '<>', '5')->where('animal_category_id', '<>', '3')->count() > 0) ? Carbon::now()->addDays($ndk * $f->feeding_interval - $leadTime)->format("Y-m-d") : '';
                $this->sum += $price;
            }
        }
    }
}
