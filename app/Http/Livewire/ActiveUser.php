<?php

namespace App\Http\Livewire;

use App\Mail\ActiveUserMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ActiveUser extends Component
{
    public $user;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function active($user)
    {
        if ($user['active'] == 0) {
            User::where('id', $user['id'])->update([
                'active' => 1,
            ]);

            Mail::send(new ActiveUserMail($user));

            $this->emit('refreshComponent');
        } else {
            User::where('id', $user['id'])->update([
                'active' => 0,
            ]);

            $this->emit('refreshComponent');
        }
    }

    public function render()
    {
        return view('livewire.active-user');
    }
}
