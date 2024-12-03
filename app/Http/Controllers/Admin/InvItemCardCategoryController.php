<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvItemCardCategoryRequest;
use App\Models\ItemCardCategory\InvItemCardCategory;

class InvItemCardCategoryController extends Controller
{
    /* ++++++++++++++++++ index() ++++++++++++++++++ */
    public function index()
    {
        $data = InvItemCardCategory::orderby('id', 'ASC')->paginate(PAGINATION_COUNT);
        if( !empty($data) && $data != null )
        {
            foreach ($data as $info)
            {
                $info->added_by_admin = Admin::where('id',$info->added_by)->value("name");
                if( $info->updated_by != null && $info->updated_by > 0 )
                {
                    $info->updated_by_admin = Admin::where('id',$info->updated_by)->value("name");
                }
            }
        }
        return view('admin.inv_item_card_category.index',compact('data'));
    }
    /* ++++++++++++++++++ create() ++++++++++++++++++ */
    public function create()
    {
        return view('admin.inv_item_card_category.create');
    }
    /* ++++++++++++++++++ store() ++++++++++++++++++ */
    public function store(InvItemCardCategoryRequest $request)
    {
        try
        {
            // company_code
            $com_code = Admin::where('id',auth()->user()->id)->value("com_code");
            // Check if item exists previously or not
            $checkExists = InvItemCardCategory::where(['name'=>$request->name ,'com_code'=>$com_code])->first();
            // if "item" Not Exist
            if( $checkExists == null )
            {
                // data of "new item"
                $data = [
                    "name" => $request->name ,
                    "active" => $request->active ,
                    "com_code" => $com_code ,
                    "added_by" => auth()->user()->id ,
                    "date" => date("Y-m-d")
                ];
                // Create a new item
                InvItemCardCategory::create( $data );
                return redirect()->route('inv_item_card_categories.index')->with('record_added','تم اضافة البيانات بنجاح');
            }
            else
            {
                return redirect()->back()->with('error_msg','عفوا اسم الفئة مسجل مسبقاً')->withInput();
            }
        }
        catch (\Exception $e)
        {
            Log::error($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    /* ++++++++++++++++++ show() ++++++++++++++++++ */
    public function show($id)
    {
        $data = InvItemCardCategory::findOrFail($id);
        if( !empty($data) )
        {
            $data->added_by_admin = Admin::where('id',$data->added_by)->value('name');
            if( $data->updated_by > 0 and $data->updated_by != null)
            {
                $data->updated_by_admin = Admin::where('id',$data->updated_by)->value('name');
            }
        }
        return view('admin.inv_item_card_category.show',compact('data'));
    }
    /* ++++++++++++++++++ edit() ++++++++++++++++++ */
    public function edit($id)
    {
        $data = InvItemCardCategory::findOrFail($id);
        return view('admin.inv_item_card_category.edit',compact('data'));
    }
    /* ++++++++++++++++++ update() ++++++++++++++++++ */
    public function update(InvItemCardCategoryRequest $request)
    {
        // return($request);
        try
        {
            $inv_item = InvItemCardCategory::findOrFail($request->id);
            // updated data
            $data = [
                "name" => $request->name ,
                "active" => $request->active ,
                "updated_by" => auth()->user()->id,
            ];
            // update "unit"
            $inv_item->update($data);
            return redirect()->route('inv_item_card_categories.index')->with('record_updated','تم تحديث البيانات بنجاح');
        }
        catch(\Exception $e)
        {
            Log::error($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    /* ++++++++++++++++++ destroy() ++++++++++++++++++ */
    public function destroy(Request $request)
    {
        try
        {
            $inv_item = InvItemCardCategory::findOrFail($request->id);
            // Check if "inv_item" Exists or not
            if( !empty($inv_item) )
            {
                $inv_item->delete();
                return redirect()->back()->with('record_deleted' , 'تم حذف البيانات بنجاح');
            }
            else
            {
                return redirect()->back()->with(['error' => 'عفواً غير قادر علي الوصول للبيانات']);
            }
        }
        catch (\Exception $e)
        {
            Log::error($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
}
