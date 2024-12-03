<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Requests\StoreRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    // +++++++++++++++++++++++++ index +++++++++++++++++++++++++
    public function index()
    {
        $data = Store::orderby('id', 'desc')->paginate(PAGINATION_COUNT);
        if( !empty($data) )
        {
            foreach($data as $info)
            {
                // added_by
                $info->added_by_admin = Admin::where('id',$info->added_by)->value('name');
                // updated_by
                if( !empty($info->updated_at) && $info->updated_at != null )
                {
                    $info->updated_by_admin = Admin::where('id',$info->updated_by)->value('name');

                }
            }
        }
        return view('admin.stores.index',compact('data'));
    }
    // +++++++++++++++++++++++++ create +++++++++++++++++++++++++
    public function create()
    {
        return view('admin.stores.create');
    }
    // +++++++++++++++++++++++++ store +++++++++++++++++++++++++
    public function store(StoreRequest $request)
    {
        try
        {
            $com_code = auth()->user()->com_code;
            $data = [
                "name" => $request->name ,
                "active" => $request->active ,
                "phone" => $request->phone ,
                "address" => $request->address ,
                "added_by" => auth()->user()->id ,
                "com_code" => $com_code ,
                "date" => now()
            ];
            // Check if "store" Exists Previously
            $checkExists = Store::where(['name'=>$request->name,'com_code'=>$com_code])->first();
            // if "store" does not exist Previously
            if( $checkExists == null )
            {
                Store::create($data);
                return  redirect()->route("admin.stores.index")->with('record_added','تم اضافة البيانات بنجاح');
            }
            else
            {
                return redirect()->back()->with(['error' => 'عفواً اسم الخزنة مسجل مسبقاً'])->withInput();
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
    // +++++++++++++++++++++++++ show($id) +++++++++++++++++++++++++
    public function show($id)
    {
        $data = Store::findOrFail($id);
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
        return view('admin.stores.show',compact('data'));
    }
    // +++++++++++++++++++++++++ edit($id) +++++++++++++++++++++++++
    public function edit($id)
    {
        $data = Store::findOrFail($id);
        return view('admin.stores.edit',compact('data'));
    }
    /* +++++++++++++++++++ update() +++++++++++++++++++ */
    public function update(StoreRequest $request)
    {
        try
        {
            // Get "edited store" data
            $store = Store::findOrFail($request->id);
            // Get "company code"
            $com_code = auth()->user()->com_code;
            // updated data
            $data = [
                "name" => $request->name ,
                "active" => $request->active ,
                "phone" => $request->phone ,
                "address" => $request->address ,
                "updated_by" => auth()->user()->id ,
                "com_code" => $com_code ,
                "date" => now()
            ];
            // update store
            $store->update($data);
            return redirect()->route('admin.stores.index')->with('success','تم تعديل البيانات بنجاح');
        }
        catch (\Exception $e)
        {
            Log::error($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    /* +++++++++++++++++++ delete() +++++++++++++++++++ */
    public function delete($id)
    {
        try
        {
            $store = Store::findOrFail($id);
            $store->delete();
            return redirect()->route('admin.stores.index')->with('success','تم حذف البيانات بنجاح');
        }
        catch (\Exception $e)
        {
            Log::error($e);
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
    }
}
