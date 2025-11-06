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
            User::destroy($this->userId);

            // Cerrar modal
            $this->showModal = false;

            // Refrescar tabla
            $this->dispatch('userUpdated');
        }
    }
    
    public function render()
    {
        return view('livewire.usuarios.user-delete-modal');
    }
}
