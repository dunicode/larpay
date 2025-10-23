<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\OrderProduct;

class Order extends Model
{
    protected $fillable = ['user_id', 'amount', 'status', 'stripe_id', 'currency_id'];

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }
}
