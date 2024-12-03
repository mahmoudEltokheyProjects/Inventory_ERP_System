<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    // ================== Relationships =================
    // ++++++++++++ state => M:1 ++++++++++++
    public function states()
    {
        return $this->belongsTo(State::class);
    }
}
