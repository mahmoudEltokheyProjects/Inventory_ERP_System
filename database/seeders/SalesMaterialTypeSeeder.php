<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\SalesMaterialType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SalesMaterialTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stores')->delete();
        // +++++++++++++++++++++ Store1 +++++++++++++++++++++
        // ============= First "Admin" =============
        $adminUser = \App\Models\Admin::where('username', 'Admin1')->first();
        $admin_com_code = $adminUser->com_code;

        if ($adminUser)
        {
            $salesMaterialType1 = new SalesMaterialType();
            $salesMaterialType1->name = 'لحوم و مجمدات';
            $salesMaterialType1->active = 1;
            $salesMaterialType1->com_code =  $admin_com_code;
            $salesMaterialType1->date = Carbon::now();
            $salesMaterialType1->added_by = $adminUser->id;
            $salesMaterialType1->updated_by = $adminUser->id;
            $salesMaterialType1->save();
        }
        // +++++++++++++++++++++ Store1 +++++++++++++++++++++
        // ============= First "Admin" =============
        $adminUser = \App\Models\Admin::where('username', 'Admin2')->first();
        $admin_com_code = $adminUser->com_code;

        if ($adminUser)
        {
            $salesMaterialType2 = new SalesMaterialType();
            $salesMaterialType2->name = 'فراخ';
            $salesMaterialType2->active = 1;
            $salesMaterialType2->com_code =  $admin_com_code;
            $salesMaterialType2->date = Carbon::now();
            $salesMaterialType2->added_by = $adminUser->id;
            $salesMaterialType2->updated_by = $adminUser->id;
            $salesMaterialType2->save();
        }
    }
}
