<?php

namespace App\Livewire;

use App\Models\Invitation;
use Livewire\Component;

class ConfirmInvitation extends Component
{
    public ?string $id = null;
    public ?Invitation $invitation;

    public function mount(?string $id = null)
    {
        $this->id = $id;
        $this->invitation = Invitation::find($this->id);
    }

    public function render()
    {
        return view('livewire.confirm-invitation');
    }
}
