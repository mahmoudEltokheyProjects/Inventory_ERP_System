<?php

namespace Database\Seeders;

use App\Models\Store;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StoreSeeder extends Seeder
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
            $store1 = new Store();
            $store1->name = 'المخزن الاول';
            $store1->active = 1;
            $store1->phone = 0123456;
            $store1->address = "shubraElkheyima/Qalubiya/Egypt";
            $store1->com_code =  $admin_com_code;
            $store1->date = Carbon::now();
            $store1->added_by = $adminUser->id;
            $store1->updated_by = $adminUser->id;
            $store1->save();
        }
        // +++++++++++++++++++++ Store1 +++++++++++++++++++++
        // ============= First "Admin" =============
        $adminUser = \App\Models\Admin::where('username', 'Admin2')->first();
        $admin_com_code = $adminUser->com_code;

        if ($adminUser)
        {
            $store2 = new Store();
            $store2->name = 'المخزن الثاني';
            $store2->active = 0;
            $store2->phone = 0123456;
            $store2->address = "Benha/Qalubiya/Egypt";
            $store2->com_code =  $admin_com_code;
            $store2->date = Carbon::now();
            $store2->added_by = $adminUser->id;
            $store2->updated_by = $adminUser->id;
            $store2->save();
        }
    }
}
