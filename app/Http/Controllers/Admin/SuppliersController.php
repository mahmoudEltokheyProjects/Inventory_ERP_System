<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Account\Account;
use App\Models\Supplier\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Http\Requests\SupplierUpdateRequest;
use App\Models\Admin\AdminPanelSetting;
use App\Models\AccountTypes\AccountType;
use App\Models\Supplier\SupplierCategory;

class SuppliersController extends Controller
{
    // ------------------------- index() -------------------------
    public function index()
    {
        $com_code = get_field_value( new Admin() ,'com_code',['id'=>auth()->user()->id]);
        $data = get_cols_where_p( new Supplier() , ['*'] , ['com_code'=>$com_code] , 'id','ASC',PAGINATION_COUNT);
        if( !empty($data) )
        {
            foreach($data as $info)
            {
                // supplier_category
                $info->supplier_category_name = get_field_value( new SupplierCategory() , 'name' , ['id'=>$info->supplier_categories_id]);
                // added_by
                $info->added_by_admin = get_field_value( new Admin() , "name" , ['id'=>$info->added_by] );
                // updated_by
                if( $info->updated_by > 0 && $info->updated_by != null )
                {
                    $info->updated_by_admin = get_field_value( new Admin() , 'name' , ['id'=>$info->updated_by]);
                }
            }
            return view('admin.suppliers.index',['data'=>$data]);
        }
        else
        {
            return redirect()->back()->with('error_msg','غير قادر علي الوصول للبيانات المطلوبة');
        }
    }
    // ------------------------- create() -------------------------
    public function create()
    {
        $com_code = get_field_value( new Admin() ,'com_code',['id'=>auth()->user()->id]);
        $suppliers_categories = get_cols_where( new SupplierCategory() , ['id','name'] , ['com_code'=>$com_code,'active'=>1],'id','ASC');
        return view('admin.suppliers.create',['suppliers_categories'=>$suppliers_categories]);
    }
    // ------------------------- store() -------------------------
    public function store(SupplierRequest $request)
    {
        try
        {
            DB::beginTransaction();
            // "Company Code" of "current login" admin
            $com_code = get_field_value( new Admin() , 'com_code' , ['id'=>auth()->user()->id] );
            $checkExists_name = get_cols_where_row_orderby( new Supplier() ,['id'] , ['name'=>$request->name,'com_code'=>$com_code] );
            // Check "supplier name" exists previously or not
            if( $checkExists_name != null)
            {
                return redirect()->back()->with('error_msg','عفواً اسم المورد موجود مسبقاً');
            }
            else
            {
                // ============ 1- supplier name ============
                $data_insert['name'] = $request->name;
                // ============ 2- supplier_categories_id ============
                $data_insert['supplier_categories_id'] = $request->supplier_categories_id;
                // ============ 3- start_balance_status ============
                $data_insert['start_balance_status'] = $request->start_balance_status;
                // ============ 4- "start_balance_status" ===============
                // 1- start_balance_status == 1 Then "credit" => "دائن"
                if ($data_insert['start_balance_status'] == 1)
                {
                    // لان المستخدم او الموظف هيكون دائن يعني ليه فلوس عند الشركة فهخزن قيمته بالسالب في قاعدة البيانات
                    $data_insert['start_balance'] = $request->start_balance * -1;
                }
                // 2- start_balance_status == 2 Then "debit" => "مدين"
                elseif ($data_insert['start_balance_status'] == 2)
                {
                    // لان المستخدم او الموظف هيكون مدين يعني عليه فلوس للشركة فهخزن قيمته بالموجب في قاعدة البيانات
                    $data_insert['start_balance'] = $request->start_balance;
                }
                // 3- start_balance_status == 3 Then "balanced" => "متزن"
                elseif ($data_insert['start_balance_status'] == 3)
                {
                    $data_insert['start_balance'] = 0;
                }
                // if "start_balance" is empty , set "start_balance" with "0" (will be balanced): لو المستخدم لم يقوم بادخال اي قيمة
                else
                {
                    // 'start_balance_status' will be "balanced"
                    $data_insert['start_balance_status'] = 3;
                    $data_insert['start_balance'] = 0;
                }
                // ============ 5- "supplier_code" : "supplier_code" = "last supplier_code" + 1 ============
                $row = get_cols_where_row_orderby( new Supplier() , ['supplier_code'] , ['com_code'=>$com_code] , 'id' , 'DESC');
                if (!empty($row))
                {
                    $data_insert['supplier_code'] = $row['supplier_code'] + 1;
                }
                else
                {
                    // 'supplier' will be the 'first supplier' then 'supplier_code' = 1
                    $data_insert['supplier_code'] = 1;
                }
                // ============ 2- customer "account_number" : "account_number" = "last account_number" + 1 : هجيب اخر رقم حساب تم اضافته في جدول الحسابات وهزود عليه 1 وهيكون هو رقم حساب المورد في جدول الموردين
                $row = get_cols_where_row_orderby(new Account(), ['account_number'], ['com_code' => $com_code]);
                if (!empty($row))
                {
                    $data_insert['account_number'] = $row['account_number'] + 1;
                }
                else
                {
                    // 'account' will be the 'first account' then 'account_number' = 1
                    $data_insert['account_number'] = 1;
                }
                // 6- active
                $data_insert['active']       = $request->active;
                $data_insert['account_type'] = 1;
                // 7- is_archived
                $data_insert['is_archived']  = $request->is_archived;
                // 8- address
                $data_insert['address']      = $request->address;
                // 9- notes
                $data_insert['notes']        = $request->notes;
                // 10- com_code
                $data_insert['com_code']     = $com_code;
                // 11- date
                $data_insert['date']         = date('Y-m-d');
                // 12- added_by
                $data_insert['added_by']     = auth()->user()->id ;
                // Create New Supplier in suppliers table
                // dd($data_insert);
                $flag = insert_data( new Supplier() , $data_insert);
                // if "supplier_account" is created successfully in "suppliers" table then create it in "accouts" table
                if ($flag)
                {
                    // +++++++++++++++++++ insert "customer" into "accounts" table ++++++++++++++++
                    $data_insert_account['name'] = $request->name;
                    // start_balance_status column
                    $data_insert_account['start_balance_status'] = $request->start_balance_status;
                    // ============ 2- "start_balance_status" ===============
                    // 1- start_balance_status == 1 Then "credit" => "دائن"
                    if ($data_insert_account['start_balance_status'] == 1)
                    {
                        //credit
                        // لان المستخدم او الموظف هيكون دائن يعني ليه فلوس عند الشركة فهخزن قيمته بالسالب في قاعدة البيانات
                        $data_insert_account['start_balance'] = $request->start_balance * (-1);
                    }
                    // 2- start_balance_status == 2 Then "debit" => "مدين"
                    elseif ($data_insert_account['start_balance_status'] == 2)
                    {
                        // لان المستخدم او الموظف هيكون مدين يعني عليه فلوس للشركة فهخزن قيمته بالموجب في قاعدة البيانات
                        $data_insert_account['start_balance'] = $request->start_balance;
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
                    $supplier_parent_account_number = get_field_value(new AdminPanelSetting(), "supplier_parent_account_number", array('com_code' => $com_code));
                    $data_insert_account['notes'] = $request->notes;
                    $data_insert_account['parent_account_number'] = $supplier_parent_account_number;
                    // is_parent :  الحساب ابن وليس اب
                    $data_insert_account['is_parent'] = 0;
                    $data_insert_account['account_number'] = $data_insert['account_number'];
                    // نوع الحساب : مورد
                    $data_insert_account['account_type'] = 1;
                    $data_insert_account['active'] = $request->active;
                    $data_insert_account['is_archived'] = $request->is_archived;
                    $data_insert_account['added_by'] = auth()->user()->id;
                    $data_insert_account['date'] = date("Y-m-d");
                    $data_insert_account['com_code'] = $com_code;
                    // accounts في جدول ال foreign_key هخزن "كود المورد" ك
                    $data_insert_account['other_table_FK'] = $data_insert['supplier_code'];
                    // dd($data_inser‍t_account);
                    $flag = insert_data(new Account(), $data_insert_account);
                }
                DB::commit();
                // Get "id" of "last_added supplier" to make it "selected" in "suppliers" dropdownList in "create" page of "suppliers_order
                $last_supplier_id = Supplier::orderBy('id', 'DESC')->pluck('id')->first();

                $output = [
                    'success' => true,
                    'supplier_id' => $last_supplier_id,
                    'msg' => 'تم تخزين بيانات المورد بنجاح'
                ];
                // if you "add" the "new supplier" from "quick_add" : add new supplier from "supplier_orders" page
                if($request->quick_add)
                {
                    return $output;
                }
                return redirect()->route('admin.suppliers.index')->with('record_added','تم تخزين البيانات بنجاح');
            }
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            dd($e);
            Log::error($e);
            return redirect()->back()->with('error_msg', $e->getMessage());
        }
    }
    // ------------------------- show() -------------------------
    public function show($id)
    {
        // Get "supplier" data
        $data = get_cols_where_row( new Supplier() , ['*'] , ['id' => $id]);
        if( !empty($data) )
        {
            // account_type
            $data->account_types_name = AccountType::where('id', $data->account_type)->value('name');
            // supplier_category_name
            $data->supplier_category_name = SupplierCategory::where('id',$data->supplier_categories_id)->value('name');
            // dd($data->supplier_category_name);
            // added_by_admin
            $data->added_by_admin = Admin::where('id',$data->added_by)->value("name");
            // updated_by_admin
            if( !empty($data->updated_by) && $data->updated_by > 0 )
            {
                $data->updated_by_admin = Admin::where('id',$data->updated_by)->value("name");
            }
            return view('admin.suppliers.show',compact('data'));
        }
    }
    // ------------------------- edit() -------------------------
    public function edit($id)
    {
        $com_code = auth()->user()->com_code;
        // supplier data
        $data = get_cols_where_row( new Supplier() , ['*'] , ['id' => $id ,"com_code" => $com_code]);
        // supplier_categories
        $supplier_categories = get_cols_where( new SupplierCategory() , ['id','name'] , ['com_code'=>$com_code,'active'=>1] ,'id','ASC');
        if( !empty($data) )
        {
            return view('admin.suppliers.edit',compact('data','supplier_categories'));
        }
        else
        {
            return redirect()->back()->with('error_msg','عفواً غير قادر علي الوصول للبيانات المطلوبة');
        }
    }
    // ------------------------- edit() -------------------------
    public function update(SupplierUpdateRequest $request)
    {
        try
        {
            DB::beginTransaction();
            // company code for current login user
            $com_code = auth()->user()->com_code;
            // Get Supplier
            $data = get_cols_where_row( new Supplier() , ['*'] , ['id'=>$request->id , 'com_code'=>$com_code]);
            if( empty($data) )
            {
                return redirect()->route('admin.suppliers.index')->with(['error'=>'عفواً غير قادر علي الوصول للبيانات المطلوبة']);
            }
            // check if supplier "name" exists previously or not
            $checkExists_name = Supplier::where(['name' =>$request->name ,'com_code'=>$com_code])->where('id','!=',$request->id)->first();
            if( $checkExists_name != null)
            {
                return redirect()->back()->with('error_msg','عفواً اسم المورد مسجل مسبقاً')->withInput();
            }
            // ============ update "supplier" data ============
            //  1- name
            $data_to_update['name'] = $request->name ;
            //  2- supplier_categories_id
            $data_to_update['supplier_categories_id'] = $request->supplier_categories_id;
            $data_to_update['active'] = $request->active ;
            $data_to_update['is_archived'] = $request->is_archived ;
            $data_to_update['address'] = $request->address ;
            $data_to_update['notes'] = $request->notes ;
            $data_to_update['updated_by'] = auth()->user()->id ;
            // ===== update "supplier" data =======
            $flag = update_data( new Supplier() , $data_to_update , ['id'=>$request->id , 'com_code'=>$com_code]);
            // if "supplier" is updated successfully , update "supplier_account" in "accounts" table
            if( $flag )
            {
                // update "supplier_account" in "accounts" table
                $data_to_update_account['name']                 = $request->name;
                $data_to_update_account['active']               = $request->active ;
                $data_to_update_account['is_archived']          = $request->is_archived ;
                $data_to_update_account['notes']                = $request->notes ;
                $data_to_update_account['updated_by']           = auth()->user()->id ;
                // update "supplier_account" in "accounts" table : "هحدث "الحساب المالي" المقابل "لحساب المورد" في جدول "الحسابات المالية
                $flag = update_data(new Account() , $data_to_update_account , ['account_number' => $data['account_number'] , 'other_table_FK' => $data['supplier_code'] , 'account_type' => $data['account_type'] , 'com_code' => $com_code ]);
            }
            DB::commit();
            return redirect()->route('admin.suppliers.index')->with('record_updated','تم تحديث البيانات بنجاح');
        }
        catch(\Exception $e)
        {
            DB::rollBack();
            dd($e);
            Log::error($e);
            return redirect()->back()->with('error_msg', $e->getMessage());
        }
    }
    // ------------------------- destroy() -------------------------
    public function destroy(Request $request)
    {
        try
        {
            // Get "supplier" id
            $data = get_cols_where_row(new Supplier() , ['id'] , ['id'=>$request->supplier_id]);
            // Delete "supplier"
            if( !empty($data) )
            {
                $data->delete();
                return redirect()->route('admin.suppliers.index')->with('record_deleted','تم حذف البيانات بنجاح');
            }
            else
            {
                return redirect()->back()->with('error_msg','عفواً حدث خطأ في حذف البيانات');
            }
        }
        catch (\Exception $e)
        {
            dd($e);
            // store "error" in log file
            Log::error($e);
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
    }
    // ++++++++++++++++++++++++++ Search Filters : ajax search +++++++++++++++++
    public function ajax_search(Request $request)
    {
        if($request->ajax())
        {
            // [search_by_text] "inputField value"
            $search_by_text = $request->search_by_text;
            // [search_by_text] "radio button" value
            $search_by_text_radio = $request->search_by_text_radio;
            // +++++++++++++++ Filter 1 : search_by_text +++++++++++++++
            // if search_by_text = "" : بتعها اكبر من 0 فهيجيب كل حاجة id لو حقل البحث "فارغ" هيجيب "كل الحسابات" اللي ال
            if( $search_by_text == "" )
            {
                $field1 = "id";
                $operator1 = ">";
                $value1 = "0";
            }
            else
            {
                // if "search_by_text" using "name"             then $field1 = "اسم الحساب";
                // if "search_by_text" using "account_number"   then $field1 = "رقم الحساب";
                $field1 = $search_by_text_radio;
                $operator1 = "LIKE";
                $value1 = "%{$search_by_text}%";
            }
            // Get "accounts" that "match" the "search value"
            $data = Supplier::where($field1,$operator1,$value1)->orderBy('id','ASC')->paginate(PAGINATION_COUNT);
            // Check if "data" not empty
            if( !empty($data) )
            {
                foreach($data as $info)
                {
                    // Get "added_by" : using "helper function" ==> get_field_value()
                    $info->added_by_admin = get_field_value( new Admin() , "name" , ["id"=>$info->added_by]);
                    // Get "update_by" : using "helper function" ==> get_field_value()
                    if( $info->updated_by > 0 && $info->updated_by != null )
                    {
                        $info->updated_by_admin = get_field_value( new Admin() , "name" , ["id" => $info->updated_by]);
                    }
                }
            }
            return view('admin.suppliers.partials.ajax_search',['data'=>$data]);
        }
    }
}
