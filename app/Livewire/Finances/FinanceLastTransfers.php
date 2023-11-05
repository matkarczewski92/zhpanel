<?php

namespace App\Livewire\Finances;

use App\Models\Finances;
use App\Models\FinancesCategory;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class FinanceLastTransfers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $editId = '';
    public $hide, $filterType, $filterCat, $filterName, $filterAmountFrom, $filterAmountTo, $filterDateFrom, $filterDateTo;

    #[On('render')]
    public function render()
    {
        return view('livewire.finances.finance-last-transfers', [
            'transfers' => $this->filter(),
            'categories' => FinancesCategory::all(),
        ]);
    }

    public function delete(int $id)
    {
        Finances::find($id)->delete();
        session()->flash('finances', 'Pozycja  została usunięta ');
        session()->flash('financesColor', 'danger');
    }

    public function showEdit(int $id)
    {
        $this->editId = ($this->editId == '') ? $id : '';
    }

    #[On('hide')]
    public function test($hide = '')
    {
        if ($hide != '') $this->editId = '';
    }

    public function filter()
    {
        $type = (empty($this->filterType)) ? ['type', '!=', $this->filterType] : ['type', '=', $this->filterType];
        $cat = (empty($this->filterCat)) ? ['finances_category_id',  '!=', $this->filterCat] : ['finances_category_id',  '=', $this->filterCat];
        $name = (empty($this->filterName)) ? ['title',  '!=', $this->filterName] : ['title',  'LIKE', '%' . $this->filterName . '%'];
        $amountFrom = (empty($this->filterAmountFrom)) ? 0 : $this->filterAmountFrom;
        $amountTo = (empty($this->filterAmountTo)) ? 99999 : $this->filterAmountTo;
        $dateFrom = (empty($this->filterDateFrom)) ? '0000-01-01' : $this->filterDateFrom;
        $dateTo = (empty($this->filterDateTo)) ? '2999-01-01' : $this->filterDateTo;

        $transfers = Finances::orderBy('created_at', 'desc')
            ->where([$type, $cat, $name])
            ->whereBetween('amount', [$amountFrom, $amountTo])
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->paginate(15);

        return $transfers;
    }
    public function resetFilters()
    {
        $this->reset();
    }
}
