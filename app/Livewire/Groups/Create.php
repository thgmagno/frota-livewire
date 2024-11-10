<?php

namespace App\Livewire\Groups;

use App\Models\Group;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Create extends Component
{
    public string $name = '';

    protected array $rules = [
        'name' => ['required', 'string', 'min:3', 'max:30', 'unique:groups,name'],
    ];

    public function render(): Factory|View|Application
    {
        return view('livewire.groups.create');
    }

    public function save(): void
    {
        $validated = $this->validate();

        Group::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
        ]);

        $this->reset('name');
    }
}
