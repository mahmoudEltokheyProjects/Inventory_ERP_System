<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuppliersWithOrder extends Model
{
    use HasFactory;
    public $table = "supplier_with_orders";
    protected $guarded = [];

}
