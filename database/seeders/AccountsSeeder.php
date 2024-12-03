<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Account\Account;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear "accounts" table
        DB::table('accounts')->delete();
        // ============= First Account =============
        $adminUser = Admin::where('username', 'Admin1')->first();
        $account1 = new Account();
        $account1->name                  = "راس المال";
        $account1->active                = 1;
        $account1->is_archived           = 0;
        $account1->com_code              = $adminUser->com_code;
        $account1->account_type          = 6;
        $account1->is_parent	         = 1;
        $account1->parent_account_number = null;
        $account1->account_number        = 1;
        $account1->start_balance_status  = 1;
        $account1->start_balance         = 80;
        $account1->current_balance       = 1800;
        $account1->notes                 = "Notes";
        $account1->date                  = date('Y-m-d');
        $account1->added_by              = $adminUser->id;
        $account1->updated_by            = $adminUser->id;
        $account1->save();
        // ============= Second Account =============
        $adminUser = Admin::where('username', 'Admin1')->first();
        $account2 = new Account();
        $account2->name                  = "المصروفات الاب";
        $account2->active                = 1;
        $account2->is_archived           = 0;
        $account2->com_code              = $adminUser->com_code;
        $account2->account_type          = 7;
        $account2->is_parent	         = 1;
        $account2->parent_account_number = null;
        $account2->account_number        = 2;
        $account2->start_balance_status  = 2;
        $account2->start_balance         = 300;
        $account2->current_balance       = 2000;
        $account2->notes                 = "Notes";
        $account2->date                  = date('Y-m-d');
        $account2->added_by              = $adminUser->id;
        $account2->updated_by            = $adminUser->id;
        $account2->save();
        // ============= Third Account =============
        $adminUser = Admin::where('username', 'Admin1')->first();
        $account3 = new Account();
        $account3->name                  = "فواتير هاتف و انترنت";
        $account3->active                = 1;
        $account3->is_archived           = 0;
        $account3->com_code              = $adminUser->com_code;
        $account3->account_type          = 4;
        $account3->is_parent	         = 0;
        $account3->parent_account_number = 2;
        $account3->account_number        = 3;
        $account3->start_balance_status  = 3;
        $account3->start_balance         = 0;
        $account3->current_balance       = 3000;
        $account3->notes                 = "Notes";
        $account3->date                  = date('Y-m-d');
        $account3->added_by              = $adminUser->id;
        $account3->updated_by            = $adminUser->id;
        $account3->save();
        // ============= fourth Account =============
        $adminUser = Admin::where('username', 'Admin1')->first();
        $account4 = new Account();
        $account4->name                  = "العملاء الاب";
        $account4->active                = 1;
        $account4->is_archived           = 0;
        $account4->com_code              = $adminUser->com_code;
        $account4->account_type          = 2;
        $account4->is_parent	         = 1;
        $account4->parent_account_number = 2;
        $account4->account_number        = 4;
        $account4->start_balance_status  = 1;
        $account4->start_balance         = 500;
        $account4->current_balance       = 4000;
        $account4->notes                 = "Notes";
        $account4->date                  = date('Y-m-d');
        $account4->added_by              = $adminUser->id;
        $account4->updated_by            = $adminUser->id;
        $account4->save();
        // ============= sixth Account =============
        $adminUser = Admin::where('username', 'Admin1')->first();
        $account5  = new Account();
        $account5->name                  = "الموردين الاب";
        $account5->active                = 1;
        $account5->is_archived           = 0;
        $account5->com_code              = $adminUser->com_code;
        $account5->account_type          = 1;
        $account5->is_parent	         = 1;
        $account5->parent_account_number = 2;
        $account5->account_number        = 5;
        $account5->start_balance_status  = 2;
        $account5->start_balance         = -1500;
        $account5->current_balance       = 5000;
        $account5->notes                 = "Notes";
        $account5->date                  = date('Y-m-d');
        $account5->added_by              = $adminUser->id;
        $account5->updated_by            = $adminUser->id;
        $account5->save();
    }
}
