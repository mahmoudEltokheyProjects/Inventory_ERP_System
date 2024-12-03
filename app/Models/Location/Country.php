<?php

namespace App\Models\Location;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $guarded = [];
    // ++++++++++++++++++ Relationships +++++++++++++++++
    // ===== states => 1:M =========
    public function states()
    {
        return $this->hasMany(State::class);
    }
    // ===== cities => 1:M =========
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
