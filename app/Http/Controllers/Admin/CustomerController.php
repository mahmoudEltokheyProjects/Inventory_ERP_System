<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Account\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\Admin\AdminPanelSetting;
use App\Models\AccountTypes\AccountType;
use App\Http\Requests\CustomerUpdateRequest;

class CustomerController extends Controller
{
    /* ++++++++++++++++++++ index() ++++++++++++++++++++ */
    public function index()
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_p( new Customer() , ["*"] , ["com_code"=>$com_code] , "id" , "ASC",PAGINATION_COUNT);
        if( empty($data) || $data == null )
        {
            return redirect()->back()->with('error','لا توجد بيانات');
        }
        foreach($data as $info)
        {
            // added_by
            $info['added_by_admin'] = get_field_value( new Admin() , 'name' , ['id'=>$info->added_by] );
            if( $info->updated_by > 0 && $info->updated_by != null )
            {
                // updated_by
                $info['updated_by_admin'] = get_field_value( new Admin() , 'name' , ['id'=>$info->updated_by] );
            }
        }

        return view('admin.customers.index',compact('data'));
    }
    /* ++++++++++++++++++++ create() ++++++++++++++++++++ */
    public function create()
    {
        return view('admin.customers.create');
    }
    /* ++++++++++++++++++++ create() ++++++++++++++++++++ */
    public function store(CustomerRequest $request)
    {
        try
        {
            DB::beginTransaction();
            // company code
            $com_code = auth()->user()->com_code;
            $checkExists = get_cols_where_row( new Customer() , ['id'],['name'=>$request->input('name'),'com_code'=>$com_code]);
            // if "customer name" is not exist previously
            if( $checkExists == null )
            {
                // ============ 1- "customer_code" : "customer_code" = "last customer_code" + 1 ============
                $row = get_cols_where_row_orderby(new Customer(), ['customer_code'], ['com_code' => $com_code]);
                if (!empty($row))
                {
                    $data_insert['customer_code'] = $row['customer_code'] + 1;
                }
                else
                {
                    // 'customer' will be the 'first customer' then 'customer_code' = 1
                    $data_insert['customer_code'] = 1;
                }
                // ============ 2- customer "account_number" : "account_number" = "last account_number" + 1 : هجيب اخر رقم حساب تم اضافته في جدول الحسابات وهزود عليه 1 وهيكون هو رقم حساب العميل في جدول العملاء
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
                // start_balance_status column
                $data_insert['start_balance_status'] = $request->start_balance_status;
                // ============ 2- "start_balance_status" ===============
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
                // 3- name column
                $data_insert['name']         = $request->input('name');
                $data_insert['address']      = $request->input('address');
                $data_insert['account_type'] = 2;
                $data_insert['active']      = $request->input('active');
                $data_insert['notes']       = $request->input('notes') ;
                $data_insert['com_code']    = $com_code ;
                $data_insert['date']        = date('Y-m-d') ;
                $data_insert['added_by']    = auth()->user()->id ;
                // Create New Customer in customers table
                $flag = insert_data( new Customer() , $data_insert);
                // if "customer" is created successfully , store "customer" in "accounts" table : هضيف حساب العميل للشجرة المحاسبية يعني في جدول الحسابات
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
                    // parent_account_number : رقم الحساب الاب للعملاء هجيبه من الاعدادات العامة للادمن
                    $customer_parent_account_number = get_field_value(new AdminPanelSetting(), "customer_parent_account_number", array('com_code' => $com_code));
                    $data_insert_account['notes'] = $request->notes;
                    $data_insert_account['parent_account_number'] = $customer_parent_account_number;
                    // is_parent :  الحساب ابن وليس اب
                    $data_insert_account['is_parent'] = 0;
                    $data_insert_account['account_number'] = $data_insert['account_number'];
                    $data_insert_account['account_type'] = 2;
                    $data_insert_account['active'] = $request->active;
                    $data_insert_account['is_archived'] = $request->is_archived;
                    $data_insert_account['added_by'] = auth()->user()->id;
                    $data_insert_account['date'] = date("Y-m-d");
                    $data_insert_account['com_code'] = $com_code;
                    // accounts في جدول ال foreign_key هخزن "كود العميل" ك
                    $data_insert_account['other_table_FK'] = $data_insert['customer_code'];
                    $flag = insert_data(new Account(), $data_insert_account);
                }
                DB::commit();
                return redirect()->route('customers.index')->with('record_added','تم تخزين البيانات بنجاح');
            }
            else
            {
                return redirect()->back()->with(['error_msg'=>'عفواً اسم العميل مسجل من قبل'])->withInput();
            }
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            dd($e);
            Log::error($e);
            return redirect()->back()->with(['error' =>$e->getMessage()]);
        }
    }
    /* ++++++++++++++++++++++ show() ++++++++++++++++++++++ */
    public function show($id)
    {
        $data = Customer::findOrFail($id);
        if( !empty($data) )
        {
            // account_type
            $data->account_types_name = AccountType::where('id', $data->account_type)->value('name');
            // added_by_admin
            $data->added_by_admin = Admin::where('id',$data->added_by)->value("name");
            // updated_by_admin
            if( !empty($data->updated_by) && $data->updated_by > 0 )
            {
                $data->updated_by_admin = Admin::where('id',$data->updated_by)->value("name");
            }
            return view('admin.customers.show',compact('data'));
        }
    }
    /* ++++++++++++++++++++ edit() ++++++++++++++++++++ */
    public function edit($id)
    {
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_row( new Customer() , ['*'] , ['id'=>$id , "com_code"=>$com_code] );
        return view('admin.customers.edit',['data'=>$data]);
    }
    /* ++++++++++++++++++++ edit() ++++++++++++++++++++ */
    public function update(CustomerUpdateRequest $request, $id)
    {
        try
        {
            $com_code = auth()->user()->com_code;
            $data = Customer::findOrFail($id);
            // update "customer"
            if( empty($data) )
            {
                return redirect()->route('customers.index')->with(['error'=>'عفواً غير قادر علي الوصول للبيانات المطلوبة']);
            }
            // check if "name" exists previously or not
            $checkExists_name = Customer::where(['name' =>$request->name ,'com_code'=>$com_code])->where('id','!=',$id)->first();
            // if "customer name" [exists previously]
            if ($checkExists_name != null)
            {
                return redirect()->back()
                    ->with(['error_msg' => 'عفوا اسم العميل مسجل من قبل'])
                    ->withInput();
            }
            $data_to_update['name']                 = $request->name ;
            $data_to_update['active']               = $request->active ;
            $data_to_update['is_archived']          = $request->is_archived ;
            $data_to_update['address']              = $request->address ;
            $data_to_update['notes']                = $request->notes ;
            $data_to_update['updated_by']           = auth()->user()->id ;
            // ===== update "customer" data =======
            $flag = update_data(new Customer() , $data_to_update , ['id'=>$id , 'com_code'=>$com_code]);
            // if "customer" is updated successfully , update "customer_account" in "accounts" table
            if( $flag )
            {
                // update "customer_account" in "accounts" table
                $data_to_update_account['name']                 = $request->name;
                $data_to_update_account['active']               = $request->active ;
                $data_to_update_account['is_archived']          = $request->is_archived ;
                $data_to_update_account['notes']                = $request->notes ;
                $data_to_update_account['updated_by']           = auth()->user()->id ;
                // update "customer_account" in "accounts" table : "هحدث "الحساب المالي" المقابل "لحساب العميل" في جدول "الحسابات المالية
                $flag = update_data(new Account() , $data_to_update_account , ['account_number' => $data['account_number'] , 'other_table_FK' => $data['customer_code'] , 'account_type' => $data['account_type'] , 'com_code' => $com_code ]);
            }
            return redirect()->route('customers.index')->with("record_updated","تم تحديث البيانات بنجاح");
        }
        catch (\Exception $e)
        {
            dd($e);
            Log::error($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    /* ++++++++++++++++++ destroy() ++++++++++++++++++ */
    public function destroy(Request $request)
    {
        try
        {
            $com_code = auth()->user()->com_code;
            // -------- 1- customer_data from "customers" table --------
            $customer_data = get_cols_where_row(new Customer() , ['*'],["id"=>$request->customer_id,"com_code"=>$com_code]);
            // if "customer" exists
            if( !empty($customer_data) )
            {
                $customer_data->delete();
                return redirect()->route('customers.index')->with('record_deleted','تم حذف حساب العميل بنجاح');
            }
            else
            {
                return redirect()->route('customers.index')->with('error_msg','عفواً حساب العميل غير موجود');
            }
        }
        catch (\Exception $e)
        {
            dd($e);
            Log::error($e);
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ ما' . $e->getMessage()])->withInput();
        }
    }
    // ++++++++++++++++++++++ ajax_search() ++++++++++++++++++++++
    public function ajax_search(Request $request)
    {
        if( $request->ajax() )
        {
            $com_code = auth()->user()->com_code;
            // [search_by_text] "inputField value"
            $search_by_text         = $request->search_by_text;
            // [search_by_text] "radio button" value
            $search_by_text_radio   = $request->search_by_text_radio;
            // +++++++++++++++ Filter 1 : search_by_text +++++++++++++++
            // if search_by_text = "" : بتعها اكبر من 0 فهيجيب كل حاجة id لو حقل البحث "فارغ" هيجيب "كل العملاء" اللي ال
            if( $search_by_text == "" )
            {
                $field1 = "id";
                $operator1 = ">";
                $value1 = "0";
            }
            else
            {
                // if "search_by_text" using "name"              then $field1 = "الاسم";
                // if "search_by_text" using "account_number"    then $field1 = "رقم الحساب";
                // if "search_by_text" using "customer_number"   then $field1 = "كود العميل";
                $field1 = $search_by_text_radio;
                $operator1 = "LIKE";
                $value1 = "%{$search_by_text}%";
            }
        }
        // Get Data according to "searched Customer"
        $data = Customer::where($field1 , $operator1 , $value1)->where('com_code',$com_code)->orderBy('id','ASC')->paginate(PAGINATION_COUNT);
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
        return view('admin.customers.partials.ajax_search',['data'=>$data]);
    }

}
