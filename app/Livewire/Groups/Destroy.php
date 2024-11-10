<?php

namespace App\Livewire\Groups;

use App\Models\Group;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\Factory;
use Illuminate\View\View;
use Livewire\Component;

class Destroy extends Component
{
    use AuthorizesRequests;
    public Group $group;

    public function mount(Group $group): void
    {
        $this->authorize('delete', $group);

        $this->group = $group;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.groups.destroy');
    }

    public function destroy(): void
    {
        $this->group->delete();
    }
}
