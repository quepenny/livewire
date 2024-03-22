<?php

namespace Quepenny\Livewire\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Enquiry extends Model
{
    use Notifiable;

    protected $guarded = [];
}
