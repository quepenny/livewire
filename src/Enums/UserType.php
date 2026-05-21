<?php

namespace Quepenny\Livewire\Enums;

use Quepenny\Livewire\Traits\Enums\HasOptions;

enum UserType: string {
    use HasOptions;

    case MEMBER = 'member';
    case GUEST = 'guest';
}
