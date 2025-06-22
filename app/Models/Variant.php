<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//php artisan make:model Variant -m
class Variant extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $fillable = ['sku', 'image_path', 'product_id'];
    //relacion uno a muchos inversa
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    //relacion muchos a muchos
    public function features()
    {
        return $this->belongsToMany(Feature::class)->withTimestamps();
    }
}
