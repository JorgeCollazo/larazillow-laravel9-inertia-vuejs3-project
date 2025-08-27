<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ListingImage extends Model
{
    use HasFactory;
    protected $fillable = ['filename'];
    protected $appends = ['src'];   // This will append the 'src' attribute to the model when it is converted to an array or JSON

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);    // Laravel automatically figures out the foreign key, if you want to change it you can pass the second parameter
    }

    public function getSrcAttribute(): string
    {
        return asset('storage/' . $this->filename);  // This will return the full URL to the image, you can also use url() helper
    }

}
