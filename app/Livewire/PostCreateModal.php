<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Request;
use Livewire\Component;

class PostCreateModal extends Component
{
    public bool $modalOpen = false;

    public function showModal(): void
    {
        $this->modalOpen = true;
    }

    public function render()
    {
        return view('livewire.post-create-modal');
    }
}
