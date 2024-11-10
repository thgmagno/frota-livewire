<?php

namespace App\Livewire\Groups;

use App\Models\Group;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.groups.index');
    }

    public function getGroupsProperty()
    {
        return auth()->user()->groups;
    }
}
