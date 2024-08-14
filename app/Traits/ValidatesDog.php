<?php

namespace App\Traits;

use App\Models\Dog;
use App\Models\User;
use Illuminate\Support\ItemNotFoundException;

trait ValidatesDog
{
    protected Dog|null $dog = null;

    public function validateDogForUser(string $dog_name, User $user): void
    {
        try {
            $this->dog = $user->dogs->where('name', $dog_name)->sole();
        } catch (ItemNotFoundException) {
            // $this->dog will remain null
            return;
        }
    }
}