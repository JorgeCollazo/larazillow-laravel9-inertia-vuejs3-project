<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;                 // This keyword tells laravel to use the ListingFactory class
    protected $fillable = [                               // Using mass assignment
      'beds', 'baths', 'area', 'city', 'street', 'code', 'street_nr', 'price'
    ];
}
