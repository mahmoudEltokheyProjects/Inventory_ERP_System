<?php

namespace App\Models\InvItemCard;

use Illuminate\Database\Eloquent\Model;
use App\Models\ItemCardCategory\InvItemCardCategory;
use App\Models\Units\InvUom;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvItemCard extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $table = "inv_item_cards";
    // ++++++++++++++ Relationship : فئة الصنف +++++++++++++++
    public function inv_item_card_categories()
    {
        return $this->belongsTo(InvItemCardCategory::class,'inv_item_card_categories_id');
    }
    // ++++++++++++++ Relationship : وحدة القياس الاب(الاساسية) +++++++++++++++
    public function inv_uom_parent()
    {
        return $this->belongsTo(InvUom::class,'uom_id');
    }
}
