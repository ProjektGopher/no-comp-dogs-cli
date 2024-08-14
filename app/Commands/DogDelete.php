<?php

namespace App\Commands;

use App\Traits\ValidatesDog;
use App\Traits\ValidatesUser;
use LaravelZero\Framework\Commands\Command;

class DogDelete extends Command
{
    use ValidatesUser;
    use ValidatesDog;

    protected $signature = 'dog:delete {dog}';

    protected $description = 'Delete a dog.';

    public function handle()
    {
        $this->validateUser();
        $this->validateDogForUser($this->argument('dog'), $this->user);

        if ($this->dog === null) {
            $this->error('Dog not found.');
            return Command::FAILURE;
        }

        $this->dog->delete();

        return Command::SUCCESS;
    }
}
