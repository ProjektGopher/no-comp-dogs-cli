<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dog extends Model
{
    protected $table = 'dogs';
    protected $fillable = ['name', 'breed', 'birth_year'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
