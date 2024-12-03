<?php

namespace App\Models\Admin;

use App\Models\Admin;
use App\Models\Location\City;
use App\Models\Location\Country;
use App\Models\Location\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdminPanelSetting extends Model
{
    use HasFactory;
    public $timestamp = true;
    protected $guarded = [];

    // ++++++++++++++++++ Relationship : createdBy ++++++++++++++++++
    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    // ++++++++++++++++++ Relationship : updatedBy ++++++++++++++++++
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
    // ++++++++++++++++++ Relationship : countries ++++++++++++++++++
    public function countries()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    // ++++++++++++++++++ Relationship : states ++++++++++++++++++
    public function states()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    // ++++++++++++++++++ Relationship : cities ++++++++++++++++++
    public function cities()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

}
