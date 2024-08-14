<?php

namespace App\Commands;

use App\Models\User;
use LaravelZero\Framework\Commands\Command;

use function Laravel\Prompts\select;

class DefaultCliInterface extends Command
{
    protected $signature = 'ui';

    protected $description = 'This is the default CLI interface.';

    protected User $user;

    public function handle()
    {
        $this->info('Hello friend! Welcome to the dog management system.');

        User::count() === 0
            ? $this->call('user:create')
            : $this->call('user:switch');

        $this->user = cache('user');
        
        $this->line("Thanks for authenticating, {$this->user->name}!");

        menu:
        $action = select('What would you like to do?', [
            'Exit',
            'Add a dog',
            'List all dogs',
        ]);

        if ($action === 'Exit') {
            return Command::SUCCESS;
        }

        match($action) {
            'Add a dog' => $this->call('dog:create'),
            'List all dogs' => $this->call('dog:list'),
        };

        goto menu;
    }
}
