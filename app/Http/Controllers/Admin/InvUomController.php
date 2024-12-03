<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Units\InvUom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvUomRequest;

// ++++++++++++++ 'InvUomController" => Inventory "Unit of measurement" Controller ++++++++++++++
class InvUomController extends Controller
{
    // +++++++++++++++++++++++++ index +++++++++++++++++++++++++
    public function index()
    {
        $data = InvUom::select('*')->orderby('id','desc')->paginate(PAGINATION_COUNT);
        if( !empty($data) )
        {
            foreach($data as $info)
            {
                // added_by
                $info->added_by_admin = Admin::where('id', $info->added_by)->value("name");
                // updated_by
                if( $info->updated_by > 0 && $info->updated_by != null )
                {
                    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value("name");
                }
            }
        }
        return view('admin.inv_uom.index',compact('data'));
    }
    // +++++++++++++++++++++++++ create +++++++++++++++++++++++++
    public function create()
    {
        return view('admin.inv_uom.create');
    }
    // +++++++++++++++++++++++++ store +++++++++++++++++++++++++
    public function store(InvUomRequest $request)
    {
        try
        {
            // company code
            $com_code = Admin::where('id', auth()->user()->id)->value('com_code');
            // Check if "unit" exists previously or not
            $checkExists = InvUom::where(['name' => $request->name,'com_code' => $com_code])->first();
            // if "unit" Not exist previously
            if($checkExists == null)
            {
                $data = [
                    "name" => $request->name ,
                    "is_master" => $request->is_master ,
                    "active" => $request->active ,
                    "com_code" => $com_code ,
                    "date" => date("Y-m-d") ,
                    "added_by" => auth()->user()->id ,
                ];
                // Create new "unit"
                InvUom::create($data);
                return redirect()->route('admin.uoms.index')->with('success','تم اضافة البيانات بنجاح');
            }
            // if "unit" exists previously
            else
            {
                return redirect()->route('admin.uoms.index')->with('error_msg','عفواً الوحدة مسجله مسبقاً');
            }
        }
        catch (\Exception $e)
        {
            Log::error($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    // +++++++++++++++++++++++++ show +++++++++++++++++++++++++
    public function show($id)
    {
        $data = InvUom::findOrFail($id);
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
        return view('admin.inv_uom.show',compact('data'));
    }
    // +++++++++++++++++++++++++ edit +++++++++++++++++++++++++
    public function edit($id)
    {
        $data = InvUom::findOrFail($id);
        return view('admin.inv_uom.edit',compact('data'));
    }
    // +++++++++++++++++++++++++ update +++++++++++++++++++++++++
    public function update(InvUomRequest $request)
    {
        try
        {
            // "data" will be updated
            $unit = InvUom::findOrFail($request->id);
            // updated data
            $data = [
                "name" => $request->name ,
                "is_master" => $request->is_master ,
                "active" => $request->active ,
                "updated_by" => auth()->user()->id ,
            ];
            // update "unit"
            $unit->update($data);
            return redirect()->route('admin.uoms.index')->with('warning_msg','تم تحديث البيانات بنجاح');
        }
        catch (\Exception $e)
        {
            Log::error($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    // +++++++++++++++++++++++++ destroy +++++++++++++++++++++++++
    public function destroy(Request $request)
    {
        try
        {
            $unit = InvUom::findOrFail($request->id);
            $unit->delete();
            return redirect()->route('admin.uoms.index')->with('error_msg','تم حذف البيانات بنجاح');
        }
        catch (\Exception $e)
        {
            Log::error($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    /* +++++++++++++++++++ search() : ajax search +++++++++++++++++++ */
    public function ajax_search(Request $request)
    {
        if($request->ajax())
        {
            // "search_by_text inputField" value
            $search_by_text = $request->search_by_text;
            // "is_master_search selectbox" value
            $is_master_search = $request->is_master_search;
            // +++++++++++++++ Filter 1 : search_by_text +++++++++++++++
            //  if search_by_text = "" : بتعها اكبر من 0 فهيجيب كل حاجة id لو حقل البحث "فارغ" هيجيب كل الوحدات اللي ال
            if( $search_by_text == "" )
            {
                $field1 = "id";
                $operator1 = ">";
                $value1 = "0";
            }
            else
            {
                $field1 = "name";
                $operator1 = "LIKE";
                $value1 = "%{$search_by_text}%";
            }
            // +++++++++++++++ Filter 2 : is_master_search +++++++++++++++
            //  if is_master_search = "all" : بتعها اكبر من 0 فهيجيب كل حاجة id لو ببحث "بالكل" هيجيب كل الوحدات اللي ال
            if( $is_master_search == "all" )
            {
                $field2 = "id";
                $operator2 = ">";
                $value2 = "0";
            }
            else
            {
                $field2 = "is_master";
                $operator2 = "=";
                $value2 = $is_master_search;
            }
            // Get "inv_uoms" that "match" the "search value"
            $data = InvUom::where($field1,$operator1,$value1)
                          ->where($field2,$operator2,$value2)
                          ->orderBy('id','ASC')
                          ->paginate(PAGINATION_COUNT);

            if( !empty($data) )
            {
                foreach($data as $info)
                {
                    // added_by
                    $info->added_by_admin = Admin::where('id', $info->added_by)->value("name");
                    // updated_by
                    if( $info->updated_by > 0 && $info->updated_by != null )
                    {
                        $info->updated_by_admin = Admin::where('id', $info->updated_by)->value("name");
                    }
                }
            }
            return view('admin.inv_uom.partials.ajax_search',['data'=>$data]);
        }
    }
}
