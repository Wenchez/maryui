<?php

namespace Tests\Feature\Users;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class LogoutComponentTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function un_usuario_autenticado_puede_cerrar_sesion()
    {
        // Crear usuario y autenticarlo
        $user = User::factory()->create();
        $this->actingAs($user);

        // Ejecutar Livewire logout
        Livewire::test(\App\Livewire\Auth\Logout::class)
            ->call('logout')
            ->assertRedirect(route('login'));

        // Verificar que ya NO esté autenticado
        $this->assertFalse(Auth::check(), "El usuario debería haber sido deslogueado");
    }

    #[Test]
    public function logout_invalida_la_sesion_y_regenera_token()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $oldToken = session()->token();
        $oldSession = session()->getId();

        Livewire::test(\App\Livewire\Auth\Logout::class)
            ->call('logout');

        $this->assertFalse(Auth::check());

        // La sesión debe cambiar
        $this->assertNotEquals($oldSession, session()->getId(), "La sesión debe invalidarse");

        // El token CSRF debe cambiar
        $this->assertNotEquals($oldToken, session()->token(), "El token debe regenerarse");
    }

    #[Test]
    public function muestra_la_vista_correcta()
    {
        Livewire::test(\App\Livewire\Auth\Logout::class)
            ->assertViewIs('livewire.auth.logout');
    }
}
