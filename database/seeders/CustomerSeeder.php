<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /* ===================== run() ===================== */
    public function run()
    {
        // ++++++++++++++++ delete "customer" data ++++++++++++++++
        DB::table('customers')->delete();
        // ++++++++++++++++ Customer 1 ++++++++++++++++
        $adminUser1 = \App\Models\Admin::where('username', 'Admin1')->first();
        $customer1 = new Customer();
        $customer1->name = 'هايبر الرحاب';
        $customer1->active = 1 ;
        $customer1->is_archived = 0;
        $customer1->com_code = $adminUser1->com_code;
        $customer1->customer_code = 1;
        $customer1->is_city = 0;
        $customer1->address = "سوهاج - كوبري النيل";
        $customer1->account_type = 2;
        $customer1->is_parent = 0;
        $customer1->account_number = 5;
        $customer1->start_balance_status = 1;
        $customer1->start_balance = -1000;
        $customer1->current_balance = 1000;
        $customer1->notes = "ملاحظات 1";
        $customer1->date = date('Y-m-d');
        $customer1->created_at = now();
        $customer1->updated_at = now();
        $customer1->added_by = $adminUser1->id;
        $customer1->updated_by = $adminUser1->id;
        $customer1->save();
        // ++++++++++++++++ Customer 2 ++++++++++++++++
        $adminUser2 = \App\Models\Admin::where('username', 'Admin2')->first();
        $customer2 = new Customer();
        $customer2->name = 'سوبر ماركت السلامة';
        $customer2->active = 1 ;
        $customer2->is_archived = 0;
        $customer2->com_code = $adminUser2->com_code;
        $customer2->customer_code = 2;
        $customer2->is_city = 1;
        $customer2->address = "القاهرة - مدينة نصر";
        $customer2->account_type = 2;
        $customer2->is_parent = 0;
        $customer2->account_number = 6;
        $customer2->start_balance_status = 2;
        $customer2->start_balance = 2000;
        $customer2->current_balance = 2000;
        $customer2->notes = "ملاحظات 2";
        $customer2->date = date('Y-m-d');
        $customer2->created_at = now();
        $customer2->updated_at = now();
        $customer2->added_by = $adminUser2->id;
        $customer2->updated_by = $adminUser2->id;
        $customer2->save();
    }
}
