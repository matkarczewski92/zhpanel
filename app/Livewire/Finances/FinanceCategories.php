<?php

namespace App\Livewire\Finances;

use App\Models\Finances;
use App\Models\FinancesCategory;
use Livewire\Component;

class FinanceCategories extends Component
{
    public $editId, $editName, $editIdNew, $name;

    public function render()
    {
        return view('livewire.finances.finance-categories', [
            'financesCategory' => FinancesCategory::all(),
        ]);
    }

    public function editShow(int $id)
    {
        $categoryEdit = FinancesCategory::find($id);
        $this->editName = $categoryEdit->name;
        $this->editId = $id;
        $this->editIdNew = $id;
    }

    public function store()
    {
        FinancesCategory::create(['name' => $this->name]);
        session()->flash('financesCategory', 'Pozycja ' . $this->name . ' została dodana');
        session()->flash('financesCategoryColor', 'success');
        $this->reset();
    }
    public function update()
    {
        $categoryEdit = FinancesCategory::find($this->editId);
        if ($this->editName != '') {
            $categoryEdit->name = $this->editName;
            $categoryEdit->id = $this->editIdNew;
            $categoryEdit->save();
            session()->flash('financesCategory', 'Pozycja ' . $this->editName . ' została edytowana');
            session()->flash('financesCategoryColor', 'warning');
            $this->dispatch('render')->to(FinanceLastTransfers::class);
            $this->dispatch('render')->to(FinanceCreateTransaction::class);
            $this->reset();
        }
    }

    public function delete(int $id)
    {
        $financesCount = Finances::where('finances_category_id',  $id)->count();

        if ($financesCount == 0) {
            $category = FinancesCategory::find($id);
            $category->delete();
            session()->flash('financesCategory', 'Pozycja  została usunięta');
            session()->flash('financesCategoryColor', 'danger');
            $this->dispatch('render')->to(FinanceLastTransfers::class);
            $this->dispatch('render')->to(FinanceCreateTransaction::class);
        } else {
            session()->flash('financesCategory', 'Pozycja nie została usunięta - istnieją pozycje zawierające tę kategorie.');
            session()->flash('financesCategoryColor', 'warning');
        }
    }
}
