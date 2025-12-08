<?php

namespace Tests\Feature\Users;

use App\Livewire\Auth\Login;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class LoginComponentTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function el_componente_se_renderiza_correctamente()
    {
        Livewire::test(Login::class)
            ->assertStatus(200)
            ->assertSee('email'); // o cualquier input del formulario
    }

    #[Test]
    public function valida_los_campos_correctamente()
    {
        Livewire::test(Login::class)
            ->set('email', '')
            ->set('password', '')
            ->call('login')
            ->assertHasErrors([
                'email' => 'required',
                'password' => 'required',
            ]);
    }

    #[Test]
    public function muestra_error_si_las_credenciales_son_invalidas()
    {
        Livewire::test(Login::class)
            ->set('email', 'noexiste@example.com')
            ->set('password', 'incorrecta')
            ->call('login')
            ->assertHasErrors(['email']);
    }

    #[Test]
    public function permite_iniciar_sesion_con_credenciales_correctas()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        Livewire::test(Login::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password123')
            ->call('login')
            ->assertRedirect(route('dashboard'));

        $this->assertTrue(Auth::check());
        $this->assertEquals($user->email, Auth::user()->email);
    }

    #[Test]
    public function permite_iniciar_sesion_con_recordarme()
    {
        $user = User::factory()->create([
            'email' => 'remember@example.com',
            'password' => Hash::make('clave123'),
        ]);

        Livewire::test(Login::class)
            ->set('email', 'remember@example.com')
            ->set('password', 'clave123')
            ->set('remember', true)
            ->call('login')
            ->assertRedirect(route('dashboard'));

        $this->assertTrue(Auth::check());
    }
}
