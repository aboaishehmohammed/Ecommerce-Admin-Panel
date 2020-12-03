<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    protected $fillable=['upload_path','mime','extension','size'];
    use SoftDeletes;


    public function product()
    {
        return $this->belongsToMany(Product::class, "product_sub_images");
    }
}
