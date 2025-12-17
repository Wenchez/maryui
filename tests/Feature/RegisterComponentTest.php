<?php

namespace Tests\Feature;

use App\Livewire\Auth\Register;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class RegisterComponentTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function el_componente_se_renderiza_correctamente()
    {
        Livewire::test(Register::class)
            ->assertStatus(200)
            ->assertSee('name'); // o algún texto que esté en view
    }

    #[Test]
    public function valida_los_campos_correctamente()
    {
        Livewire::test(Register::class)
            ->set('name', '')
            ->set('email', 'no-es-email')
            ->set('password', '123')
            ->set('password_confirmation', '999')
            ->set('role', 'invalid-role')
            ->call('register')
            ->assertHasErrors([
                'name' => 'required',
                'email' => 'email',
                'password' => 'confirmed',
                'role' => 'in',
            ]);
    }

    #[Test]
    public function crea_un_usuario_correctamente()
    {
        Livewire::test(Register::class)
            ->set('name', 'Juan Pérez')
            ->set('email', 'juan@example.com')
            ->set('password', 'password123')
            ->set('password_confirmation', 'password123')
            ->set('role', 'manager')
            ->call('register')
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'name' => 'Juan Pérez',
            'email' => 'juan@example.com',
            'role' => 'manager',
        ]);
    }

    #[Test]
    public function la_contrasena_se_hashea_correctamente()
    {
        Livewire::test(Register::class)
            ->set('name', 'Sara')
            ->set('email', 'sara@example.com')
            ->set('password', 'clave123')
            ->set('password_confirmation', 'clave123')
            ->set('role', 'cashier')
            ->call('register');

        $user = User::where('email', 'sara@example.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('clave123', $user->password));
    }

    #[Test]
    public function inicia_sesion_automaticamente_luego_de_registrar()
    {
        Livewire::test(Register::class)
            ->set('name', 'Carlos')
            ->set('email', 'carlos@example.com')
            ->set('password', 'pass1234')
            ->set('password_confirmation', 'pass1234')
            ->set('role', 'manager')
            ->call('register');

        $this->assertTrue(Auth::check());
        $this->assertEquals('carlos@example.com', Auth::user()->email);
    }
}
