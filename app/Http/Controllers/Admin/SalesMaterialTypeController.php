<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\SalesMaterialType;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\SalesMaterialTypeRequest;

class SalesMaterialTypeController extends Controller
{
    // +++++++++++++++++++++++++ index ++++++++++++++++
    public function index()
    {
        $data = SalesMaterialType::select("*")->orderBy('id','desc')->paginate(PAGINATION_COUNT);
        if( !empty($data) )
        {
            foreach ($data as $info)
            {
                $info->added_by_admin = Admin::where('id',$info->added_by)->value("name");
                if( $info->updated_by > 0 && $info->updated_by != '')
                {
                    $info->updated_by_admin = Admin::where('id',$info->updated_by)->value("name");
                }
            }
        }
        return view('admin.sales_material_types.index',compact('data'));
    }
    // +++++++++++++++++++++++++ create ++++++++++++++++
    public function create()
    {
        return view('admin.sales_material_types.create');
    }
    // +++++++++++++++++++++++++ store ++++++++++++++++
    public function store(SalesMaterialTypeRequest $request)
    {
        // dd($request);
        try
        {
            $data = [
                "name"      => $request->name   ,
                "active"    => $request->active ,
                "com_code"  => auth()->user()->com_code ,
                "date"      => now() ,
                "added_by"  => auth()->user()->id
            ];
            // +++++++ com_code +++++++
            $com_code = auth()->user()->com_code;
            $checkExists = SalesMaterialType::where(['name' => $request->name , 'com_code' => $com_code])->first();
            // Check if "sales_material_type" Exists previously or not
            if( $checkExists == null)
            {
                SalesMaterialType::create($data);
                return  redirect()->route("admin.sales_material_types.index")->with('record_added','تم اضافة البيانات بنجاح');
            }
            else
            {
                return redirect()->back()->with(['error' => 'عفواً اسم الفئة موجودة مسبقاً'])->withInput();
            }
        }
        catch (\Exception $e)
        {
            Log::error($e);
            return redirect()->back()
                    ->with(['error', 'عذرًا، حدث خطأ: '. $e->getMessage()])
                    // withInput() : لو عايز احافظ علي القيم اللي في حقول الادخال في حالة حدوث مشكلة اثناء الحفظ
                    ->withInput();
        }
    }
    // +++++++++++++++++++++++++ show ++++++++++++++++
    public function show($id)
    {
        $data = SalesMaterialType::findOrFail($id);
        if( !empty($data) )
        {
            // added_by
            $data->added_by_admin = Admin::where('id',$data->added_by)->value('name');
            // updated_by
            if( !empty($data->updated_at) && $data->updated_at != null )
            {
                $data->updated_by_admin = Admin::where('id',$data->updated_by)->value('name');

            }
        }
        return view('admin.sales_material_types.show',compact('data'));
    }
    // +++++++++++++++++++++++++ edit ++++++++++++++++
    public function edit($id)
    {
        $data = SalesMaterialType::findOrFail($id);
        return view('admin.sales_material_types.edit',compact('data'));
    }
    // +++++++++++++++++++++++++ create ++++++++++++++++
    public function update(SalesMaterialTypeRequest $request)
    {
        // dd($request);
        try
        {
            $sales_material_type = SalesMaterialType::findOrFail($request->id);
            if( !empty($sales_material_type) )
            {
                $updated_data = [
                    "name" => $request->name ,
                    "active" => $request->active ,
                    "updated_by" => auth()->user()->id ,
                ];
                // update "sales_material_type" data
                $sales_material_type->update($updated_data);
                // withInput() : لو عايز احافظ علي القيم اللي في حقول الادخال في حالة حدوث مشكلة اثناء الحفظ
                return  redirect()->route("admin.sales_material_types.index")->with(['record_updated'=>'تم تحديث البيانات بنجاح']);
            }
            else
            {
                return redirect()->back()->with(["error" => "غير قادر علي الوصول للبيانات المطلوبة"]);
            }

        }
        catch (\Exception $e)
        {
            Log::error($e);
            return redirect()->back()
                            ->with(['error', 'عذرًا، حدث خطأ: '. $e->getMessage()])
                            // withInput() : لو عايز احافظ علي القيم اللي في حقول الادخال في حالة حدوث مشكلة اثناء الحفظ
                            ->withInput();
        }
    }
    // +++++++++++++++++++++++++ delete +++++++++++++++++++++++++
    public function delete(Request $request)
    {
        try
        {
            $sales_material_type = SalesMaterialType::findOrFail($request->id);
            if( !empty($sales_material_type) )
            {
                $sales_material_type->delete();
                return redirect()->back()->with('record_deleted' , 'تم حذف البيانات بنجاح');
            }
            else
            {
                return redirect()->back()->with(['error' => 'عفواً غير قادر علي الوصول للبيانات']);
            }
        }
        catch (\Exception $e)
        {
            // redirect to "main page" with "error message"
            return redirect()->back()->with(['error'=>'عفواً حدث خطاء ما'.$e->getMessage()]);
        }
    }
}
