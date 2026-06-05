<?php

namespace Quepenny\Livewire\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Enquiry extends Model
{
    use HasFactory;
    use Notifiable;

    protected $guarded = [];
}
