<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (config('quepenny.guest_members')) {
            Schema::create('guests', function (Blueprint $table) {
                $table->id();
                $table->ulid('token');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        if (config('quepenny.guest_members')) {
            Schema::dropIfExists('guests');
        }
    }
};
