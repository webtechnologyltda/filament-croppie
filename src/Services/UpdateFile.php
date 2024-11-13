<?php

namespace Michaeld555\FilamentCroppie\Services;

use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Support\Str;

class UpdateFile extends Component
{

    public string $statePath;

    public function mount($statePath = ''): void
    {
        $this->statePath = md5($statePath);
    }

    #[On('upload-croppied-image')]
    public function uploadImageFile(string $disk, string $base64Image, string $statePath, string $imageName = 'croppied-image', string $imageType = 'png'): void
    {

        if($statePath !== $this->statePath) return;

        $base64Image = str_replace("data:image/".$imageType.";base64,", "", $base64Image);

        $imageContent = base64_decode($base64Image);

        $filename = $imageName . '.' . $imageType;

        $data = Storage::disk($disk)->put($filename, $imageContent);

        $this->dispatch('set-croppied-image-'.$this->statePath, uuid: Str::uuid()->toString(), localFileName: $filename);

    }

    public function render(): View
    {
        return view('filament-croppie::livewire.update-file');
    }

}
