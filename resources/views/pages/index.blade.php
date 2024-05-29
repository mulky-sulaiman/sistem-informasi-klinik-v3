<?php

use function Laravel\Folio\{middleware, name};
use Livewire\Volt\Component;

name('home');
middleware(['guest']);

new class extends Component {};

?>
<x-layouts.default>
    @volt('home')
        <div class="flex items-center justify-center max-w-7xl min-h-screen mx-auto">
            <div class="w-full text-center">
                <p class="font-bold tracking-widest uppercase text-4xl mb-6">Sistem Informasi Klinik v3</p>
                <ul class="flex items-center justify-center gap-4 tracking-widest uppercase font-base text-md-center">
                    <li><a href="/admin/login" wire:navigate>{{ __('Login') }}</a></li>
                    {{-- <li><a href="/admin/register" wire:navigate>{{ __('Register') }}</a></li> --}}
                </ul>
                <p class=""></p>
            </div>
        </div>
    @endvolt
</x-layouts.default>
