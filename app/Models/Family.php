<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//php artisan make:model Family -m
class Family extends Model
{
    use HasFactory;
    //Relacion uno a muchos
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
