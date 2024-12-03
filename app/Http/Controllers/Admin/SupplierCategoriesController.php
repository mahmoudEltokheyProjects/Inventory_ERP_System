<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierCategoriesRequest;
use App\Models\Admin;
use App\Models\Supplier\SupplierCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupplierCategoriesController extends Controller
{
    // ++++++++++++++++++++++++ index() ++++++++++++++++++++++++
    public function index()
    {
        // "Company Code" of "current login" user
        $com_code = auth()->user()->com_code;
        // supplier_categories
        $data = get_cols_where_p( new SupplierCategory() , ['*'] , ['com_code'=>$com_code] , 'id' , 'ASC' , PAGINATION_COUNT);
        if( !empty($data) )
        {
            foreach($data as $info)
            {
                // added_by
                $data->added_by_admin = Admin::where('id',$info->added_by)->value("name");
                // updated_by
                if( $info->updated_by != null && $info->updated_by > 0 )
                {
                    $data->updated_by_admin = Admin::where('id',$info->updated_by)->value("name");
                }
            }
            return view('admin.supplier_categories.index',['data'=>$data]);
        }
    }
    // ++++++++++++++++++++++++ create() ++++++++++++++++++++++++
    public function create()
    {
        return view('admin.supplier_categories.create');
    }
    // ++++++++++++++++++++++++ show($id) ++++++++++++++++++++++++
    public function show($id)
    {
        $data = SupplierCategory::findOrFail($id);
        if( !empty($data) )
        {
            return view('admin.supplier_categories.show',['data'=>$data]);
        }
        else
        {
            return redirect()->back()->with('error_msg','عفواً غير قادر علي الوصول للبيانات المطلوبة');
        }
    }
    // ++++++++++++++++++++++++ store() ++++++++++++++++++++++++
    public function store(SupplierCategoriesRequest $request)
    {
        // dd($request);
        try
        {
            // "company code" of "current login" user
            $com_code = auth()->user()->com_code;
            // Check "supplier" exists previously or not
            $checkExists_name = SupplierCategory::select('id')->where(['name' => $request->name , 'com_code' => $com_code])->first();
            if( $checkExists_name != null )
            {
                return redirect()->back()->with('error_msg','عفواً اسم فئة المورد مسجل من قبل')->withInput();
            }
            $data_to_insert['name']     = $request->name;
            $data_to_insert['active']   = $request->active;
            $data_to_insert['com_code'] = $com_code;
            $data_to_insert['date']     = now()->format('Y-m-d');
            $data_to_insert['added_by'] = auth()->user()->id;
            $flag = insert_data( new SupplierCategory() , $data_to_insert);
            if( $flag )
            {
                return redirect()->route('admin.suppliers_categories.index')->with('record_added','تم تخزين البيانات بنجاح');
            }
            else
            {
                return redirect()->back()->with('error_msg','عفواً حدث خطأ في تخزين البيانات');
            }
        }
        catch (\Exception $e)
        {
            dd($e);
            Log::error($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    // ++++++++++++++++++++++++ edit($id) ++++++++++++++++++++++++
    public function edit($id)
    {
        $data = SupplierCategory::findOrFail($id);
        return view('admin.supplier_categories.edit',['data'=>$data]);
    }
    // ++++++++++++++++++++++++ update() ++++++++++++++++++++++++
    public function update(Request $request)
    {
        // dd($request);
        try
        {
            // "company code" for "current login" user
            $com_code = auth()->user()->com_code;
            // Check "supplier" exists previously or not
            $checkExists_name = SupplierCategory::select('id')->where(['name' => $request->name , 'com_code'=>$com_code])->where('id','!=',$request->id)->first();
            if( $checkExists_name != null )
            {
                return redirect()->back()->with('error_msg','عفواً اسم فئة المورد مسجل من قبل');
            }
            $data_to_upate['name']       = $request->name;
            $data_to_upate['active']     = $request->active;
            $data_to_upate['updated_by'] = auth()->user()->id;
            // update "supplier_categories" table
            $flag = update_data(new SupplierCategory() , $data_to_upate , ['id'=>$request->id,'com_code'=>$com_code]);
            if( $flag )
            {
                return redirect()->route('admin.suppliers_categories.index')->with('record_updated','تم تحديث البيانات بنجاح');
            }
            else
            {
                return redirect()->back()->with('error_msg','عفواً حدث خطأ في تحديث البيانات');
            }
        }
        catch (\Exception $e)
        {
            dd($e);
            Log::error($e);
            return redirect()->back()->with(["error_msg" => "غير قادر علي الوصول للبيانات المطلوبة"]);
        }
    }
    // ++++++++++++++++++++++++ destroy() ++++++++++++++++++++++++
    public function destroy(Request $request)
    {
        try
        {
            $data = SupplierCategory::findOrFail($request->id);
            if( !empty($data) )
            {

                $data->delete();
                return redirect()->route('admin.suppliers_categories.index')->with('record_deleted','تم حذف البيانات بنجاح');
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
}
