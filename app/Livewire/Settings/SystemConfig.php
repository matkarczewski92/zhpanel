<?php

namespace App\Livewire\Settings;

use App\Models\SystemConfig as ModelsSystemConfig;
use Livewire\Component;

class SystemConfig extends Component
{
    public $key, $name, $value;
    public $editName, $editValue, $editId;

    protected $rules = [
        'key' => 'required',
        'name' => 'required',
        'value' => 'required',
    ];
    protected $messages = [
        'key.required' => 'Pole klucz nie może pozostać puste',
        'name.required' => 'Pole nazwa nie może pozostać puste',
        'value.required' => 'Pole wartość nie może pozostać puste',
    ];


    public function render()
    {
        return view('livewire.settings.system-config', [
            'settings' => ModelsSystemConfig::all(),
        ]);
    }

    public function addConfig()
    {
        $this->validate();

        $sys = new ModelsSystemConfig();
        $sys->key = $this->key;
        $sys->name = $this->name;
        $sys->value = $this->value;
        $sys->save();
        $this->reset('key');
        $this->reset('name');
        $this->reset('value');
    }

    public function editShow(int $id)
    {
        $sysEdit = ModelsSystemConfig::find($id);
        $this->editId = $sysEdit->id;
        $this->editName = $sysEdit->name;
        $this->editValue = $sysEdit->value;
    }
    public function update(int $id)
    {
        $sysEdit = ModelsSystemConfig::find($id);
        $sysEdit->name = $this->editName;
        $sysEdit->value = $this->editValue;
        $sysEdit->save();
        $this->editId = '';
    }
}
