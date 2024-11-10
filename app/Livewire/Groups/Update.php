<?php

namespace App\Livewire\Groups;

use App\Models\Group;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Update extends Component
{
    use AuthorizesRequests;

    public string $name = '';
    public Group $group;

    public function mount(Group $group): void
    {
        $this->authorize('update', $group);

        $this->group = $group;

        $this->name = $group->name;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:30',
                Rule::unique('groups')->ignore($this->group->id),
            ],
        ];
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.groups.update');
    }

    public function save(): void
    {
        $validated = $this->validate();

        $this->group->update($validated);

        $this->reset('name');
    }
}
