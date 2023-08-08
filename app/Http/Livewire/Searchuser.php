<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Livewire\Component;

class Searchuser extends Component
{
    public String $query;

    public array $users = [];

    public Int $selectedIndex = 0;

    public function incrementIndex(): void
    {
        if ($this->selectedIndex === count($this->users) - 1) {
            $this->selectedIndex = 0;
        } else {
            $this->selectedIndex++;
        }
    }

    public function decrementIndex(): void
    {
        if ($this->selectedIndex === 0) {
            $this->selectedIndex = count($this->users) - 1;
        } else {
            $this->selectedIndex--;
        }
    }

    public function showUser(): RedirectResponse
    {
        if ($this->users->isNotEmpty()) {
            return redirect()->route('admin.droits.users.show', [$this->users[$this->selectedIndex]['id']]);
        }
    }

    public function updatedQuery(): void
    {
        $words = '%'.$this->query.'%';

        if (strlen($this->query) > 2) {
            $this->users = User::where('name', 'like', $words)
                ->orwhere('login', 'like', $words)
                ->get();
        }

    }

    public function resetIndex(): void
    {
        $this->reset('selectedIndex');
    }

    public function render(): view
    {
        return view('livewire.searchuser');
    }
}
