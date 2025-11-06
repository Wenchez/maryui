<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use App\Models\User;

class UserEditModal extends Component
{
    public $userId;
    public $name;
    public $email;
    public $role;
    public $showModal = false;

    protected $listeners = ['editUser' => 'open'];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'role' => 'required|in:manager,cashier',
    ];

    public function open($userId)
    {
        $user = User::findOrFail($userId);

        $this->userId = $user->user_id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->showModal = true;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId . ',user_id',
            'role' => 'required|in:manager,cashier',
        ]);

        User::updateUser($this->userId, [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ]);

        $this->showModal = false;
        $this->dispatch('userUpdated');
    }

    public function render()
    {
        return view('livewire.usuarios.user-edit-modal');
    }
}
