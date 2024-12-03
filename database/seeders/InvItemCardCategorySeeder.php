<?php

namespace Database\Seeders;

use App\Models\ItemCardCategory\InvItemCardCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InvItemCardCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear "inv_item_card_categories" Table
        DB::table('inv_item_card_categories')->delete();
        // +++++++++++++++ Item 1 ++++++++++++++++++
        // ==== First "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin1')->first();
        $admin_com_code = $adminUser->com_code;
        if( $adminUser )
        {
            $item1 = new InvItemCardCategory();
            $item1->name = "لحوم و مجمدات";
            $item1->active = 1;
            $item1->com_code = $admin_com_code;
            $item1->date = now();
            $item1->added_by = $adminUser->id;
            $item1->save();
        }
        // +++++++++++++++ Item 2 ++++++++++++++++++
        // ==== First "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin2')->first();
        $admin_com_code = $adminUser->com_code;
        if( $adminUser )
        {
            $item2 = new InvItemCardCategory();
            $item2->name = "فراخ";
            $item2->active = 1;
            $item2->com_code = $admin_com_code;
            $item2->date = now();
            $item2->added_by = $adminUser->id;
            $item2->save();
        }
    }
}
