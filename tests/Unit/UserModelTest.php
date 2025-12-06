<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function puede_crear_un_usuario()
    {
        $user = User::factory()->create([
            'role' => 'manager',
        ]);

        $this->assertDatabaseHas('users', [
            'user_id' => $user->user_id,
            'email' => $user->email,
        ]);
    }

    #[Test]
    public function detecta_si_es_manager()
    {
        $user = User::factory()->make(['role' => 'manager']);

        $this->assertTrue($user->isManager());
        $this->assertFalse($user->isCashier());
    }

    #[Test]
    public function detecta_si_es_cashier()
    {
        $user = User::factory()->make(['role' => 'cashier']);

        $this->assertTrue($user->isCashier());
        $this->assertFalse($user->isManager());
    }

    #[Test]
    public function puede_actualizar_un_usuario()
    {
        $user = User::factory()->create();

        $updated = User::updateUser($user->user_id, [
            'name' => 'Nuevo Nombre',
        ]);

        $this->assertEquals('Nuevo Nombre', $updated->name);

        $this->assertDatabaseHas('users', [
            'user_id' => $user->user_id,
            'name' => 'Nuevo Nombre',
        ]);
    }

    #[Test]
    public function puede_eliminar_un_usuario()
    {
        $user = User::factory()->create();

        User::deleteUser($user->user_id);

        $this->assertDatabaseMissing('users', [
            'user_id' => $user->user_id,
        ]);
    }

    #[Test]
    public function fillable_esta_configurado_correctamente()
    {
        $user = new User();

        $this->assertEquals(
            ['name', 'email', 'password', 'role'],
            $user->getFillable()
        );
    }

    #[Test]
    public function casts_estan_configurados_correctamente()
    {
        $user = new User();

        $this->assertEquals([
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ], $user->casts());
    }
}
