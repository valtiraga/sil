<?php

namespace App\Livewire;

use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Livewire\Component;

class LanguageToggle extends Component
{
    public string $currentLocale;

    public function mount(): void
    {
        $this->currentLocale = LanguageSwitch::make()->getPreferredLocale();
    }

    public function switchLocale(): void
    {
        $newLocale = $this->currentLocale === 'en' ? 'id' : 'en';

        LanguageSwitch::switchLocale($newLocale);

        $this->redirect(request()->header('Referer', url()->current()));
    }

    public function render()
    {
        return view('livewire.language-toggle');
    }
}
