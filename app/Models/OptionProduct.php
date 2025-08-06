<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

//php artisan make:model OptionProduct
class OptionProduct extends Pivot
{
    use HasFactory;
    protected $casts = [
        'features' => 'array',
    ];
}
