<?php

namespace Tests\Feature\Sales;

use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Sales\Index;

class IndexTest extends TestCase
{
    /** @test */
    public function it_renders_index_component_correctly()
    {
        Livewire::test(Index::class)
            ->assertStatus(200);
    }
}
