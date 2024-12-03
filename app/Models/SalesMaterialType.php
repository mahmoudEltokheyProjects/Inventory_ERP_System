<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesMaterialType extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "sales_material_types";
    public $timestamp = true;

}
