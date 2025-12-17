<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UserTable extends Component
{
    use WithPagination;

    public int $perPage = 5;

    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];

    protected $listeners = ['userUpdated' => '$refresh']; // refresca tabla al editar

    public function sort($column)
    {
        if ($this->sortBy['column'] === $column) {
            $this->sortBy['direction'] = $this->sortBy['direction'] === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy['column'] = $column;
            $this->sortBy['direction'] = 'asc';
        }
    }

    public function editUser($userId)
    {
        $this->dispatch('editUser', userId: $userId)->to('usuarios.user-edit-modal');
    }

    public function deleteUser($userId)
    {
        $this->dispatch('deleteUser', userId: $userId)->to('usuarios.user-delete-modal');
    }

    public function render()
    {
        $users = User::query()
            ->orderBy($this->sortBy['column'], $this->sortBy['direction'])
            ->paginate($this->perPage);

        $headers = [
            ['key' => 'user_id', 'label' => '#', 'class' => 'w-16'],
            ['key' => 'name', 'label' => 'Nombre'],
            ['key' => 'email', 'label' => 'Correo'],
            ['key' => 'role', 'label' => 'Rol'],
            ['key' => 'actions', 'label' => 'Acciones', 'sortable' => false],
        ];

        return view('livewire.usuarios.user-table', [
            'users' => $users,
            'headers' => $headers
        ]);
    }
}
