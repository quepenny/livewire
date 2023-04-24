<?php

namespace Quepenny\Livewire\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

abstract class ProductionSeeder extends Seeder
{
    public function call($class, $silent = false, array $parameters = []): static
    {
        $classes = Arr::wrap($class);

        foreach ($classes as $class) {
            $seeder = $this->resolve($class);
            $name = get_class($seeder);

            $skipSeed = App::environment(['testing', 'production'])
                && ! $seeder instanceof ProductionSeeder;

            if ($skipSeed) {
                $this->command->getOutput()->writeln("<bg=yellow;fg=black>Skipped:</> {$name}");

                continue;
            }

            if ($silent === false && isset($this->command)) {
                $this->command->getOutput()->writeln("<comment>Seeding:</comment> {$name}");
            }

            $startTime = microtime(true);

            $seeder->__invoke($parameters);

            $runTime = number_format((microtime(true) - $startTime) * 1000, 2);

            if ($silent === false && isset($this->command)) {
                $this->command->getOutput()->writeln("<info>Seeded:</info>  {$name} ({$runTime}ms)");
            }
        }

        return $this;
    }
}
