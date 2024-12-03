<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Treasury\Treasury;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use App\Http\Requests\TreasuryRequest;
use App\Models\Treasury\TreasuryDelivery;
use App\Http\Requests\AddTreasuryDeliveryRequest;

class TreasuryController extends Controller
{
    /* ++++++++++++++++ index() ++++++++++++++++ */
    public function index()
    {
        $data = Treasury::orderby('id', 'ASC')->paginate(PAGINATION_COUNT);
        if (!empty($data))
        {
            foreach ($data as $info)
            {
                // +++++++++++ created_by +++++++++++
                $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
                // +++++++++++ updated_by +++++++++++
                if ($info->updated_by > 0 and $info->updated_by != null)
                {
                    $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
                }
            }
        }
        return view('admin.treasuries.index', ['data' => $data]);
    }
    /* +++++++++++++++++++ create() +++++++++++++++++++ */
    public function create()
    {
        return view('admin.treasuries.create');
    }
    /* +++++++++++++++++++ store() +++++++++++++++++++ */
    public function store(TreasuryRequest $request)
    {
        try
        {
            $data = $request->validated();
            $data = [
                'name' => $request->name ,
                'is_master' => $request->is_master,
                'active' => $request->active,
                'last_isal_exchange' => $request->last_isal_exchange,
                'last_isal_collect' => $request->last_isal_collect,
                // Get "com_code" of Login Admin
                'com_code' => Admin::where('id',auth()->user()->id)->value('com_code'),
                'date' => date("Y-m-d"),
                'added_by' => auth()->user()->id ,
                'updated_by' => null
            ];
            // create "treasury"
            Treasury::create($data);
            return  redirect()->route("admin.treasury.index")
                             ->with('record_added','تم اضافة البيانات بنجاح');
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
    /* +++++++++++++++++++ show() +++++++++++++++++++ */
    public function show($id)
    {
        $data = Treasury::findOrFail($id);
        if (!empty($data))
        {
            // +++++++++++ created_by +++++++++++
            $data->added_by_admin = Admin::where('id', $data->created_at)->value('name');
            // +++++++++++ updated_by +++++++++++
            if ($data->updated_by > 0 && $data->updated_by != null)
            {
                $data->updated_by_admin = Admin::where('id', $data->updated_by)->value('name');
            }
            // ++++++++++++++ treasury_delivery ++++++++++++++
            // هجيب الخزنة الفرعية اللي هتسلم الخزنة الرئيسية
            $treasury_delivery = TreasuryDelivery::where('treasuries_id',$id)->orderby('id','DESC')->get();
            if( !empty($treasury_delivery)  )
            {
                foreach($treasury_delivery as $info)
                {
                    // اسم الخزنة الفرعية اللي هتسلم الخزنة الرئيسية
                    $info->name = Treasury::where('id', $info->treasuries_can_delivery_id)->value('name');
                    // اسم الشخص اللي قام باضافة الخزنة الفرعية اللي هتسلم الخزنة الرئيسية
                    $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
                }
            }
        }
        return view('admin.treasuries.show',compact('data','treasury_delivery'));
    }
    /* +++++++++++++++++++ edit() +++++++++++++++++++ */
    public function edit($id)
    {
        $data = Treasury::findOrFail($id);
        return view('admin.treasuries.edit', compact('data'));
    }
    /* +++++++++++++++++++ update() +++++++++++++++++++ */
    public function update(TreasuryRequest $request)
    {
        try
        {
            $treasury = Treasury::findOrFail($request->id);
            $data = [
                'name' => $request->name ,
                'is_master' => $request->is_master,
                'active' => $request->active,
                'last_isal_exchange' => $request->last_isal_exchange,
                'last_isal_collect' => $request->last_isal_collect,
                // Get "com_code" of Login Admin
                'com_code' => Admin::where('id',auth()->user()->id)->value('com_code'),
                'date' => date("Y-m-d"),
                'updated_by' => auth()->user()->id
            ];
            // update "treasury"
            $treasury->update($data);
            // withInput() : لو عايز احافظ علي القيم اللي في حقول الادخال في حالة حدوث مشكلة اثناء الحفظ
            return  redirect()->route("admin.treasury.index")
                             ->with(['record_updated'=>'تم تحديث البيانات بنجاح']);

        }
        catch(\Exception $e)
        {
            // dd($e);
            // redirect to "main page" with "error message"
            return redirect()->back()
                            ->with(['error'=>'عفواً حدث خطاء ما'.$e->getMessage()])
                            // withInput() : لو عايز احافظ علي القيم اللي في حقول الادخال في حالة حدوث مشكلة اثناء الحفظ
                            ->withInput();
        }
    }
    /* +++++++++++++++++++ delete() +++++++++++++++++++ */
    public function delete(Request $request)
    {
        try
        {
            $treasury = Treasury::findOrFail($request->id);
            $treasury->delete();
            return redirect()->route("admin.treasury.index")->with('record_deleted' , 'تم حذف البيانات بنجاح');
        }
        catch(\Exception $e)
        {
            dd($e);
            // redirect to "main page" with "error message"
            return redirect()->route("admin.treasury.index")->with(['error'=>'عفواً حدث خطاء ما'.$e->getMessage()]);
        }
    }
    /* +++++++++++++++++++ search() : ajax search +++++++++++++++++++ */
    public function ajax_search(Request $request)
    {
        if($request->ajax())
        {
            // "search inputField" value
            $search_by_text = $request->search_by_text;
            // Get "treasuries" that "match" the "search value"
            $data = Treasury::where('name','LIKE',"%{$search_by_text}%")->orderBy('id','ASC')->paginate(PAGINATION_COUNT);
            return view('admin.treasuries.partials.ajax_search',['data'=>$data]);
        }
    }
    /* +++++++++++++++++++ add_treasury_delivery() +++++++++++++++++++ */
    public function add_treasury_delivery($id)
    {
        try
        {
            $com_code = auth()->user()->com_code ;
            // ===== main_treasury data : بيانات الخزنة الرئيسية =====
            $main_treasury = Treasury::select('id','name')->find($id);
            if( !empty($main_treasury) )
            {
                // treasuries : الخزن التي تنتمي للشركة اللي شغاله حاليا علي السيستم وتكون مفعلة
                $treasuries = Treasury::select('id','name')
                                    ->where(['com_code'=> $com_code,'active'=>1])->get();
                return view('admin.treasuries.add_treasury_delivery',['main_treasury' => $main_treasury,'treasuries'=>$treasuries]);
            }
            else
            {
                return redirect()->route('admin.treasury.index')->with(['error' => 'عفواً غير قادر علي الوصول الي البيانات المطلوبة !!']);
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with(['error'=>'عفواً حدث خطاء ما'.$e->getMessage()]);
        }
    }
    /* +++++++++++++++++++ store_treasury_delivery() +++++++++++++++++++ */
    public function store_treasury_delivery(AddTreasuryDeliveryRequest $request , $id)
    {
        try
        {
            // company_code : الكود بتاع الشركة اللي شغاله حاليا علي السيستم
            $com_code = auth()->user()->com_code;
            // main_treasury : بيانات الخزنة الرئيسية
            $data = Treasury::select('id','name')->find($id);
            if( !empty($data) )
            {
                // sub_treasury : هجيب بيانات الخزنة اللي هستلم منها وهشوف هل موجودة مسبقا ولا لا وعلي اساسه هضفها ولا لا
                $checkExists = TreasuryDelivery::where(['treasuries_id' => $id ,
                                                        'treasuries_can_delivery_id' => $request->treasuries_can_delivery_id,
                                                        'com_code' => $request->com_code
                                                       ])->first();
                // لو الخزنة الفرعية موجودة مسبقاً مش هضفها في قاعدة البيانات
                if( $checkExists != null )
                {
                    return redirect()->back()->with(['error' => 'عفواً هذه الخزنة مسجلة من قبل !'])->withInput();
                }
                // لو الخزنة الفرعية غير موجودة مسبقاً
                $sub_treasury_data['treasuries_id'] = $id;
                $sub_treasury_data['treasuries_can_delivery_id'] = $request->treasuries_can_delivery_id;
                $sub_treasury_data['added_by'] = auth()->user()->id;
                $sub_treasury_data['com_code'] = $com_code;
                // Create "new treasury delivery"
                TreasuryDelivery::create($sub_treasury_data);
                return  redirect()->route("admin.treasury.show",$id)
                             ->with('record_added','تم اضافة البيانات بنجاح');
            }
            else
            {
                return redirect()->route('admin.treasury.index')->with(['error' => 'عفواً غير قادر علي الوصول الي البيانات المطلوبة !!']);
            }
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with(['error'=>'عفواً حدث خطاء ما'.$e->getMessage()]);
        }
    }
    /* +++++++++++++++++++ delete_treasury_delivery() +++++++++++++++++++ */
    public function delete_treasury_delivery(Request $request)
    {
        try
        {
            $treasury_delivery = TreasuryDelivery::findOrFail($request->id);
            if( !empty($treasury_delivery) )
            {
                $treasury_delivery->delete();
                return redirect()->back()->with('record_deleted' , 'تم حذف البيانات بنجاح');
            }
            else
            {
                return redirect()->back()->with(['error' => 'عفواً غير قادر علي الوصول للبيانات']);
            }
        }
        catch(\Exception $e)
        {
            dd($e);
            // redirect to "main page" with "error message"
            return redirect()->back()->with(['error'=>'عفواً حدث خطاء ما'.$e->getMessage()]);
        }
    }
}
