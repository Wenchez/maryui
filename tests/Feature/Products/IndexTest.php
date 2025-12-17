<?php

namespace Tests\Feature\Products;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Products\Index;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function los_managers_pueden_acceder_al_index_de_productos()
    {
        $user = User::factory()->create(['role' => 'manager']);

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertViewIs('livewire.products.index');
    }

    #[Test]
    public function los_no_managers_no_pueden_acceder_al_index_de_productos()
    {
        $user = User::factory()->create(['role' => 'cashier']);

        $this->actingAs($user);

        Livewire::test(Index::class)
            ->assertViewIs('livewire.access-denied');
    }
}
