<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $fillable = ['name','description', 'price', 'sub_category_id', 'image_id','qty'];
    use SoftDeletes;

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class, "image_id");
    }
//    public function images()
//    {
//        return $this->belongsToMany(Image::class, "product_image");
//    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }
}
