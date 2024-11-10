<?php

use App\Livewire\Groups\Destroy;
use App\Models\Group;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $user = User::factory()->create();

    actingAs($user);
});

test ('should delete the group', function () {
    $group = Group::factory()->create([
        'user_id' => auth()->id(),
    ]);

    livewire(Destroy::class, ['group' => $group])->call('destroy');

    assertDatabaseCount(Group::class, 0);
});

test ('should check if the person is deleting their own group', function () {
    $group = Group::factory()->create([
        'user_id' => User::factory()->create()->id,
    ]);

    livewire(Destroy::class, ['group' => $group])->assertForbidden();
});
