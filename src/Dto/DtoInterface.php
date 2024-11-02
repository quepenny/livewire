<?php

namespace Quepenny\Livewire\Dto;

interface DtoInterface
{
    public static function fromArray(array $data): static;
}
