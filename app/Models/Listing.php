<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    use HasFactory;                 // This keyword tells laravel to use the ListingFactory class
    protected $fillable = [                               // Using mass assignment
      'beds', 'baths', 'area', 'city', 'street', 'code', 'street_nr', 'price'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'by_user_id'); // If you skip this parameter it will be auto generated
    }
}
