<?php

namespace App\Http\Livewire;

use App\Mail\ActiveUserMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ActiveUser extends Component
{
    /**
     * @var array<array<string>|string>
     */
    public $user;

    /**
     * @var array<string>
     */
    protected $listeners = ['refreshComponent' => '$refresh'];

    /**
     * @param  array<array<string>|string>  $user
     * @return void
     */
    public function active($user)
    {
        if ($user['active'] == '0') {
            User::where('id', $user['id'])->update([
                'active' => 1,
            ]);
            if (env('APP_MAILABLE'))
            {
                Mail::send(new ActiveUserMail($user));
            }
            $this->emit('refreshComponent');
        } else {
            User::where('id', $user['id'])->update([
                'active' => 0,
            ]);

            $this->emit('refreshComponent');
        }
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.active-user');
    }
}
