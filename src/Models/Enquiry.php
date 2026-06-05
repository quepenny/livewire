<?php

namespace Quepenny\Livewire\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Quepenny\Livewire\Factories\EnquiryFactory;

class Enquiry extends Model
{
    use HasFactory;
    use Notifiable;

    protected $guarded = [];

    protected static function newFactory(): Factory
    {
        return EnquiryFactory::new();
    }
}
