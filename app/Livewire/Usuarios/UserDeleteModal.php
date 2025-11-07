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
            $this->showModal = false;
            $this->dispatch('userUpdated');
        }
    }
    
    public function render()
    {
        return view('livewire.usuarios.user-delete-modal');
    }
}
