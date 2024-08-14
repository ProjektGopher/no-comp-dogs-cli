<?php

namespace App\Traits;

use App\Models\User;

trait ValidatesUser
{
    protected User|null $user = null;

    public function validateUser(): void
    {
        $this->user = cache('user')?->fresh();

        if ($this->user === null) {
            $this->call('user:switch');
            $this->user = cache('user');
        }
    }
}