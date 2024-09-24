<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class Slug extends Component
{
    public $slug = '';

    public function render()
    {
        return view('livewire.slug');
    }

    // Event listener untuk menghasilkan slug
    public function generateSlug($selectedName): void
    {
        $this->slug = Str::slug($selectedName, '-');
    }
}