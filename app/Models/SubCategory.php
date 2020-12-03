<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{ protected $fillable=['name','category_id','image_id'];
    use SoftDeletes;
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function image():BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
