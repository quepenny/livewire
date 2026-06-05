<?php

namespace Quepenny\Livewire\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Quepenny\Livewire\Models\Enquiry;

/**
 * @extends Factory<Enquiry>
 */
class EnquiryFactory extends Factory
{
    protected $model = Enquiry::class;

    public function definition(): array
    {
        return [
            'name'    => fake()->name(),
            'email'   => fake()->safeEmail(),
            'subject' => fake()->sentence(4),
            'message' => fake()->paragraph(),
        ];
    }
}
