<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Bill extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'order_status'];
    protected $appends = ['total'];

    public function billProducts()
    {
        return $this->hasMany(BillProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function getTotalAttribute()
    {
        return $this->billProducts()->sum(DB::raw("price*qty"));
    }
}
