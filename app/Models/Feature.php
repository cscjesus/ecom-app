<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//php artisan make:model Feature -m
class Feature extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    //relacion uno a muchos inversa
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
    //relacion muchos a muchos
    public function variants()
    {
        return $this->belongsToMany(Variant::class)->withTimestamps();
    }
}
