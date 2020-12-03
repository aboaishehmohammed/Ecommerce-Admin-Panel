<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $fillable=['name','image_id'];
    use SoftDeletes;
    public function subCategories(): HasMany
    {
        return $this->hasMany(SubCategory::class);
    }
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

}
