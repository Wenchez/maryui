<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Mary\Traits\Toast;

class Logout extends Component
{
    use Toast;
    
    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        $this->success(
            'Sesión cerrada correctamente',
            'Vuelve pronto',
            position: 'toast-bottom toast-end',
            timeout: 2500
        );

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.logout');
    }
}
