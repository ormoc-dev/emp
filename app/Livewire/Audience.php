<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class Audience extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::where('level', 'user')->get();
    }

    public function render()
    {
        return view('livewire.audience');
    }
} 