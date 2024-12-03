<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
    public $timestamp = true;
    // ++++++++++++++++++ Relationship : user ++++++++++++++++++
    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
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
    // ++++++++++++++++++ Relationship : deletedBy ++++++++++++++++++
    public function deletedBy()
    {
        return $this->belongsTo(Admin::class, 'deleted_by');
    }
}
