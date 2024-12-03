<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierWithOrder extends Model
{
    use HasFactory;
    protected $table = "supplier_with_orders";
    protected $guarded = [];
    
}
