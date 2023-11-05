<?php

namespace App\Livewire\Feed;

use App\Models\Feed;
use App\Models\Finances;
use Livewire\Attributes\On;
use Livewire\Component;

class FeedReceipt extends Component
{
    public $feedId;
    public $amount;
    public $price;
    public $status;
    public $sum = 0;

    public $receipt = [];


    #[On('receipt')]
    public function render()
    {
        return view('livewire.feed.feed-receipt', [
            'feed' => Feed::where('id', '!=', 0)->get(),
        ]);
    }

    public function addPos()
    {
        if (!empty($this->feedId)) {
            $feed = Feed::find($this->feedId);
            $this->receipt[] = [
                'feedId' => $this->feedId,
                'amount' => $this->amount,
                'price' => $this->price,
                'name' => $feed->name
            ];
            $this->sum += $this->price;
            $this->status = "";
            $this->reset('feedId');
            $this->reset('amount');
            $this->reset('price');
        } else $this->status = "Nie wybrano rodzaju karmy";
    }

    public function remove($value)
    {
        $found_key = array_search($value, array_column($this->receipt, 'feedId'));
        $this->receipt[$found_key]['feedId'] = '';
        $this->sum -=  $this->receipt[$found_key]['price'];
        // unset($this->receipt[$found_key]);
        $this->dispatch('receipt')->to(FeedReceipt::class);
    }

    public function saveReceipt()
    {
        foreach ($this->receipt as $rec) {
            if ($rec['feedId'] != '') {
                $lastPrice = $rec['price'] / $rec['amount'];
                $feed = Feed::find($rec['feedId']);
                $feed->amount += $rec['amount'];
                $feed->last_price = $lastPrice;
                $feed->save();

                $title = "Zakup karmy: $rec[name] - $rec[amount] szt";
                $finance = new Finances();
                $finance->finances_category_id = 1;  // Kategoria id 2 = Karma
                $finance->amount = $rec['price'];
                $finance->title = "$title";
                $finance->feed_id = $rec['feedId'];
                $finance->type = "c";
                $finance->save();



                unset($this->receipt);
                $this->receipt = [];
            }
        }
        $this->sum = 0;
        $this->dispatch('receipt')->to(FeedList::class);
        $this->dispatch('receipt')->to(FeedPlanning::class);
    }
}
