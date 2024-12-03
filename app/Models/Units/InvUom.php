<?php

namespace App\Models\Units;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ++++++++++++++ 'Uom" => Unit of measurement ++++++++++++++
class InvUom extends Model
{
    use HasFactory;
    protected $table = "inv_uoms";
    protected $guarded = [];
}
