<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;                 // This keyword tells laravel to use the ListingFactory class and soft deletes
    protected $fillable = [                               // Using mass assignment
      'beds', 'baths', 'area', 'city', 'street', 'code', 'street_nr', 'price'
    ];

    protected $sortable = [                     // This is used to define which fields can be sorted by the user, not a laravel reserved keyword
        'price', 'created_at'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'by_user_id'); // If you skip this parameter it will be auto generated
    }

    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when(
            $filters['priceFrom'] ?? false,         // This condition should be met in order to get the fn executed
            fn($query, $value) => $query->where('price', '>=', $value)
        )
        ->when(
            $filters['priceTo'] ?? false,         // This condition should be met in order to get the fn executed
            fn($query, $value) => $query->where('price', '<=', $value)
        )
        ->when(
            $filters['beds'] ?? false,         // This condition should be met in order to get the fn executed
            fn($query, $value) => $query->where('beds', (int)$value < 6 ? '=' : '>=', $value)
        )
        ->when(
            $filters['baths'] ?? false,         // This condition should be met in order to get the fn executed
            fn($query, $value) => $query->where('baths', (int)$value < 6 ? '=' : '>=', $value)
        )
        ->when(
            $filters['areaFrom'] ?? false,       // This condition should be met in order to get the fn executed
            fn($query, $value) => $query->where('area', '>=', $value)
        )
        ->when(
            $filters['areaTo'] ?? false,         // This condition should be met in order to get the fn executed
            fn($query, $value) => $query->where('area', '>=', $value)
        )
        ->when(
            $filters['deleted'] ?? false,
            fn($query, $value) => $query->withTrashed()     // This will include soft deleted listings in the query
        )
        ->when(
            $filters['by'] ?? false,
            fn($query, $value) =>
            !in_array($value, $this->sortable) ? $query :
                $query->orderBy($value, $filters['order'] ?? 'desc')     // This will include soft deleted listings in the query
        );
    }

    public function images(): HasMany
    {
        return $this->hasMany(ListingImage::class); // This will automatically use the foreign key 'listing_id' in the ListingImage model
    }
}
