<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Supplier\SupplierCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuppliersCategorySeeder extends Seeder
{
    /* +++++++++++++++++++++ run() +++++++++++++++++++++ */
    public function run()
    {
        // Clear "suppliers_categories" table from database
        DB::table('suppliers_categories')->delete();
        // ========= First suppliers_categories =========
        $adminUser = Admin::where('name','Admin1')->first();
        $suppliers_category1 = new SupplierCategory();
        $suppliers_category1->name = 'لحوم و مجمدات' ;
        $suppliers_category1->com_code = $adminUser->com_code;
        $suppliers_category1->date = date('Y-m-d');
        $suppliers_category1->active = 1;
        $suppliers_category1->added_by = $adminUser->id;
        $suppliers_category1->save();
        // ========= Second suppliers_categories =========
        $adminUser = Admin::where('name','Admin2')->first();
        $suppliers_category2 = new SupplierCategory();
        $suppliers_category2->name = 'فراخ' ;
        $suppliers_category2->com_code = $adminUser->com_code;
        $suppliers_category2->date = date('Y-m-d');
        $suppliers_category2->active = 1;
        $suppliers_category2->added_by = $adminUser->id;
        $suppliers_category2->save();
    }
}
