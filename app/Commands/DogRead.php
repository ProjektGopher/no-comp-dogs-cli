<?php

namespace App\Commands;

use App\Traits\ValidatesDog;
use App\Traits\ValidatesUser;
use LaravelZero\Framework\Commands\Command;

use function Laravel\Prompts\table;

class DogRead extends Command
{
    use ValidatesUser;
    use ValidatesDog;

    protected $signature = 'dog:read {dog}';

    protected $description = 'See dog details.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->validateUser();
        $this->validateDogForUser($this->argument('dog'), $this->user);

        if ($this->dog === null) {
            $this->error('Dog not found.');
            return Command::FAILURE;
        }

        table(
            ['Name', 'Breed', 'Birth Year'],
            [$this->dog->only(['name', 'breed', 'birth_year'])],
        );

        return Command::SUCCESS;
    }
}
