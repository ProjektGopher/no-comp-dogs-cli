<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name'];

    public function dogs()
    {
        return $this->hasMany(Dog::class);
    }
}
