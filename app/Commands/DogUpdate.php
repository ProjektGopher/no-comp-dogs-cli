<?php

namespace App\Commands;

use App\Traits\ValidatesDog;
use App\Traits\ValidatesUser;
use LaravelZero\Framework\Commands\Command;

class DogUpdate extends Command
{
    use ValidatesUser;
    use ValidatesDog;

    protected $signature = 'dog:update {dog}';

    protected $description = 'Update a dog.';

    public function handle()
    {
        $this->validateUser();
        $this->validateDogForUser($this->argument('dog'), $this->user);

        if ($this->dog === null) {
            $this->error('Dog not found.');
            return Command::FAILURE;
        }
        
        name:
        $name = $this->ask('What is the dog\'s name?', $this->dog->name);

        if ( true // <- this is just for styling
            && $name !== $this->dog->name
            && $this->user->dogs->where('name', $name)->count() > 0
        ) {
            $this->error('Dog already exists.');
            goto name;
        }

        $breed = $this->ask("What breed is {$name}?");

        $birth_year = $this->ask("What year was {$name} born?");

        $this->dog->update([
            'name' => $name,
            'breed' => $breed,
            'birth_year' => $birth_year,
        ]);

        $this->info("Dog {$name} updated successfully!");


        return Command::SUCCESS;
    }
}
