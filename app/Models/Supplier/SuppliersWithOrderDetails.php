<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliersWithOrderDetails extends Model
{
    use HasFactory;
    public $guarded = [];
    public $table = "suppliers_with_orders_details";
}
