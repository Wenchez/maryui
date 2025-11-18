<?php

namespace App\Livewire\Usuarios;

use Livewire\Component;
use App\Models\User;

class UserDeleteModal extends Component
{
    public $userId;
    public $userName;
    public $showModal = false;

    protected $listeners = ['deleteUser' => 'open'];

    public function open($userId)
    {
        $user = User::findOrFail($userId);

        $this->userId = $user->user_id;
        $this->userName = $user->name;
        $this->showModal = true;
    }

    public function delete()
    {
        if ($this->userId) {
            User::deleteUser($this->userId);
            $this->success(
                'Usuario eliminado correctamente.',
                position: 'toast-bottom toast-end',
                css: 'bg-pink-500 text-base-100',
                timeout: 2500
        );
            $this->showModal = false;
            $this->dispatch('userUpdated');
        }
    }
    
    public function render()
    {
        return view('livewire.usuarios.user-delete-modal');
    }
}
