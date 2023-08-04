<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Mail\ActiveUserMail;
use Illuminate\Support\Facades\Mail;

class ActiveUser extends Component
{
    public $user;
    protected $listeners = ['refreshComponent' => '$refresh'];

    public function active($user)
    {    
        if ($user['active'] == 0)
        {
            User::where('id', $user['id'])->update([
               'active' => 1,
            ]);

            Mail::send(new ActiveUserMail($user));

            $this->emit('refreshComponent');
        }
        else
        {
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
