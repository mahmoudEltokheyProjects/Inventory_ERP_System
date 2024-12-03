<?php

namespace Database\Seeders;

use App\Models\Admin;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        // +++++++++++++++ admin1 +++++++++++++++
        $admin1 = new Admin();
        $admin1->name = "Admin1";
        $admin1->username = "Admin1";
        $admin1->email = 'admin1@admin1.com';
        $admin1->password = Hash::make('123456789');
        $admin1->com_code = 123456789;
        $admin1->save();
        // +++++++++++++++ admin2 +++++++++++++++
        $admin2 = new Admin();
        $admin2->name = "Admin2";
        $admin2->username = "Admin2";
        $admin2->email = 'admin2@admin2.com';
        $admin2->password = Hash::make('123456789');
        $admin2->com_code = 123456789;
        $admin2->save();
    }
}
