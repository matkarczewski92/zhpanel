<?php

namespace App\Livewire\Settings;

use App\Models\AnimalPhotoGallery;
use Livewire\Component;

class WebGallery extends Component
{
    public function render()
    {
        return view('livewire.settings.web-gallery', [
            'gallery' => AnimalPhotoGallery::all(),
        ]);
    }

    public function galleryStatus(int $id)
    {
        $photo = AnimalPhotoGallery::find($id);
        $photo->webside = ($photo->webside == 1) ? 0 : 1;
        $photo->save();
    }
}
