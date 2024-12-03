<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Account\Account;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\AccountsRequest;
use App\Http\Requests\AccountsRequestUpdate;
use App\Models\AccountTypes\AccountType;
use App\Models\Customer;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    // +++++++++++++++++++++++++ index() +++++++++++++++++++++++++
    public function index()
    {
        // Company Code
        $com_code = auth()->user()->com_code;
        $data = get_cols_where_p(new Account(), ['*'], ['com_code' => $com_code], 'id', 'ASC', PAGINATION_COUNT);
        // Account Types : انواع الحسابات : relatedInternalAccounts = 0 : الشاشة الرئيسية الداخلية
        $account_types = get_cols_where(new AccountType(), ['id', 'name'], ['active' => 1, 'relatedInternalAccounts' => 0], 'id', 'DESC');
        // dd($account_types);
        if (!empty($data))
        {
            foreach ($data as $info)
            {
                // added_by_admin
                $info['added_by_admin'] = Admin::where('id', $info->added_by)->value('name');
                if ($info->updated_by > 0 && $info->updated_by != null) {
                    // updated_by_admin
                    $info['updated_by_admin'] = Admin::where('id', $info->updated_by)->value('name');
                }
                // account_types_name
                $info->account_types_name = AccountType::where('id', $info->account_type)->value('name');
                //  if "account" is "not parent" [ account is child ] , get "parent account" name
                if ($info->is_parent == 0) {
                    // parent_account_name
                    $info->parent_account_name = Account::where('account_number', $info->parent_account_number)->value('name');
                } else {
                    $info->parent_account_name = "لايوجد";
                }
            }
        }
        return view('admin.accounts.index', ['data' => $data,"account_types"=>$account_types]);
    }
    // +++++++++++++++++++++++++ index() +++++++++++++++++++++++++
    public function show($id)
    {
        $data = Account::findOrFail($id);
        if( !empty($data) )
        {
            // added_by
            $data->added_by_admin = Admin::where('id',$data->added_by)->value('name');
            // updated_by
            if( !empty($data->updated_at) && $data->updated_at != null )
            {
                $data->updated_by_admin = Admin::where('id',$data->updated_by)->value('name');

            }
            // account_types_name
            $data->account_types_name = AccountType::where('id', $data->account_type)->value('name');
            //  if "account" is "not parent" [ account is child ] , get "parent account" name
            if ($data->is_parent == 0) {
                // parent_account_name
                $data->parent_account_name = Account::where('account_number', $data->parent_account_number)->value('name');
            } else {
                $data->parent_account_name = "لايوجد";
            }
        }
        return view('admin.accounts.show',compact('data'));
    }
    // +++++++++++++++++++++++++ create() +++++++++++++++++++++++++
    public function create()
    {
        // Account Types : انواع الحسابات : relatedInternalAccounts = 0 : الشاشة الرئيسية الداخلية
        $account_types = get_cols_where(new AccountType(), ['id', 'name'], ['active' => 1, 'relatedInternalAccounts' => 0], 'id', 'DESC');
        // Company Code
        $com_code = auth()->user()->com_code;
        // Parent Accounts :  الحسابات الاب
        $parent_accounts = get_cols_where(new Account(), ['account_number', 'name'], ['is_parent' => 1, 'com_code' => $com_code], 'id', 'DESC');
        // dd($parent_accounts);
        return view('admin.accounts.create', ['account_types' => $account_types, 'parent_accounts' => $parent_accounts]);
    }
    // +++++++++++++++++++++++++ store() +++++++++++++++++++++++++
    public function store(AccountsRequest $request)
    {
        // dd($request);
        try {
            // Company Code
            $com_code = Admin::where('id', auth()->user()->id)->value('com_code');
            // Check if "name" exists previously
            $checkExists = get_cols_where_row(new Account(), ['id'], ['name' => $request->name, 'com_code' => $request->com_code]);
            // if "name" exists previously
            if (!empty($checkExists)) {
                return redirect()->back()->with(['error' => 'عفواً اسم الحساب المالي مُسجل مسبقاً'])->withInput();
            }
            // Set "account_number" : "account_number" = "last account_number" + 1
            $row = get_cols_where_row_orderby(new Account(), ['account_number'], ['com_code' => $com_code]);
            if (!empty($row)) {
                $data_insert['account_number'] = $row['account_number'] + 1;
            } else {
                // 'account' will be the 'first account' then 'account_number' = 1
                $data_insert['account_number'] = 1;
            }
            // 1- name column
            $data_insert['name'] = $request->name;
            // 2- active column
            $data_insert['active'] = $request->active;
            // 3- account_type column
            $data_insert['account_type'] = $request->account_type;
            // 4- is_parent column
            $data_insert['is_parent'] = $request->is_parent;
            // ============ if "account" is "Child" Not Parent ===============
            // Store "parent_account_number"
            if ($data_insert['is_parent'] == 0) {
                // parent_account_number column
                $data_insert['parent_account_number'] = $request->parent_account_number;
            }
            // start_balance_status column
            $data_insert['start_balance_status'] = $request->start_balance_status;
            // ============ "start_balance_status" ===============
            // 1- start_balance_status == 1 Then "credit" => "دائن"
            if ($data_insert['start_balance_status'] == 1) {
                // لان المستخدم او الموظف هيكون دائن يعني ليه فلوس عند الشركة فهخزن قيمته بالسالب في قاعدة البيانات
                $data_insert['start_balance'] = $request->start_balance * -1;
            }
            // 2- start_balance_status == 2 Then "debit" => "مدين"
            elseif ($data_insert['start_balance_status'] == 2) {
                // لان المستخدم او الموظف هيكون مدين يعني عليه فلوس للشركة فهخزن قيمته بالموجب في قاعدة البيانات
                $data_insert['start_balance'] = $request->start_balance;
            }
            // 3- start_balance_status == 3 Then "balanced" => "متزن"
            elseif ($data_insert['start_balance_status'] == 3) {
                $data_insert['start_balance'] = 0;
            }
            // if "start_balance" is empty , set "start_balance" with "0" (will be balanced): لو المستخدم لم يقوم بادخال اي قيمة
            else
            {
                // 'start_balance_status' will be "balanced"
                $data_insert['start_balance_status'] = 3;
                $data_insert['start_balance'] = 0;
            }
            // is_archived column
            $data_insert['is_archived'] = $request->is_archived;
            // notes column
            $data_insert['notes'] = $request->notes;
            // date column
            $data_insert['date'] = date('Y-m-d');
            // added_by
            $data_insert['added_by'] = auth()->user()->id;
            // added_by
            $data_insert['com_code'] = $com_code;
            // ------- Create "account" -------
            Account::create($data_insert);
            return redirect()->route('admin.accounts.index')->with('record_added', 'تم اضافة البيانات بنجاح');
        } catch (\Exception $e) {
            dd($e);
            Log::error($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    // +++++++++++++++++++++++++ edit($id) +++++++++++++++++++++++++
    public function edit($id)
    {
        // ========= Company Code =========
        $com_code = auth()->user()->com_code;
        // data
        $data = get_cols_where_row(new Account(), array("*"), array("id" => $id, "com_code" => $com_code));
        if (empty($data))
        {
            return redirect()->route('admin.accounts.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
        }
        // ========= account_types =========
        $account_types = get_cols_where(new AccountType(), array("id", "name"), array("active" => 1), 'id', 'ASC');
        // ========= parent_accounts =========
        $parent_accounts = get_cols_where(new Account(), array("account_number", "name"), array("is_parent" => 1, "com_code" => $com_code), 'id', 'ASC');
        return view('admin.accounts.edit', ['account_types' => $account_types, 'parent_accounts' => $parent_accounts, 'data' => $data]);
    }
    // +++++++++++++++++++++++++ update($id) +++++++++++++++++++++++++
    public function update(AccountsRequestUpdate $request)
    {
        // dd($request);
        try
        {
            $com_code = auth()->user()->com_code;
            $account = Account::findOrFail($request->account_id);
            if ( empty($account) )
            {
                return redirect()->route('admin.accounts.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
            }
            // لو الحساب مش موجود بس مش مع نفسه
            $checkExists = Account::where(['name' => $request->name, 'com_code' => $com_code])->where('id', '!=', $request->account_id)->first();
            if ($checkExists != null)
            {
                return redirect()->back()
                    ->with(['error_msg' => 'عفوا اسم الحساب مسجل من قبل'])
                    ->withInput();
            }
            $data_to_update['name'] = $request->name;
            $data_to_update['account_type'] = $request->account_type;
            $data_to_update['is_parent'] = $request->is_parent;
            //  if "account" is "not parent" [ account is child ] , get "parent account" name
            if ($data_to_update['is_parent'] == 0)
            {
                $data_to_update['parent_account_number'] = $request->parent_account_number;
            }
            $data_to_update['active'] = $request->active;
            $data_to_update['is_archived'] = $request->is_archived;
            $data_to_update['updated_by'] = auth()->user()->id;
            // ============ start_balance_status column ============
            $data_to_update['start_balance_status'] = $request->start_balance_status;
            // ============ "start_balance_status" ===============
            // 1- start_balance_status == 1 Then "credit" => "دائن"
            if ($data_to_update['start_balance_status'] == 1) {
                // لان المستخدم او الموظف هيكون دائن يعني ليه فلوس عند الشركة فهخزن قيمته بالسالب في قاعدة البيانات
                $data_to_update['start_balance'] = $request->start_balance * -1;
            }
            // 2- start_balance_status == 2 Then "debit" => "مدين"
            elseif ($data_to_update['start_balance_status'] == 2) {
                // لان المستخدم او الموظف هيكون مدين يعني عليه فلوس للشركة فهخزن قيمته بالموجب في قاعدة البيانات
                $data_to_update['start_balance'] = $request->start_balance;
            }
            // 3- start_balance_status == 3 Then "balanced" => "متزن"
            elseif ($data_to_update['start_balance_status'] == 3) {
                $data_to_update['start_balance'] = 0;
            }
            // Update "Account"
            // ========== update "account" using "update_data" helper function ==========
            $flag = update_data(new Account() , $data_to_update , ["id"=>$request->account_id,"com_code"=>$com_code]);
            if( $flag )
            {
                // if "account_type" is "customer" , update "customer_account" in "accounts" table : لو نوع الحساب الذي تم تعديله كان حساب عميل فهروح اعدل عليه في جدول العملاء
                if( $account['account_type'] == 2 )
                {
                    // update "customer_account" in "accounts" table
                    $data_to_update_customer['name']                 = $request->name;
                    $data_to_update_customer['active']               = $request->active ;
                    $data_to_update_customer['is_archived']          = $request->is_archived ;
                    $data_to_update_customer['notes']                = $request->notes ;
                    $data_to_update_customer['updated_by']           = auth()->user()->id ;
                    // update "customer_account" in "accounts" table : "هحدث "الحساب المالي للعميل" المقابل "لحساب المالي" في جدول "الحسابات العملاء
                    $flag = update_data(new Customer() , $data_to_update_customer , ['account_number' => $account['account_number'] , 'customer_code' => $account['other_table_FK'] , 'com_code' => $com_code ]);
                }
            }
            return redirect()->route('admin.accounts.index')->with(['record_updated' => 'لقد تم تحديث البيانات بنجاح']);
        }
        catch (\Exception $ex)
        {
            dd($ex);
            return redirect()->back()
                ->with(['error' => 'عفوا حدث خطأ ما' . $ex->getMessage()])
                ->withInput();
        }
    }
    // +++++++++++++++++++++++++ update($id) +++++++++++++++++++++++++
    public function destroy(Request $request)
    {
        try
        {
            $account = Account::findOrFail($request->id);
            if( !empty($account) )
            {
                $account->delete();
                return redirect()->route('admin.accounts.index')->with("record_deleted","تم حذف البيانات بنجاح");
            }
            else
            {
                return redirect()->back()->with(["error_msg"=>'الحساب المالي غير موجود']);
            }
        }
        catch (\Exception $e)
        {
            dd($e);
            // redirect to "main page" with "error message"
            return redirect()->back()->with(['error'=>'عفواً حدث خطاء ما'.$e->getMessage()]);
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
            // Search By "account_type_search"
            $account_type_search = $request->account_type_search;
            // Search By "is_parent_search"
            $is_parent_search = $request->is_parent_search;
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
            // +++++++++++++++ Filter 2 : Search By "account_type_search"
            if( $account_type_search == "all" )
            {
                $field2 = "id";
                $operator2 = ">";
                $value2 = "0";
            }
            else
            {
                $field2 = "account_type";
                $operator2 = "LIKE";
                $value2 = "%{$account_type_search}%";
            }
            // +++++++++++++++ Filter 3 : Search By "is_parent_search"
            if( $is_parent_search == "all" )
            {
                $field3 = "id";
                $operator3 = ">";
                $value3 = "0";
            }
            else
            {
                $field3 = "is_parent";
                $operator3 = "LIKE";
                $value3 = "%{$is_parent_search}%";
            }

            // Get "accounts" that "match" the "search value"
            $data = Account::where($field1,$operator1,$value1)
                            ->where($field2,$operator2,$value2)
                            ->where($field3,$operator3,$value3)
                            ->orderBy('id','ASC')
                            ->paginate(PAGINATION_COUNT);
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
                    // account_type
                    $info->account_types_name = AccountType::where('id', $info->account_type)->value('name');
                    //  if "account" is "not parent" [ account is child ] , get "parent account" name
                    if ($info->is_parent == 0)
                    {
                        // parent_account_name
                        $info->parent_account_name = Account::where('account_number', $info->parent_account_number)->value('name');
                    }
                    else
                    {
                        $info->parent_account_name = "لايوجد";
                    }
                }
            }
            return view('admin.accounts.partials.ajax_search',['data'=>$data]);
        }
    }
}
