<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BillProduct extends Model
{
    protected $fillable = [ "product_id","bill_id", "qty","price","rate"];
    use SoftDeletes;

    public function product()
    {
        return $this->belongsTo(Product::class)->select(["id", "name","price"])->withTrashed();

    }

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }


}
