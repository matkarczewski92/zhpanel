<?php

namespace App\Livewire\Finances;

use App\Models\Animal;
use App\Models\Feed;
use App\Models\Finances;
use App\Models\FinancesCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class FinanceEditTransfer extends Component
{
    public $financesCategoryId, $amount, $title, $feedId, $animalId, $type, $transferId;
    public $createdAt, $editId, $hide;

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

        $transfer = Finances::find($this->transferId);

        $this->financesCategoryId = $transfer->finances_category_id;
        $this->amount = $transfer->amount;
        $this->title = $transfer->title;
        $this->animalId = $transfer->animal_id;
        $this->type = $transfer->type;
        $this->feedId = $transfer->feed_id;
        $this->createdAt = $transfer->created_at->format("Y-m-d");

        return view('livewire.finances.finance-edit-transfer', [
            'financesCategory' => FinancesCategory::all(),
            'animals' => Animal::all(),
            'feeds' => Feed::all(),
        ]);
    }


    public function edit(int $financesId)
    {
        $this->validate();
        $fC = Finances::find($financesId);
        $fC->finances_category_id = $this->financesCategoryId;
        $fC->amount = $this->amount;
        $fC->title = $this->title;
        $fC->type = $this->type;
        $fC->created_at = $this->createdAt;
        $fC->feed_id = ($this->feedId == '') ? null : $this->feedId;
        $fC->animal_id = ($this->animalId == '') ? null : $this->animalId;
        $fC->save();
        $this->dispatch('render')->to(FinanceLastTransfers::class);
        $this->dispatch('hide', hide: '1')->to(FinanceLastTransfers::class);
        session()->flash('finances', 'Transakcja została edytowana pomyślnie');
        session()->flash('financesColor', 'success');
        $this->reset();
        $this->transferId = $financesId;
    }
}
