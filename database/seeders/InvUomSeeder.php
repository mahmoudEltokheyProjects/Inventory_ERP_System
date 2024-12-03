<?php

namespace Database\Seeders;

use App\Models\Units\InvUom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InvUomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear "inv_uoms" table
        DB::table('inv_uoms')->delete();
        // +++++++++++++++ Unit 1 ++++++++++++++++++
        // ==== First "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin1')->first();
        $admin_com_code = $adminUser->com_code;

        if( $adminUser )
        {
            $unit1 = new InvUom();
            $unit1->name = 'شكاره';
            $unit1->is_master = 1;
            $unit1->active = 1;
            $unit1->com_code =  $admin_com_code;
            $unit1->date = now();
            $unit1->added_by = $adminUser->id;
            $unit1->updated_by = $adminUser->id;
            $unit1->save();
        }
        // +++++++++++++++ Unit 2 ++++++++++++++++++
        // ==== Second "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin2')->first();
        $admin_com_code = $adminUser->com_code;

        if( $adminUser )
        {
            $unit2 = new InvUom();
            $unit2->name = 'كارتونه';
            $unit2->is_master = 1;
            $unit2->active = 1;
            $unit2->com_code =  $admin_com_code;
            $unit2->date = now();
            $unit2->added_by = $adminUser->id;
            $unit2->updated_by = $adminUser->id;
            $unit2->save();
        }
        // +++++++++++++++ Unit 3 ++++++++++++++++++
        // ==== First "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin1')->first();
        $admin_com_code = $adminUser->com_code;

        if( $adminUser )
        {
            $unit2 = new InvUom();
            $unit2->name = 'طبق واحد كيلو';
            $unit2->is_master = 0;
            $unit2->active = 1;
            $unit2->com_code =  $admin_com_code;
            $unit2->date = now();
            $unit2->added_by = $adminUser->id;
            $unit2->updated_by = $adminUser->id;
            $unit2->save();
        }
        // +++++++++++++++ Unit 4 ++++++++++++++++++
        // ==== First "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin2')->first();
        $admin_com_code = $adminUser->com_code;

        if( $adminUser )
        {
            $unit2 = new InvUom();
            $unit2->name = 'كيلو 90 جرام';
            $unit2->is_master = 0;
            $unit2->active = 1;
            $unit2->com_code =  $admin_com_code;
            $unit2->date = now();
            $unit2->added_by = $adminUser->id;
            $unit2->updated_by = $adminUser->id;
            $unit2->save();
        }
    }
}
