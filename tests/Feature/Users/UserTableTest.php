<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class UserTableTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function renderiza_la_vista_correcta()
    {
        Livewire::test(\App\Livewire\Usuarios\UserTable::class)
            ->assertViewIs('livewire.usuarios.user-table');
    }

    #[Test]
    public function paginacion_funciona_correctamente()
    {
        User::factory()->count(20)->create();

        Livewire::test(\App\Livewire\Usuarios\UserTable::class)
            ->set('perPage', 5)
            ->assertSee(User::orderBy('name')->paginate(5)->first()->name);
    }

    #[Test]
    public function ordenamiento_cambia_correctamente()
    {
        User::factory()->create(['name' => 'Carlos']);
        User::factory()->create(['name' => 'Ana']);

        $component = Livewire::test(\App\Livewire\Usuarios\UserTable::class);

        // Orden inicial ASC
        $component->call('sort', 'name')
            ->assertSet('sortBy.direction', 'desc');

        // Cambiar nuevamente vuelve a ASC
        $component->call('sort', 'name')
            ->assertSet('sortBy.direction', 'asc');

        // Cambiar columna restablece ASC
        $component->call('sort', 'email')
            ->assertSet('sortBy.column', 'email')
            ->assertSet('sortBy.direction', 'asc');
    }

    #[Test]
    public function envia_evento_al_abrir_modal_de_edicion()
    {
        $user = User::factory()->create();

        Livewire::test(\App\Livewire\Usuarios\UserTable::class)
            ->call('editUser', $user->user_id)
            ->assertDispatched('editUser', userId: $user->user_id);
    }

    #[Test]
    public function envia_evento_al_abrir_modal_de_eliminacion()
    {
        $user = User::factory()->create();

        Livewire::test(\App\Livewire\Usuarios\UserTable::class)
            ->call('deleteUser', $user->user_id)
            ->assertDispatched('deleteUser', userId: $user->user_id);
    }

    #[Test]
    public function se_refresca_cuando_se_emitio_userUpdated()
    {
        User::factory()->count(3)->create();

        Livewire::test(\App\Livewire\Usuarios\UserTable::class)
            ->dispatch('userUpdated') // listener: $refresh
            ->assertStatus(200); // Si refresca sin error, todo OK
    }
}
