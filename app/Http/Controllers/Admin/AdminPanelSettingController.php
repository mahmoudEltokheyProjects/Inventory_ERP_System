<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminPanelSettingRequest;
use App\Models\Account\Account;
use App\Models\Admin;
use App\Models\Admin\AdminPanelSetting;
use App\Models\Location\City;
use App\Models\Location\Country;
use App\Models\Location\State;

class AdminPanelSettingController extends Controller
{
    // =================== index() ===================
    public function index()
    {
        $data = AdminPanelSetting::where('com_code',auth()->user()->com_code)->first();
        // customer_parent_account_name الحساب المالي الاب للعملاء
        $data["customer_parent_account_name"] = Account::where('account_number',$data['customer_parent_account_number'])->value('name');
        // supplier_parent_account_name الحساب المالي الاب للموردين
        $data["supplier_parent_account_name"] = Account::where('account_number',$data['supplier_parent_account_number'])->value('name');
        if( !empty($data) )
        {
            if( $data['updated_by'] > 0 && $data['updated_by'] != null )
            {
                // Get "name" of last updated by user
                $data["updated_by_admin"] = Admin::where('id',$data['updated_by'])->value('name');

            }
        }

        return view('admin.admin_panel_settings.index',['data'=>$data]);
    }
    // =================== edit() ===================
    public function edit()
    {
        $data = AdminPanelSetting::where('com_code', auth()->user()->com_code)->first();
        // dd($data);
        $com_code = auth()->user()->com_code;
        $countries = Country::pluck('name','id');
        $states = State::where('country_id', $data->country_id)->pluck('name', 'id');
        $cities = City::where('state_id', $data->state_id)->pluck('name', 'id');
        // dd($countries);
        $parent_accounts = get_cols_where( new Account() , ['account_number','name'],['is_parent' => 1 , 'com_code' =>$com_code],'id','ASC');
        return view('admin.admin_panel_settings.edit',
                            [ 'data' => $data,'parent_accounts'=>$parent_accounts,
                                    "countries"=>$countries,'states' => $states,
                                    'cities' => $cities
                                ]);
    }
    // =================== update(Request $request) ===================
    public function update(AdminPanelSettingRequest $request)
    {
        try
        {
            // Get data of panel setting of the user from "admin_panel_settings Table" with 'com_code' == 'com_code" of logged in user"
            $admin_panel_setting = AdminPanelSetting::where('com_code',auth()->user()->com_code)->first();
            // 1- update "system_name" with the "new system_name" value from "edit page"
            $admin_panel_setting->system_name = $request->system_name ;
            // 2- update "address" with the "new address" value from "edit page"
            $admin_panel_setting->address = $request->address ;
            // 3- update "phone" with the "new phone" value from "edit page"
            $admin_panel_setting->phone = $request->phone ;
            // 3- update "email" with the "new email" value from "edit page"
            $admin_panel_setting->email = $request->email ;
            // 3- update "country_id" with the "new country_id" value from "edit page"
            $admin_panel_setting->country_id = $request->country_id ;
            // 3- update "state_id" with the "new state_id" value from "edit page"
            $admin_panel_setting->state_id = $request->state_id ;
            // 3- update "city_id" with the "new city_id" value from "edit page"
            $admin_panel_setting->city_id = $request->city_id ;
            // 4- update "general_alert" with the "new general_alert" value from "edit page"
            $admin_panel_setting->general_alert = $request->general_alert ;
            // 4- update "customer_parent_account_number" with the "new customer_parent_account_number" value from "edit page"
            $admin_panel_setting->customer_parent_account_number = $request->customer_parent_account_number ;
            // 4- update "supplier_parent_account_number" with the "new supplier_parent_account_number" value from "edit page"
            $admin_panel_setting->supplier_parent_account_number = $request->supplier_parent_account_number ;
            // 5- update "updated_by" with the "user id" value from "edit page" Which "logged in"
            $admin_panel_setting->updated_by = auth()->user()->id ;
            // 6- update "updated_at" with the "current date and time"
            $admin_panel_setting->updated_at = date("Y-m-d H:i:s");
            // 7- Save the "old photo" in variable
            $old_photo = $admin_panel_setting->photo;
            // 7- Save the "old logo" in variable
            $old_logo = $admin_panel_setting->logo;
            // 8- Check if the 'user' Upload "new image" during Update or "Not"
                // 7.1- if user "Upload new image" during Update , Make Some Validation on "Uploaded photo"
                // "image rules" :  1- image required to be uploaded
                                 // 2- file Type of image must be "png" or "jpg" or "jpeg"
                                 // 3- maximum image size must be is 2000

            // ++++++++++++++ update "photo" image : if you upload "new photo" , update photo ++++++++++++++
            if( $request->hasFile('photo') )
            {
                $request->validate([
                    'photo' => 'required|mimes:png,jpg,jpeg|max:2000'
                ]);
                $photo_name = $request->file('photo')->getClientOriginalName();
                // ======== Update "photo name" in DB ========
                $admin_panel_setting->photo = $photo_name;
                // Check if the "old photo" exists in "assets/admin/uploads/" , Remove the "old photo"
                // ======== Delete "old logo" from Disk ========
                deleteFile($old_photo,'uploads');
                // ======== Upload "new logo" on Disk ========
                uploadFile($request,'photo','uploads');
            }
            // ++++++++++++++ update "logo" image : if you upload "new logo" , update logo ++++++++++++++
            if( $request->hasFile('logo') )
            {
                $request->validate([
                    'logo' => 'required|mimes:png,jpg,jpeg|max:2000'
                ]);
                $logo_name = $request->file('logo')->getClientOriginalName();
                // ======== Update "logo name" in DB ========
                $admin_panel_setting->logo = $logo_name;
                // Check if the "old logo" exists in "assets/admin/uploads/" , Remove the "old logo"
                // ======== Delete "old logo" from Disk ========
                deleteFile($old_logo,'uploads');
                // ======== Upload "new logo" on Disk ========
                uploadFile($request,'logo','uploads');
            }
            $admin_panel_setting->save();
            return redirect()->route("admin.adminPanelSetting.index")->with(['update'=>'تم تحديث البيانات بنجاح']);
        }
        catch(\Exception $e)
        {
            // dd($e);
            // redirect to "main page" with "error message"
            return redirect()->route("admin.adminPanelSetting.index")->with(['error'=>'عفواً حدث خطاء ما'.$e->getMessage()]);
        }
    }
    // ================== Location : countries , states , cities ==================
    // ++++++++++++++ fetchState(): to get "states" of "selected country" selectbox ++++++++++++++
    public function fetchStates(Request $request)
    {
        // return($request);
        $data['states'] = State::where('country_id', $request->country_id)->get(['id','name']);
        return response()->json($data);
    }
    // ++++++++++++++ fetchCity(): to get "cities" of "selected state" selectbox ++++++++++++++
    public function fetchCities(Request $request)
    {
        $data['cities'] = City::where('state_id', $request->state_id)->get(['id','name']);
        return response()->json($data);
    }

}
