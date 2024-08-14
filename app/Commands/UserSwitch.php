<?php

namespace App\Commands;

use App\Models\User;

use function Laravel\Prompts\select;
use LaravelZero\Framework\Commands\Command;

class UserSwitch extends Command
{
    protected $signature = 'user:switch';

    protected $description = 'Switch users.';

    public function handle(): int
    {
        $user = select(
            label: 'Select a user:',
            options: [
                'Create a new user',
                ...User::all()->pluck('name')->toArray(),
            ],
        );

        if ($user === 'Create a new user') {
            $this->call('user:create');
        } else {
            $user = User::where('name', $user)->sole();
            cache(['user' => $user]);
        }

        return Command::SUCCESS;
    }
}
