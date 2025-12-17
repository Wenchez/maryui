<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class UserEditModalTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_abrir_el_modal_y_cargar_datos_del_usuario()
    {
        $user = User::factory()->create([
            'name' => 'Carlos Ruiz',
            'email' => 'carlos@example.com',
            'role' => 'manager',
        ]);

        Livewire::test(\App\Livewire\Usuarios\UserEditModal::class)
            ->dispatch('editUser', $user->user_id)
            ->assertSet('userId', $user->user_id)
            ->assertSet('name', 'Carlos Ruiz')
            ->assertSet('email', 'carlos@example.com')
            ->assertSet('role', 'manager')
            ->assertSet('showModal', true);
    }

    #[Test]
    public function valida_los_campos_correctamente()
    {
        Livewire::test(\App\Livewire\Usuarios\UserEditModal::class)
            ->set('userId', 1)
            ->set('name', '')
            ->set('email', 'no-valido')
            ->set('role', 'otro')
            ->call('update')
            ->assertHasErrors(['name', 'email', 'role']);
    }

    #[Test]
    public function puede_actualizar_el_usuario_correctamente()
    {
        $user = User::factory()->create();

        Livewire::test(\App\Livewire\Usuarios\UserEditModal::class)
            ->set('userId', $user->user_id)
            ->set('name', 'Nuevo Nombre')
            ->set('email', 'nuevo@example.com')
            ->set('role', 'cashier')
            ->call('update')
            ->assertSet('showModal', false)
            ->assertDispatched('userUpdated');

        $this->assertDatabaseHas('users', [
            'user_id' => $user->user_id,
            'name' => 'Nuevo Nombre',
            'email' => 'nuevo@example.com',
            'role' => 'cashier',
        ]);
    }

    #[Test]
    public function valida_email_unico_al_actualizar()
    {
        $user1 = User::factory()->create([
            'email' => 'correo1@example.com',
        ]);

        $user2 = User::factory()->create([
            'email' => 'correo2@example.com',
        ]);

        Livewire::test(\App\Livewire\Usuarios\UserEditModal::class)
            ->set('userId', $user1->user_id)
            ->set('name', 'Test')
            ->set('email', 'correo2@example.com') // ya usado
            ->set('role', 'manager')
            ->call('update')
            ->assertHasErrors('email');
    }

    #[Test]
    public function renderiza_la_vista_correcta()
    {
        Livewire::test(\App\Livewire\Usuarios\UserEditModal::class)
            ->assertViewIs('livewire.usuarios.user-edit-modal');
    }
}
