<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminPanelSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_panel_settings')->delete();
        // +++++++++++++++ admin1 +++++++++++++++
        $admin_panel_setting1 = new \App\Models\Admin\AdminPanelSetting();
        $admin_panel_setting1->system_name = "حلول-للكمبيوتر";
        $admin_panel_setting1->active = 1;
        $admin_panel_setting1->general_alert = "حلول-للكمبيوتر";
        $admin_panel_setting1->country_id = 64;
        $admin_panel_setting1->state_id = 1058;
        $admin_panel_setting1->city_id = 15476;
        $admin_panel_setting1->address = "ش سوهاج-كوبري النيل 65";
        $admin_panel_setting1->phone = "0123456789";
        $admin_panel_setting1->photo = "header-bk1.jpeg";
        $admin_panel_setting1->email = "mahmoudtokhey@gmail.com";
        $admin_panel_setting1->logo = "logo.png";
        $admin_panel_setting1->customer_parent_account_number = 4;
        $admin_panel_setting1->supplier_parent_account_number = 5;
        $admin_panel_setting1->com_code = 123456789;
        $admin_panel_setting1->created_by = 1;
        $admin_panel_setting1->save();
    }
}
