<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//php artisan make:model Product -m 
class Product extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    //Relacion uno a muchos inversa
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
    //relacion uno a muchos
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
    //realtion muchos a muchos
    public function options()
    {
        return $this->belongsToMany(Option::class)->withPivot('value')->withTimestamps();
    }
}
