<?php

namespace App\Commands;

use App\Traits\ValidatesUser;
use LaravelZero\Framework\Commands\Command;

use function Laravel\Prompts\select;

class DogList extends Command
{
    use ValidatesUser;

    protected $signature = 'dog:list';

    protected $description = 'List all dogs.';

    public function handle()
    {
        start:
        $this->validateUser();

        $dogs = $this->user->dogs;

        if ($dogs->isEmpty()) {
            $this->info('No dogs found.');
            return Command::SUCCESS;
        }

        $dog = select(
            label: 'Select a dog:',
            options: [
                'Go Back',
                ...$dogs->pluck('name')->toArray(),
            ],
        );

        if ($dog === 'Go Back') {
            return Command::SUCCESS;
        }

        $action = select('What would you like to do?', [
            'Show',
            'Update',
            'Delete',
            'Go Back'
        ]);

        if ($action === 'Go Back') {
            goto start;
        }

        match ($action) {
            'Show' => $this->call('dog:read', ['dog' => $dog]),
            'Update' => $this->call('dog:update', ['dog' => $dog]),
            'Delete' => $this->call('dog:delete', ['dog' => $dog]),
        };

        return Command::SUCCESS;
    }
}
