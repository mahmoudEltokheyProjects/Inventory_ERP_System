<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Carbon;

class TreasurySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('treasuries')->delete();

        // ============= First "Admin" =============
        $adminUser = \App\Models\Admin::where('username', 'Admin1')->first();
        if ($adminUser)
        {
            $treasury1 = new \App\Models\Treasury\Treasury();
            $treasury1->name = "الرئيسية";
            $treasury1->is_master = 1;
            $treasury1->active = 1;
            $treasury1->last_isal_exchange = 1;
            $treasury1->last_isal_collect = 1;
            $treasury1->com_code = 1;
            $treasury1->date = Carbon::now();
            $treasury1->added_by = $adminUser->id;
            $treasury1->updated_by = $adminUser->id;
            $treasury1->save();
        }
        // ============= Second "Admin" =============
        $adminUser2 = \App\Models\Admin::where('username', 'Admin2')->first();
        if ($adminUser2)
        {
            $treasury2 = new  \App\Models\Treasury\Treasury();
            $treasury2->name = "فرعية";
            $treasury2->is_master = 0;
            $treasury2->active = 0;
            $treasury2->last_isal_exchange = 2;
            $treasury2->last_isal_collect = 2;
            $treasury2->com_code = 2;
            $treasury2->date = Carbon::now();
            $treasury2->added_by = $adminUser2->id;
            $treasury2->updated_by = $adminUser2->id;
            $treasury2->save();
        }
        // ============= Third "Admin" =============
        $adminUser3 = \App\Models\Admin::where('username', 'Admin1')->first();
        if ($adminUser3)
        {
            $treasury3 = new  \App\Models\Treasury\Treasury();;
            $treasury3->name = "خزنة كاشير1";
            $treasury3->is_master = 1;
            $treasury3->active = 1;
            $treasury3->last_isal_exchange = 3;
            $treasury3->last_isal_collect = 3;
            $treasury3->com_code = 3;
            $treasury3->date = Carbon::now();
            $treasury3->added_by = $adminUser3->id;
            $treasury3->updated_by = $adminUser3->id;
            $treasury3->save();
        }
        // ============= Fourth "Admin" =============
        $adminUser4 = \App\Models\Admin::where('username', 'Admin2')->first();
        if ($adminUser4)
        {
            $treasury4 = new  \App\Models\Treasury\Treasury();
            $treasury4->name = "خزنة كاشير2";
            $treasury4->is_master = 0;
            $treasury4->active = 0;
            $treasury4->last_isal_exchange = 4;
            $treasury4->last_isal_collect = 4;
            $treasury4->com_code = 4;
            $treasury4->date = Carbon::now();
            $treasury4->added_by = $adminUser4->id;
            $treasury4->updated_by = $adminUser4->id;
            $treasury4->save();
        }
        // ============= Fifth "Admin" =============
        $adminUser5 = \App\Models\Admin::where('username', 'Admin1')->first();
        if ($adminUser5)
        {
            $treasury5 = new  \App\Models\Treasury\Treasury();
            $treasury5->name = "خزنة كاشير3";
            $treasury5->is_master = 1;
            $treasury5->active = 1;
            $treasury5->last_isal_exchange = 5;
            $treasury5->last_isal_collect = 5;
            $treasury5->com_code = 5;
            $treasury5->date = Carbon::now();
            $treasury5->added_by = $adminUser5->id;
            $treasury5->updated_by = $adminUser5->id;
            $treasury5->save();
        }
    }
}
