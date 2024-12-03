<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;
use App\Models\Supplier\Supplier;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Supplier\SupplierCategory;
use App\Models\Supplier\SuppliersWithOrder;

use App\Http\Requests\SuppliersWithOrdersRequest;
use App\Models\InvItemCard\InvItemCard;
use App\Models\Store;
use App\Models\Supplier\SuppliersWithOrderDetails;
use App\Models\Units\InvUom;

class SuppliersWithOrderController extends Controller
{
    // =========================== index() ===========================
    public function index()
    {
        $com_code = get_field_value(new Admin() , 'com_code' , ['id' => auth()->user()->id]);
        $data = get_cols_where_p( new SuppliersWithOrder() , ['*'] , ['com_code' =>$com_code] , 'id' ,'ASC',PAGINATION_COUNT);
        if( !empty($data) )
        {
            foreach($data as $info)
            {
                // added_by
                $info->added_by_admin = get_field_value( new Admin() , "name" , ['id'=>$info->added_by] );
                // updated_by
                if( $info->updated_by > 0 && $info->updated_by != null )
                {
                    $info->updated_by_admin = get_field_value( new Admin() , 'name' , ['id'=>$info->updated_by]);
                }
                // supplier_name
                if( !empty($info->supplier_code) )
                {
                    $info->supplier_name = get_field_value( new Supplier() , 'name' , ['supplier_code' => $info->supplier_code ]);
                }
            }
        }
        return view('admin.suppliers_with_orders.index',['data'=>$data]);
    }
    // =========================== create() ===========================
    public function create()
    {
        $com_code = auth()->user()->com_code;
        $suppliers = get_cols_where( new Supplier() , ['name','supplier_code'] , ['com_code'=>$com_code] , 'id' , 'ASC');
        return view('admin.suppliers_with_orders.create',['suppliers' => $suppliers]);
    }
    // =========================== store() ===========================
    public function store(SuppliersWithOrdersRequest $request)
    {
        try
        {
            // Company Code
            $com_code = auth()->user()->com_code;
            // auto_serial
            $last_supplier_order = get_cols_where_row_orderby( new SuppliersWithOrder() , ['auto_serial'] , ['com_code'=>$com_code]);
            if( !empty($last_supplier_order) )
            {
                $data_insert['auto_serial'] = $last_supplier_order['auto_serial'] + 1;
            }
            else
            {
                $data_insert['auto_serial'] = 1;
            }
            $data_insert['order_date']      = $request->order_date;
            $data_insert['order_type']      = 1;
            $data_insert['doc_no']          = $request->doc_no;
            $data_insert['supplier_code']   = $request->supplier_code;
            $data_insert['pill_type']       = $request->pill_type;
            // Get "account_number" of "supplier" based on "supplier_code"
            $suplier_account_number = get_cols_where_row( new Supplier() , ['account_number'] , ['supplier_code'=>$request->supplier_code , 'com_code'=>$com_code] );
            if( empty($suplier_account_number) )
            {
                return redirect()->back()->with(['error'=>'عفواً غير قادر علي الوصول للبيانات المورد المحدد']);
            }
            else
            {
                $data_insert['account_number']  = $suplier_account_number['account_number'];
            }
            $data_insert['notes']           = $request->notes;
            $data_insert['com_code']        = $com_code;
            $data_insert['added_by']        = auth()->user()->id;
            // insert "supplier_order"
            $flag = insert_data( new SuppliersWithOrder() , $data_insert);
            if( $flag == true )
            {
                return redirect()->route('admin.suppliers_orders.index')->with('record_added','تم حفظ البيانات بنجاح');
            }
            else
            {
                return redirect()->back()->with('error','حدث خطأ اثناء تخزين البيانات');
            }
        }
        catch( \Exception $e)
        {
            dd($e);
            Log::error($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    // =========================== show() ===========================
    public function show($id)
    {
        $com_code = auth()->user()->com_code;
        // "SuppliersWithOrder" table
        $data = get_cols_where_row(new SuppliersWithOrder() , ['*'] , ['id'=>$id,'com_code'=>$com_code,"order_type"=>1]);
        if( empty($data) )
        {
            return redirect()->back()->with(['error' => 'غير قادر علي الوصول للبيانات المطلوبة']);
        }
        // added_by_admin
        $data['added_by_admin'] = Admin::where('id',$data->added_by)->value('name');
        // supplier_name
        if( !empty($data->supplier_code) )
        {
            $data->supplier_name = get_field_value( new Supplier() , 'name' , ['supplier_code' => $data->supplier_code ]);
        }
        // updated_by_admin
        if( $data->updated_by > 0 && $data->updated_by != null )
        {
            $data['updated_by_admin'] = Admin::where('id',$data->updated_by)->value('name');
        }

        return view('admin.suppliers_with_orders.show',['data' => $data ]);
    }
    // =========================== edit() ===========================
    public function edit($id)
    {
        dd($id);
    }
    // =========================== update() ===========================
    public function update(Request $request)
    {

    }
    // =========================== destroy() ===========================
    public function destroy(Request $request)
    {

    }
    // =========================== ajax_search() ===========================
    public function ajax_search(Request $request)
    {
        if( $request->ajax() )
        {

        }
    }
    // =========================== ajax request : get_item_uoms() ===========================
    public function get_item_uoms(Request $request)
    {
        if( $request->ajax() )
        {
            // com_code : company code
            $com_code = auth()->user()->com_code;
            // item_code
            $item_code = $request->item_code ;
            // get "uom_type" , "retail_uom_id" ,
            $item_card_data = get_cols_where_row( new InvItemCard() , ['does_has_retail_unit','retail_uom_id','uom_id'],['item_code'=>$item_code,'com_code'=>$com_code]);
            if( !empty($item_card_data) )
            {
                // if there are "retail_unit" : في حالة وجود وحدة تجزئه فهجيب اسم وحدة القياس الاب و الابن
                if( $item_card_data['does_has_retail_unit'] == 1 )
                {
                    // Get "parent_uom" name
                    $item_card_data['parent_uom_name'] = get_field_value( new InvUom() , 'name' , ['id'=>$item_card_data['uom_id']]);
                    // Get "retail_uom" name
                    $item_card_data['retail_uom_name'] = get_field_value( new InvUom() , 'name' , ['id'=>$item_card_data['retail_uom_id']]);
                }
                // if there No "retail_unit" : في حالة عدم وجود وحدة تجزئه فهجيب اسم وحدة القياس الاب فقط
                else
                {
                    // Get "parent_uom" name
                    $item_card_data['parent_uom_name'] = get_field_value( new InvUom() , 'name' , ['id'=>$item_card_data['uom_id']]);
                }
                return view('admin.suppliers_with_orders.get_item_uoms',['item_card_data'=> $item_card_data]);
            }
        }
    }
    // =========================== ajax request : add_new_details() ===========================
    public function add_new_details(Request $request)
    {
        try
        {
            $com_code = auth()->user()->com_code;
            $item_code = $request->item_code_add;
            // dd($item_code);
            // Check if "supplier_with_order" exists previously or not
            // هجيب "مشتريات المورد" اللي هضيف له "الاصناف" ي
            $supplier_with_order_data = get_cols_where_row( new SuppliersWithOrder() , ["tax_value",'order_date',"is_approved","discount_value"],["auto_serial"=>$request->auto_serial_parent,'com_code' => $com_code , 'order_type'=>1]);
            if( !empty($supplier_with_order_data) )
            {
                // طول ما الفاتورة لسه لم يتم اعتمادها
                if( $supplier_with_order_data['is_approved'] == 0 )
                {
                    $data_insert['suppliers_with_orders_id'] = $request->input('suppliers_with_orders_id');
                    $data_insert['suppliers_with_orders_auto_serial'] = $request->input('auto_serial_parent');
                    $data_insert['order_type'] = 1;
                    $data_insert['item_code'] = intval($item_code);
                    $data_insert['delivered_quantity'] = $request->input('quantity_add');
                    $data_insert['unit_price'] = $request->input('price_add');
                    $data_insert['uom_id'] = $request->input('uom_id_add');
                    // production_date , expire_date
                    if( $request->type == 2)
                    {
                        $data_insert['production_date'] = $request->input('production_date');
                        $data_insert['expire_date']     = $request->input('expire_date');
                    }
                    $data_insert['item_card_type']      = $request->input('type');
                    $data_insert['total_price']         = $request->input('total_add');
                    $data_insert['order_date']          = $supplier_with_order_data['order_date'];
                    $data_insert['com_code']            = $com_code;
                    $data_insert['is_parent_uom']       = $request->input('isParentUom');
                    $data_insert['added_by']            = auth()->user()->id;
                }
            }
            // insert "supplier_order"
            // dd($data_insert['item_code']);
            $flag = insert_data( new SuppliersWithOrderDetails() , $data_insert );
            // dd($flag);
            if( !empty($flag) )
            {
                // calculate the "sum" of "total_price" in "suppliers_with_orders_details" table
                $total_price_sum = get_sum_where(new SuppliersWithOrderDetails() , 'total_price' , ['suppliers_with_orders_auto_serial'=>$request->auto_serial_parent , "order_type" => 1 , 'com_code'=>$com_code]);
                // update "total_cost_items" column in "suppliers_with_orders" table
                $data_update_parent['total_cost_items'] = $total_price_sum;
                // update "total_before_discount" column in "suppliers_with_orders" table : الاجمالي قبل الخصم = اجمالي الاصناف + القيمة المضافة
                $data_update_parent['total_before_discount'] = $total_price_sum + $supplier_with_order_data['tax_value'];
                // update "total_cost" column in "suppliers_with_orders" table : الاجمالي بعد الخصم = اجمالي الاصناف قبل الخصم + قيمة الخصم
                $data_update_parent['total_cost'] = $data_update_parent['total_before_discount'] + $supplier_with_order_data['discount_value'];
                // updated_by
                $data_update_parent['updated_by']        = auth()->user()->id;
                // updated_at
                $data_update_parent['updated_at']        = date('Y-m-d H:i:s');
                // =========== Start : update "pill info" in "suppliers_with_Orders" table  ===========
                $flag2  = update_data( new SuppliersWithOrder() , $data_update_parent , ['auto_serial'=>$request->auto_serial_parent , "order_type" => 1 , 'com_code'=>$com_code]);
                // dd($flag2);
                if( $flag2 == 1 )
                {
                    // output
                    $output = [
                        'success' => true ,
                        'msg' => "تم تحديث البيانات بنجاح"
                    ];
                }
                else
                {
                    $output = [
                        'success' => false ,
                        'msg'     => "حدث مشكلة في حفظ البيانات"
                    ];
                }
                // =========== End : update "pill info" in "suppliers_with_Orders" table ===========
                // output
                $output = [
                    'success' => true ,
                    'msg' => "تم حفظ البيانات بنجاح"
                ];
            }
            else
            {
                $output = [
                    'success' => false ,
                    'msg'     => "حدث مشكلة في حفظ البيانات"
                ];
            }
            // You can redirect to a success page or perform other actions here
            // dd($item_code);
            return $output;
        }
        catch (\Exception $e)
        {
            dd($e);
        }
    }
    // ---------------- reload_item_details() Function ----------------
    public function reload_item_details(Request $request)
    {
        if ($request->ajax())
        {
            // dd($request);
            $com_code = auth()->user()->com_code;
            $auto_serial = $request->auto_serial_parent;
            $data = get_cols_where_row(new SuppliersWithOrder(), ["is_approved"], ['auto_serial' => $auto_serial, "com_code" => $com_code, 'order_type' => 1]);

            $details = [];
            if (!empty($data))
            {
                $details = get_cols_where(new SuppliersWithOrderDetails(), ['*'], ['suppliers_with_orders_auto_serial' => $auto_serial, 'order_type' => 1, 'com_code' => $com_code], 'id', 'DESC');
                // dd($details);
                foreach ($details as $info)
                {
                    // item_card_name
                    $info->item_card_name = InvItemCard::where('item_code', $info->item_code)->value('name');
                    // uom_name
                    $info->uom_name = get_field_value(new InvUom(), "name", ['id' => $info->uom_id]);
                    // added_by_admin
                    $info->added_by_admin = Admin::where('id', $info->added_by)->value('name');
                    // updated_by_admin
                    if ($info->updated_by > 0 && $info->updated_by != null)
                    {
                        $info->updated_by_admin = Admin::where('id', $info->updated_by)->value('name');
                    }
                }
            }

            // Return data as JSON
            return view('admin.suppliers_with_orders.reload_item_details',['data' => $data, 'details' => $details]);
        }
    }
    // ---------------- reload_parent_pill() Function ----------------
    public function reload_parent_pill(Request $request)
    {
        if ($request->ajax())
        {
            $com_code = auth()->user()->com_code;
            // "SuppliersWithOrder" table
            $data = get_cols_where_row(new SuppliersWithOrder() , ['*'] , ['auto_serial' => $request->auto_serial_parent,'com_code'=>$com_code,"order_type"=>1]);
            if( !empty($data) )
            {
                // added_by_admin
                $data['added_by_admin'] = Admin::where('id',$data->added_by)->value('name');
                // supplier_name
                if( !empty($data->supplier_code) )
                {
                    $data->supplier_name = get_field_value( new Supplier() , 'name' , ['supplier_code' => $data->supplier_code ]);
                }
                // updated_by_admin
                if( $data->updated_by > 0 && $data->updated_by != null )
                {
                    $data['updated_by_admin'] = Admin::where('id',$data->updated_by)->value('name');
                }
            }
            // "SuppliersWithOrderDetails" table
            $details = get_cols_where(new SuppliersWithOrderDetails() , ['*'] , ['suppliers_with_orders_auto_serial'=>$data->auto_serial,'order_type'=>1,'com_code'=>$com_code],'id','DESC');
            if( !empty($details) )
            {
                foreach( $details as $info )
                {
                    // item_card_name
                    $info->item_card_name = InvItemCard::where('item_code',$info->item_code)->value('name');
                    // uom_name
                    $info->uom_name = get_field_value(new InvUom() ,"name" , ['id' => $info->uom_id]);
                }
            }
            //  if "pill" still "open" :  هبدأ ارجع الاصناف كلها في حالة ان الفاتورة مفتوحة مش مغلقه(حصل لها ارشفة)
            if( $data['is_approved'] == 0 )
            {
                $item_cards = get_cols_where( new InvItemCard() , ['name','item_code','item_type'] , ['active'=>1 , "com_code"=>$com_code] , 'id' , 'DESC');
            }
            //  if "pill" still "close"
            else
            {
                $item_cards = [];
            }
            return view('admin.suppliers_with_orders.reload_parent_pill',['data'=>$data,"details"=>$details]);


        }
    }
    // =========================== getDropdown() ===========================
    public function getDropdown()
    {
        $suppliers = Supplier::orderBy('name', 'asc')->pluck('name', 'id');
        // supplier_dropdown
        $suppliers_dp = $this->createDropdownHtml($suppliers, 'اختر المورد');
        return $suppliers_dp;
    }
    // +++++++++++++++ Get Dropdown List ++++++++++++++++++
    public function createDropdownHtml($array, $append_text = null)
    {
        $html = '';
        if (!empty($append_text))
        {
            $html = '<option value="">' . $append_text . '</option>';
        }
        foreach ($array as $key => $value) {
            $html .= '<option value="' . $key . '">' . $value . '</option>';
        }
        return $html;
    }
    // =========================== delete_suppliers_with_orders_details() ===========================
    public function delete_suppliers_with_orders_details($id)
    {
        $item = SuppliersWithOrderDetails::findOrFail($id);
        if( isset($item) && $item != null )
        {
            $item->delete();
        }
        return redirect()->back()->with('error_msg','تم حذف البيانات بنجاح');

    }
}
