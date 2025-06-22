<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//php artisan make:model Subcategory -m
class Subcategory extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $fillable = ['name', 'category_id'];
    //Relacion uno a muchos inversa
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    //Relacion uno a muchos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
