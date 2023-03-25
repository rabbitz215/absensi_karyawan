<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'manager_name', 'no_telp', 'email', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
