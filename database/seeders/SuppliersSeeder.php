<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Account\Account;
use Illuminate\Database\Seeder;
use App\Models\Supplier\Supplier;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\AdminPanelSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuppliersSeeder extends Seeder
{
    /* ++++++++++++++++++++++ run() ++++++++++++++++++++++ */
    public function run()
    {
        // clear "suppliers" table
        DB::table('suppliers')->delete();
        // ================================ First Supplier ================================
        // ++++++++++++++++ insert "Supplier" into "accounts" table ++++++++++++++++
        $admin = get_cols_where_row( new Admin() , ['*'] , ['name'=>"Admin1"] );
        $supplier1 = new Supplier();
        $supplier1->name = "محمد المشهدي";
        $supplier1->supplier_categories_id = 1 ;
        $supplier1->active = 1 ;
        $supplier1->is_archived = 0 ;
        $supplier1->com_code = $admin->com_code;
        $supplier1->supplier_code = 1 ;
        $supplier1->account_number = 20 ;
        $supplier1->account_type = 1 ;
        $supplier1->is_city = 1 ;
        $supplier1->address = "Cairo, Giza";
        $supplier1->start_balance_status = 1;
        $supplier1->start_balance = -10;
        $supplier1->current_balance = 1000;
        $supplier1->date = date('Y-m-d');
        $supplier1->created_at = now();
        $supplier1->updated_at = now();
        $supplier1->notes = "notes1";
        $supplier1->supplier_categories_id  = 1;
        $supplier1->added_by = $admin->id;
        $supplier1->save();
        // ++++++++++++++++ insert "Supplier" into "accounts" table ++++++++++++++++
        $data_insert_account['name'] = $supplier1->name;
        // ==== 2- "start_balance_status" ====
        $data_insert_account['start_balance_status'] = $supplier1->start_balance_status;
        // 1- start_balance_status == 1 Then "credit" => "دائن"
        if ($data_insert_account['start_balance_status'] == 1)
        {
            //credit
            // لان المستخدم او الموظف هيكون دائن يعني ليه فلوس عند الشركة فهخزن قيمته بالسالب في قاعدة البيانات
            $data_insert_account['start_balance'] = $supplier1->start_balance * (-1);
        }
        // 2- start_balance_status == 2 Then "debit" => "مدين"
        elseif ($data_insert_account['start_balance_status'] == 2)
        {
            // لان المستخدم او الموظف هيكون مدين يعني عليه فلوس للشركة فهخزن قيمته بالموجب في قاعدة البيانات
            $data_insert_account['start_balance'] = $supplier1->start_balance;
        }
        // 3- start_balance_status == 3 Then "balanced" => "متزن"
        elseif ($data_insert_account['start_balance_status'] == 3)
        {
            //balanced
            $data_insert_account['start_balance'] = 0;
        }
        // if "start_balance" is empty , set "start_balance" with "0" (will be balanced): لو المستخدم لم يقوم بادخال اي قيمة
        else
        {
            $data_insert_account['start_balance_status'] = 3;
            $data_insert_account['start_balance'] = 0;
        }
        $data_insert_account['current_balance'] = $data_insert_account['start_balance'];
        // parent_account_number : رقم الحساب الاب للموردين هجيبه من الاعدادات العامة للادمن
        $supplier_parent_account_number = get_field_value(new AdminPanelSetting(), "supplier_parent_account_number", array('com_code' => $admin->com_code));
        $data_insert_account['notes'] = $supplier1->notes;
        $data_insert_account['parent_account_number'] = $supplier_parent_account_number;
        // is_parent :  الحساب ابن وليس اب
        $data_insert_account['is_parent'] = 0;
        $data_insert_account['account_number'] = $supplier1->account_number;
        // نوع الحساب : مورد
        $data_insert_account['account_type'] = 1;
        $data_insert_account['active'] = $supplier1->active;
        $data_insert_account['is_archived'] = $supplier1->is_archived;
        $data_insert_account['added_by'] = $admin->id;
        $data_insert_account['date'] = date("Y-m-d");
        $data_insert_account['created_at'] = now();
        $data_insert_account['com_code'] = $admin->com_code;
        // accounts في جدول ال foreign_key هخزن "كود المورد" ك
        $data_insert_account['other_table_FK'] = $supplier1['supplier_code'];
        // insert "supplier account" into "accounts" table
        Account::insert($data_insert_account);
    }
}
