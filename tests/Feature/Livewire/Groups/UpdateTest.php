<?php

use App\Livewire\Groups\Update;
use App\Models\Group;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $user = User::factory()->create();

    actingAs($user);
});

test ('should be able to update a group name', function () {
    $group = Group::factory()->create([
        'user_id' => auth()->id(),
        'name' => 'Old Group',
    ]);

    livewire(Update::class, ['group' => $group])
        ->set('name', 'New Group')
        ->call('save')
        ->assertHasNoErrors();

    expect($group->refresh()->name)->toBe('New Group');
});

# Region: Validation
test ('name should be required', function () {
    $group = Group::factory()->create([
        'user_id' => auth()->id(),
        'name' => 'Old Group',
    ]);

    livewire(Update::class, ['group' => $group])
        ->set('name', '')
        ->call('save')
        ->assertHasErrors(['name' => 'required']);
});

test ('name should have a min of 3 characters', function () {
    $group = Group::factory()->create([
        'user_id' => auth()->id(),
        'name' => 'Old Group',
    ]);

    livewire(Update::class, ['group' => $group])
        ->set('name', 'ab')
        ->call('save')
        ->assertHasErrors(['name' => 'min']);
});

test ('name should have a max of 30 characters', function () {
    $group = Group::factory()->create([
        'user_id' => auth()->id(),
        'name' => 'Old Group',
    ]);

    livewire(Update::class, ['group' => $group])
        ->set('name', str_repeat('a', 31))
        ->call('save')
        ->assertHasErrors(['name' => 'max']);
});

test ('name should be unique', function () {
    Group::factory()->create([
        'user_id' => auth()->id(),
        'name' => 'Test Group',
    ]);

    $group = Group::factory()->create([
        'user_id' => auth()->id(),
        'name' => 'Old Group',
    ]);

    livewire(Update::class, ['group' => $group])
        ->set('name', 'Test Group')
        ->call('save')
        ->assertHasErrors(['name' => 'unique']);
});

test ('should check if the person is updating their own group', function () {
    $user = User::factory()->createOne();

    $group = Group::factory()->create([
        'user_id' => $user->id,
        'name' => 'Test Group',
    ]);

    livewire(Update::class, ['group' => $group])
        ->assertForbidden();
});
# EndRegion: Validation
