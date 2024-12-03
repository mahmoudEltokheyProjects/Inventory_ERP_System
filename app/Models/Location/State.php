<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;
    protected $guarded = [];
    // ================== Relationships =================
    // ++++++++++++ countries => M:1 ++++++++++++
    public function countries()
    {
        return $this->belongsTo(City::class);
    }
    // ++++++++++++ cities => 1:M ++++++++++++
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
