<?php

namespace Database\Seeders;

use App\Models\InvItemCard\InvItemCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvItemCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear "inv_item_cards" table
        DB::table('inv_item_cards')->delete();
        // +++++++++++++++ Item_Card 1 ++++++++++++++++++
        // ==== First "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin1')->first();
        $admin_com_code = $adminUser->com_code;
        if( $adminUser )
        {
            $item1 = new InvItemCard();
            $item1->name = "لحم سوداني مجمد";
            $item1->item_code = 1;
            $item1->item_type = 2;
            $item1->barcode = 1;
            $item1->parent_inv_item_card_id = null;
            $item1->does_has_retail_unit = 1;
            $item1->retail_uom_to_uom = 10;
            $item1->quantity = 1;
            $item1->quantity_retail = 1;
            $item1->quantity_all_retail = 1;
            $item1->price = 1;
            $item1->gomla_price = 1;
            $item1->nos_gomla_price = 1;
            $item1->price_retail = 1;
            $item1->gomla_price_retail = 1;
            $item1->nos_gomla_price_retail = 1;
            $item1->cost_price = 1;
            $item1->cost_price_retail = 1;
            $item1->active = 1;
            $item1->date = now();
            $item1->com_code = $admin_com_code;
            $item1->inv_item_card_categories_id = 1;
            $item1->retail_uom_id = 3;
            $item1->uom_id  = 1;
            $item1->has_fixed_price = 1;
            $item1->added_by = $adminUser->id;
            $item1->save();
        }
        // +++++++++++++++ Item_Card 2 ++++++++++++++++++
        // ==== Second "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin2')->first();
        $admin_com_code = $adminUser->com_code;
        if( $adminUser )
        {
            $item1 = new InvItemCard();
            $item1->name = "فراخ شهد";
            $item1->item_code = 1;
            $item1->item_type = 2;
            $item1->barcode = 2;
            $item1->parent_inv_item_card_id = null;
            $item1->does_has_retail_unit = 1;
            $item1->retail_uom_to_uom = 10;
            $item1->quantity = 1;
            $item1->quantity_retail = 1;
            $item1->quantity_all_retail = 1;
            $item1->price = 1;
            $item1->gomla_price = 1;
            $item1->nos_gomla_price = 1;
            $item1->price_retail = 1;
            $item1->gomla_price_retail = 1;
            $item1->nos_gomla_price_retail = 1;
            $item1->cost_price = 1;
            $item1->cost_price_retail = 1;
            $item1->active = 1;
            $item1->date = now();
            $item1->com_code = $admin_com_code;
            $item1->inv_item_card_categories_id = 2;
            $item1->retail_uom_id = 3;
            $item1->uom_id  = 2;
            $item1->has_fixed_price = 1;

            $item1->added_by = $adminUser->id;
            $item1->save();
        }
        // +++++++++++++++ Item_Card 3 ++++++++++++++++++
        // ==== First "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin1')->first();
        $admin_com_code = $adminUser->com_code;
        if( $adminUser )
        {
            $item1 = new InvItemCard();
            $item1->name = "وراك شهد";
            $item1->item_code = 3;
            $item1->item_type = 2;
            $item1->barcode = 3;
            $item1->parent_inv_item_card_id = 2;
            $item1->does_has_retail_unit = 1;
            $item1->retail_uom_to_uom = 10;
            $item1->quantity = 1;
            $item1->quantity_retail = 1;
            $item1->quantity_all_retail = 1;
            $item1->price = 1;
            $item1->gomla_price = 1;
            $item1->nos_gomla_price = 1;
            $item1->price_retail = 1;
            $item1->gomla_price_retail = 1;
            $item1->nos_gomla_price_retail = 1;
            $item1->cost_price = 1;
            $item1->cost_price_retail = 1;
            $item1->has_fixed_price = 1;
            $item1->active = 1;
            $item1->date = now();
            $item1->com_code = $admin_com_code;
            $item1->inv_item_card_categories_id = 2;
            $item1->retail_uom_id = 3;
            $item1->uom_id  = 2;
            $item1->added_by = $adminUser->id;
            $item1->save();
        }
    }
}
