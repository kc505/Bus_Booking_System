<?php

namespace App\Livewire;

use Livewire\Component;

class SeatSelector extends Component
{
   public function render()
{
    return view('livewire.seat-selector')
           ->layout('layouts.app'); // ← Same here
}
}
