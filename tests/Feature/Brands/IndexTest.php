<?php

namespace Tests\Feature\Brands;

use App\Livewire\Brands\Index;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function los_managers_pueden_acceder_al_index_de_marcas()
    {
        $user = User::factory()->create(['role' => 'manager']);

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertViewIs('livewire.brands.index');
    }

    #[Test]
    public function los_no_managers_no_pueden_acceder_al_index_de_marcas()
    {
        $user = User::factory()->create(['role' => 'cashier']);

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertViewIs('livewire.access-denied');
    }
}
