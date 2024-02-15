<?php

namespace Quepenny\Livewire\Traits\Livewire;

trait Toastable
{
    public function success(string $message): void
    {
        $this->toast('success', $message);
    }

    public function info(string $message): void
    {
        $this->toast('info', $message);
    }

    public function warning(string $message): void
    {
        $this->toast('warning', $message);
    }

    public function error(string $message): void
    {
        $this->toast('error', $message);
    }

    private function toast(string $mode, string $message): void
    {
        $this->dispatch('wire-toast', mode: $mode, message: $message);
    }
}
