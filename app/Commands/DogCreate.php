<?php

namespace App\Commands;

use App\Models\Dog;
use App\Traits\ValidatesUser;
use LaravelZero\Framework\Commands\Command;

class DogCreate extends Command
{
    use ValidatesUser;

    protected $signature = 'dog:create';

    protected $description = 'Create a dog.';

    public function handle()
    {
        $this->validateUser();

        name:
        $name = $this->ask('What is the dog\'s name?');

        if ($this->user->dogs->where('name', $name)->count() > 0) {
            $this->error('Dog already exists.');
            goto name;
        }

        $breed = $this->ask("What breed is {$name}?");

        $birth_year = $this->ask("What year was ${name} born?");

        $this->user->dogs()->create([
            'name' => $name,
            'breed' => $breed,
            'birth_year' => $birth_year,
        ]);

        $this->info("Dog {$name} created successfully!");

        return Command::SUCCESS;
    }
}
