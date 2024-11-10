<?php

use App\Livewire\Groups\Create;
use App\Models\Group;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Livewire\livewire;

beforeEach(function () {
    $user = User::factory()->create();

    actingAs($user);
});

it ('should be able to create new group', function () {
    livewire(Create::class)
        ->set('name', 'Test Group')
        ->call('save')
        ->assertHasNoErrors();

    assertDatabaseCount(Group::class, 1);
});

# Region: Validation
it ('name should be required', function () {
    livewire(Create::class)
        ->call('save')
        ->assertHasErrors(['name' => 'required']);
});

it ('name should have a min of 3 characters', function () {
    livewire(Create::class)
        ->set('name', 'ab')
        ->call('save')
        ->assertHasErrors(['name' => 'min']);
});

it ('name should have a max of 30 characters', function () {
    livewire(Create::class)
        ->set('name', str_repeat('a', 31))
        ->call('save')
        ->assertHasErrors(['name' => 'max']);
});

it ('name should be unique', function () {
    Group::factory()->create(['name' => 'Test Group']);

    livewire(Create::class)
        ->set('name', 'Test Group')
        ->call('save')
        ->assertHasErrors(['name' => 'unique']);
});
# EndRegion: Validation