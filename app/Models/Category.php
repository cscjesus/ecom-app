<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//php artisan make:model Category -m
class Category extends Model
{
    use HasFactory;
    //Relacion uno a muchos inversa
    protected $fillable = ['name', 'family_id'];
    public function family()
    {
        return $this->belongsTo(Family::class);
    }
    //Relacion uno a muchos
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class); 
    }
}
