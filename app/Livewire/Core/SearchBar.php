<?php

namespace App\Livewire\Core;

use App\Models\Animal;
use App\Models\Litter;
use Livewire\Component;

class SearchBar extends Component
{
    public $query;
    public $contacts;
    public $highlightIndex;
    public $category;

    public function mount()
    {
        $this->resetData();
    }

    public function resetData()
    {
        $this->query = '';
        $this->contacts = [];
        $this->highlightIndex = 0;
        $this->category = 'I';
    }

    public function incrementHighlight()
    {
        if ($this->highlightIndex === count($this->contacts) - 1) {
            $this->highlightIndex = 0;

            return;
        }
        ++$this->highlightIndex;
    }

    public function decrementHighlight()
    {
        if ($this->highlightIndex === 0) {
            $this->highlightIndex = count($this->contacts) - 1;

            return;
        }
        --$this->highlightIndex;
    }

    public function selectContact()
    {
        $contact = $this->contacts[$this->highlightIndex] ?? null;
        if ($contact) {
            $this->redirect(route('animal.profile', $contact['id']));
        }
    }

    public function updatedCategory()
    {
        $this->highlightIndex = 0;
        $this->updatedQuery();
    }

    public function updatedQuery()
    {
        $fn = ($this->category == '') ? substr($this->query, 0, 2) : '/'.$this->category;
        $query = ($this->category == '') ? explode(' ', $this->query)[1] ?? '' : $this->query;

        if ($fn == '/M') {
            $this->contacts = Litter::where('litter_code', 'like', '%'.$query.'%')
            ->get()
            ->toArray();
        } elseif ($fn == '/N') {
            $this->contacts = Animal::where('name', 'like', '%'.$query.'%')
                ->where('animal_category_id', 2)
                ->get()
                ->toArray();
        } elseif ($fn == '/I') {
            $this->contacts = Animal::where('id', 'like', '%'.$query.'%')
                ->get()
                ->toArray();
        } elseif ($fn == '/S') {
            $this->contacts = Animal::where('name', 'like', '%'.$query.'%')
                ->where('animal_category_id', 3)
                ->get()
                ->toArray();
        } elseif ($fn == '/H') {
            $this->contacts = Animal::where('name', 'like', '%'.$query.'%')
                ->where('animal_category_id', 1)
                ->get()
                ->toArray();
        } else {
            $this->contacts = Animal::where('name', 'like', '%'.$this->query.'%')
                ->get()
                ->toArray();
        }
    }

    public function render()
    {
        return view('livewire.core.search-bar');
    }
}
