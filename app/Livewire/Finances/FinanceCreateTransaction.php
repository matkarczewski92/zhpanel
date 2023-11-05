<?php

namespace App\Livewire\Finances;

use App\Models\Animal;
use App\Models\Feed;
use App\Models\Finances;
use App\Models\FinancesCategory;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;

class FinanceCreateTransaction extends Component
{
    public $financesCategoryId, $amount, $title, $feedId, $animalId, $type;
    public $createdAt;

    protected $rules = [
        'financesCategoryId' => 'required',
        'type' => 'required',
    ];
    protected $messages = [
        'financesCategoryId.required' => 'Wybierz kategorie transakcji',
        'type.required' => 'Wybierz rodzaj transakcji',
    ];

    #[On('render')]
    public function render()
    {



        $this->createdAt = Carbon::now()->format("Y-m-d");
        return view('livewire.finances.finance-create-transaction', [
            'financesCategory' => FinancesCategory::all(),
            'animals' => Animal::all(),
            'feeds' => Feed::all(),
        ]);
    }

    public function create()
    {
        $this->validate();
        $fC = new Finances();
        $fC->finances_category_id = $this->financesCategoryId;
        $fC->amount = $this->amount;
        $fC->title = $this->title;
        $fC->type = $this->type;
        $fC->created_at = $this->createdAt;
        if (!empty($this->feedId)) $fC->feed_id = $this->feedId;
        if (!empty($this->animalId)) $fC->animal_id = $this->animalId;
        $fC->save();
        $this->dispatch('render')->to(FinanceLastTransfers::class);
        session()->flash('transactionCreate', 'Transakcja została dodana');
        session()->flash('transactionCreateColor', 'success');
        $this->reset();
        return redirect(request()->header('Referer'));
    }
}
