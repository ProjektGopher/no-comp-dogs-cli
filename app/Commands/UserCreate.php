<?php

namespace App\Commands;

use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use LaravelZero\Framework\Commands\Command;

class UserCreate extends Command
{
    protected $signature = 'user:create';

    protected $description = 'Create a user with which to associate dogs.';

    public function handle(): int
    {
        prompt:
        $name = $this->ask('What is your name?');

        try {
            $user = User::create(['name' => $name]);
        } catch (UniqueConstraintViolationException $e) {
            $this->error('That name is already taken. Please try again.');
            goto prompt;
        }

        cache(['user' => $user]);

        return Command::SUCCESS;
    }
}
