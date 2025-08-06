<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//php artisan make:model Product -m 
class Product extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    protected $fillable = ['sku', 'name', 'description', 'image_path', 'price', 'subcategory_id','stock'];
    // protected $casts = [
    //     'price' => 'float'
    // ];
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
        return $this->belongsToMany(Option::class)
        ->using(OptionProduct::class)->withPivot('features')->withTimestamps();
    }
}
