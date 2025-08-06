<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//php artisan make:model Option -m 
class Option extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $fillable = ['name', 'type',];
    //relacion uno a muchos inversa
    public function products()
    {
        return $this->belongsToMany(Product::class)
        ->using(OptionProduct::class)->withPivot('features')->withTimestamps();
    }
    //relacion uno a muchos
    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}
