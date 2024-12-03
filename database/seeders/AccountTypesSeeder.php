<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\AccountTypes\AccountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccountTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear "account_types" table
        DB::table('account_types')->delete();
        // ++++++++++++++++++++++ first "account_types" ++++++++++++++++++++++
        // ==== First "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin1')->first();
        $account_types1 = new AccountType();
        $account_types1->name = "مورد";
        $account_types1->relatedInternalAccounts = 1;
        $account_types1->added_by   = $adminUser->id;
        $account_types1->updated_by = $adminUser->id;
        $account_types1->active = 1;
        $account_types1->active = 1;
        $account_types1->save();
        // ++++++++++++++++++++++ second "account_types" ++++++++++++++++++++++
        // ==== Second "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin2')->first();
        $account_types2 = new AccountType();
        $account_types2->name = "عميل";
        $account_types2->relatedInternalAccounts = 1;
        $account_types2->added_by   = $adminUser->id;
        $account_types2->updated_by = $adminUser->id;
        $account_types2->active = 1;
        $account_types2->save();
        // ++++++++++++++++++++++ third "account_types" ++++++++++++++++++++++
        // ==== First "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin1')->first();
        $account_types3 = new AccountType();
        $account_types3->name = "مندوب";
        $account_types3->relatedInternalAccounts = 1;
        $account_types3->added_by   = $adminUser->id;
        $account_types3->updated_by = $adminUser->id;
        $account_types3->active = 1;
        $account_types3->save();
        // ++++++++++++++++++++++ fourth "account_types" ++++++++++++++++++++++
        // ==== Second "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin2')->first();
        $account_types3 = new AccountType();
        $account_types3->name = "بنكي";
        $account_types3->relatedInternalAccounts = 0;
        $account_types3->added_by   = $adminUser->id;
        $account_types3->updated_by = $adminUser->id;
        $account_types3->active = 1;
        $account_types3->save();
        // ++++++++++++++++++++++ fifth "account_types" ++++++++++++++++++++++
        // ==== First "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin1')->first();
        $account_types4 = new AccountType();
        $account_types4->name = "موظف";
        $account_types4->relatedInternalAccounts = 1;
        $account_types4->added_by   = $adminUser->id;
        $account_types4->updated_by = $adminUser->id;
        $account_types4->active = 1;
        $account_types4->save();
        // ++++++++++++++++++++++ sixth "account_types" ++++++++++++++++++++++
        // ==== Second "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin2')->first();
        $account_types5 = new AccountType();
        $account_types5->name = "عام";
        $account_types5->relatedInternalAccounts = 1;
        $account_types5->added_by   = $adminUser->id;
        $account_types5->updated_by = $adminUser->id;
        $account_types5->active = 1;
        $account_types5->save();
        // ++++++++++++++++++++++ seventh "account_types" ++++++++++++++++++++++
        // ==== First "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin1')->first();
        $account_types6 = new AccountType();
        $account_types6->name = "مصروفات";
        $account_types6->relatedInternalAccounts = 0;
        $account_types6->added_by   = $adminUser->id;
        $account_types6->updated_by = $adminUser->id;
        $account_types6->active = 1;
        $account_types6->save();
        // ++++++++++++++++++++++ eighth "account_types" ++++++++++++++++++++++
        // ==== second "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin2')->first();
        $account_types6 = new AccountType();
        $account_types6->name = "قسم داخلي";
        $account_types6->relatedInternalAccounts = 1;
        $account_types6->added_by   = $adminUser->id;
        $account_types6->updated_by = $adminUser->id;
        $account_types6->active = 1;
        $account_types6->save();
        // ++++++++++++++++++++++ ninth "account_types" ++++++++++++++++++++++
        // ==== First "Admin" ====
        $adminUser = \App\Models\Admin::where('username', 'Admin1')->first();
        $account_types6 = new AccountType();
        $account_types6->name = "راس المال";
        $account_types6->relatedInternalAccounts = 0;
        $account_types6->added_by   = $adminUser->id;
        $account_types6->updated_by = $adminUser->id;
        $account_types6->active = 1;
        $account_types6->save();


    }
}
