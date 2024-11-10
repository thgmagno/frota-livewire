<?php

use App\Livewire\Groups\Index;
use App\Models\Group;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $user = User::factory()->create();

    actingAs($user);
});

test ('should list all the groups that belong to the user', function () {
    $groupsThatBelongToUser = Group::factory()->count(3)->create([
        'user_id' => auth()->id(),
    ]);

    $groupsThatDoNotBelongToUser = Group::factory()->count(3)->create();

    livewire(Index::class)->assertSet('groups', function($groups) use($groupsThatBelongToUser, $groupsThatDoNotBelongToUser) {
        return $groups->count() === $groupsThatBelongToUser->count()
            && $groups->contains($groupsThatBelongToUser->first())
            && !$groups->contains($groupsThatDoNotBelongToUser->first());
    });
});
