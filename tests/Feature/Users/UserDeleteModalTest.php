<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class UserDeleteModalTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_abrir_el_modal_y_cargar_datos_del_usuario()
    {
        $user = User::factory()->create([
            'name' => 'Juan Pérez',
        ]);

        Livewire::test(\App\Livewire\Usuarios\UserDeleteModal::class)
            ->dispatch('deleteUser', $user->user_id)
            ->assertSet('userId', $user->user_id)
            ->assertSet('userName', 'Juan Pérez')
            ->assertSet('showModal', true);
    }

    #[Test]
    public function puede_eliminar_un_usuario_correctamente()
    {
        $user = User::factory()->create();

        Livewire::test(\App\Livewire\Usuarios\UserDeleteModal::class)
            ->set('userId', $user->user_id)
            ->call('delete')
            ->assertDispatched('userUpdated')
            ->assertSet('showModal', false);

        $this->assertDatabaseMissing('users', [
            'user_id' => $user->user_id,
        ]);
    }

    #[Test]
    public function no_falla_si_no_hay_userId()
    {
        Livewire::test(\App\Livewire\Usuarios\UserDeleteModal::class)
            ->set('userId', null)
            ->call('delete')
            ->assertNotDispatched('userUpdated');
    }

    #[Test]
    public function renderiza_la_vista_correcta()
    {
        Livewire::test(\App\Livewire\Usuarios\UserDeleteModal::class)
            ->assertViewIs('livewire.usuarios.user-delete-modal');
    }
}
