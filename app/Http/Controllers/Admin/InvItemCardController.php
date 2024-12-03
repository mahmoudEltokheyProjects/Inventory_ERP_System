<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Units\InvUom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\ItemCardRequest;
use App\Models\InvItemCard\InvItemCard;
use Illuminate\Support\Facades\Storage;
use App\Models\ItemCardCategory\InvItemCardCategory;

class InvItemCardController extends Controller
{
    /* ++++++++++++++++++ index() ++++++++++++++++++ */
    public function index()
    {
        // com_code
        $com_code = Admin::where('id',auth()->user()->id)->value("com_code");
        // Get "all items" using "helper function" ==> get_cols_where_p()
        $data = get_cols_where_p( new InvItemCard() , ["*"] , ["com_code"=>$com_code] , "id" , "DESC",PAGINATION_COUNT);
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
                // Get "name" of "inv_item_card_categories" using "inv_item_card_categories_id" foreign_key from "inv_item_card_categories" table : فئة الصنف
                $info->inv_item_card_categories_name = get_field_value(new InvItemCardCategory() , "name" , ["id" => $info->inv_item_card_categories_id]);
                // Get "name" of "parent_inv_item_card" using "parent_inv_item_card_id" foreign_key from "inv_item_cards" table : الصنف الاب
                $info->parent_inv_item_card_name = get_field_value( new InvItemCard() ,"name" , ["id" => $info->parent_inv_item_card_id]);
                // Get "name" of "uom" using "uom_id" foreign_key from "inv_uoms" table : وحدة القياس الاب (الاساسية)
                $info->uom_name = get_field_value(new InvUom(),"name",["id"=>$info->uom_id]);
                // Get "name" of "retial_uom" using "retail_uom_id " foreign_key from "inv_uoms" table : وحدة القياس التجزئه
                $info->retial_uom_name = get_field_value(new InvUom(),"name",["id"=>$info->retail_uom_id]);
            }
        }
        // search "inv_itemCard_categories" selectbox
        $inv_itemCard_categories = get_cols_where(new InvItemCardCategory() ,['name','id'],[],'id','DESC');
        return view('admin.inv_item_card.index',compact('data','inv_itemCard_categories'));
    }
    /* ++++++++++++++++++ create() ++++++++++++++++++ */
    public function create()
    {
        // company_code of current "login admin"
        $com_code = auth()->user()->com_code;
        // فئة الصنف : Get "all item cards" using "helper function" ==> get_cols_where()
        $inv_itemCard_categories = get_cols_where( new InvItemCardCategory() , ["id","name"] , ["com_code"=>$com_code,"active"=>1] , 'id' ,'ASC');
        // وحدات القياس الاب (الاساسية) : is_master = 1 => Get "all inv_uom" using "helper function" ==> get_cols_where()
        $inv_uom_parent = get_cols_where( new InvUom() , ["id","name"] ,
                                        ["com_code"=>$com_code,"active"=>1,"is_master"=>1] ,
                                        'id' ,'ASC'
                                  );
        // وحدات القياس الابن (التجزئه) : is_master = 0 => Get "all inv_uom" using "helper function" ==> get_cols_where()
        $inv_uom_child = get_cols_where( new InvUom() , ["id","name"] ,
                                        ["com_code"=>$com_code,"active"=>1,"is_master"=>0] ,
                                        'id' ,'ASC'
                                  );
        $item_card_data = get_cols_where(new InvItemCard(),['id','name'],['com_code'=>$com_code,'active'=>1],'id','desc');

        return view('admin.inv_item_card.create',compact('inv_itemCard_categories',
                                                                'inv_uom_parent',
                                                                'inv_uom_child' ,
                                                                'item_card_data'
                                                            )
                                                        );
    }
    /* ++++++++++++++++++ store() ++++++++++++++++++ */
    public function store(ItemCardRequest $request)
    {
        // dd($request);
        try
        {
            // company code
            $com_code = Admin::where('id',auth()->user()->id)->value("com_code");
            // "item_code" of new "item" will be the last "item_code" increated by "1" : مجموع عليه 1 item بتاع اخر "item_code" هيكون ال "item" بتاع ال  item_code ال
            $row = get_cols_where_row_orderby(new InvItemCard(),["item_code"],["com_code"=>$com_code]);
            // ============== item_code =================
            // if there are "item_code" previously , the new "item_code" will be last "item_code" increased by "1"
            if( !empty($row) )
            {
                $data_insert['item_code'] = $row['item_code']+1;
            }
            else
            {
                $data_insert['item_code'] = 1;
            }
            // ========== "Barcode Validation" ==========
            // Check if "barcode" exists previously or not
            $checkExists_barcode = InvItemCard::where(['barcode'=>$request->barcode ,"com_code"=>$com_code])->first();
            // dd($checkExists_barcode);
            // if "barcode" inputField is "Not empty"
            if($request->barcode != '')
            {
                // if "barcode" [exists] previously
                if( !empty($checkExists_barcode) )
                {
                    return redirect()->back()->with('error_msg','عفواً باركود الصنف موجودة مسبقاً')->withInput();
                }
                // if "barcode" [doesn't exist] previously , create "barcode" [automatically]
                else
                {
                    // barcode = "item".$request->barcode
                    $data_insert['barcode'] = $request->barcode;
                }
            }
            // if "barcode" [is empty] , create "barcode" [automatically]
            else
            {
                $data_insert['barcode'] = "item" . $data_insert['item_code'];
            }
            // ======================== insert data ========================
            $data_insert['name']                         = $request->name;
            $data_insert['item_type']                    = $request->item_type;
            $data_insert['parent_inv_item_card_id']      = $request->parent_inv_item_card_id;
            $data_insert['inv_item_card_categories_id']  = $request->inv_itemCard_category_id;
            $data_insert['date']                         = Carbon::now()->format('Y-m-d');
            // +++++ parent +++++
            $data_insert['uom_id']                       = $request->inv_uom_parent_id;
            $data_insert['price']                        = $request->price;
            $data_insert['nos_gomla_price']              = $request->nos_gomla_price;
            $data_insert['gomla_price']                  = $request->gomla_price;
            $data_insert['cost_price']                   = $request->cost_price;
            // هل الصنف اب وله بينتمي لصنف اخر(ابن لصنف اخر)
            if( $data_insert['parent_inv_item_card_id'] == "")
            {
                $data_insert['parent_inv_item_card_id'] = 0;
            }
            // +++++ child +++++
            // لو الصنف ليه وحدة تجزئه
            if( $request->does_has_retail_unit == 1 )
            {
                $data_insert['does_has_retail_unit']     = $request->does_has_retail_unit;
                $data_insert['retail_uom_id']            = $request->retail_uom_id;
                $data_insert['retail_uom_to_uom']        = $request->retail_uom_to_uom;
                $data_insert['price_retail']             = $request->price_retail;
                $data_insert['nos_gomla_price_retail']   = $request->nos_gomla_price_retail;
                $data_insert['gomla_price_retail']       = $request->gomla_price_retail;
                $data_insert['cost_price_retail']        = $request->cost_price_retail;
                $data_insert['has_fixed_price']          = $request->has_fixed_price;
            }
            $data_insert['active'] = $request->active;
            // upload "image" of "item"
            if( $request->has('photo') )
            {
                $file_path = uploadFile($request,'photo','uploads/item_card/');
                $data_insert['photo'] = $file_path ;
            }
            // added_by
            $data_insert['added_by'] = auth()->user()->id ;
            // company code
            $data_insert['com_code'] = $com_code;
            // create "item card"
            InvItemCard::create($data_insert);
            return redirect()->route('inv_item_cards.index')->with('record_added', 'تم اضافة البيانات بنجاح');
        }
        catch (\Exception $e)
        {
            dd($e);
            Log::error($e);
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /* ++++++++++++++++++ edit() ++++++++++++++++++ */
    public function edit($id)
    {
        $data = InvItemCard::findOrFail($id);
        // company_code of current "login admin"
        $com_code = auth()->user()->com_code;
        // فئة الصنف : Get "all item cards" using "helper function" ==> get_cols_where()
        $inv_itemCard_categories = get_cols_where( new InvItemCardCategory() , ["id","name"] , ["com_code"=>$com_code,"active"=>1] , 'id' ,'ASC');
        // هل الصنف اب وله ينتمي لصنف اخر : هجيب كل الاصناف
        $item_card_data = get_cols_where(new InvItemCard(),['id','name'],['com_code'=>$com_code,'active'=>1],'id','desc');
        // وحدات القياس الاب (الاساسية) : is_master = 1 => Get "all inv_uom" using "helper function" ==> get_cols_where()
        $inv_uom_parent = get_cols_where( new InvUom() , ["id","name"] ,["com_code"=>$com_code,"active"=>1,"is_master"=>1] ,'id' ,'ASC');
        // وحدات القياس الابن (التجزئه) : is_master = 0 => Get "all inv_uom" using "helper function" ==> get_cols_where()
        $inv_uom_child = get_cols_where( new InvUom() , ["id","name"] ,["com_code"=>$com_code,"active"=>1,"is_master"=>0] ,'id' ,'ASC');
        return view('admin.inv_item_card.edit',compact('data','inv_itemCard_categories','item_card_data','inv_uom_parent','inv_uom_child'));
    }
    /* ++++++++++++++++++ update() ++++++++++++++++++ */
    public function update(Request $request)
    {
        try
        {
            // company code
            $com_code = auth()->user()->com_code;
            $data = InvItemCard::findOrFail($request->id);
            if (empty($data))
            {
                return redirect()->route('inv_item_cards.index')->with(['error' => 'عفوا غير قادر علي الوصول الي البيانات المطلوبة !!']);
            }
            // ++++++++++++++++++++++ Barcode Validation ++++++++++++++++++++++
            //check if "barcode" [not exsits] previously
            if ($request->barcode != '')
            {
                $checkExists_barcode = InvItemCard::where(['barcode' => $request->barcode, 'com_code' => $com_code])->where("id", "!=", $request->id)->first();
                // لو الباركود اللي المستخدم كتبه كان موجود مسبقاً وخاص بصنف اخر
                if (!empty($checkExists_barcode))
                {
                    return redirect()->back()->with(['error_msg' => 'عفوا باركود الصنف مسجل من قبل'])->withInput();
                }
                else
                {
                    $data_to_update['barcode'] = $request->barcode;
                }
            }
            // ++++++++++++++++++++++ name Validation ++++++++++++++++++++++
            // check if "name" [not exsits] previously
            $checkExists_name = InvItemCard::where(['name' => $request->name,'com_code' => $com_code])->where("id", "!=", $request->id)->first();
            if (!empty($checkExists_name))
            {
                return redirect()->back()->with(['error_msg' => 'عفوا اسم الصنف مسجل من قبل'])->withInput();
            }
            else
            {
                $data_to_update['name'] = $request->name;
            }
            // item_type : نوع الصنف
            $data_to_update['item_type'] = $request->item_type;
            // inv_itemCard_category_id : فئة الصنف
            $data_to_update['inv_item_card_categories_id'] = $request->inv_itemCard_category_id;
            // parent_inv_item_card_id : هل الصنف اب وله بينتمي لصنف اخر
            if ( $request->parent_inv_item_card_id == "" )
            {
                // الصنف اب
                $data_to_update['parent_inv_item_card_id'] = 0;
            }
            //  uom_id : وحدة القياس الاب(الاساسية)
            $data_to_update['uom_id']                   = $request->inv_uom_parent_id;
            // does_has_retail_unit : هل للصنف وحدة تجزئه
            $data_to_update['does_has_retail_unit'] = $request->does_has_retail_unit;
            if ($data_to_update['does_has_retail_unit'] == 1)
            {
                // retail_uom_to_uom : عدد وحدات التجزئه بالوحدة الاب
                $data_to_update['retail_uom_to_uom'] = $request->retail_uom_to_uom;
                // retail_uom_id : وحدة القياس التجزئه الابن بالنسبة للاب
                $data_to_update['retail_uom_id'] = $request->retail_uom_id;
            }
            // price : السعر القطاعي بوحدة القياس الاساسية
            $data_to_update['price'] = $request->price;
            // nos_gomla_price : سعر النص جملة قطاعي مع الوحدة الاساسية
            $data_to_update['nos_gomla_price'] = $request->nos_gomla_price;
            // gomla_price : سعر الجملة بوحدة القياس الاساسية
            $data_to_update['gomla_price'] = $request->gomla_price;
            // cost_price : سعر تكلفة الشراء للصنف بوحدة القياس الاساسية
            $data_to_update['cost_price'] = $request->cost_price;
            // price_retail : السعر القطاعي بوحدة قياس التجزئه
            $data_to_update['price_retail'] = $request->price_retail;
            // nos_gomla_price_retail : سعر النص جملة قطاعي مع الوحدة التجزئه
            $data_to_update['nos_gomla_price_retail'] = $request->nos_gomla_price_retail;
            // gomla_price_retail : سعر الجملة بوحدة القياس التجزئه
            $data_to_update['gomla_price_retail'] = $request->gomla_price_retail;
            // cost_price_retail :سعر تكلفة الشراء للصنف بوحدة قياس التجزئه
            $data_to_update['cost_price_retail'] = $request->cost_price_retail;
            // +++++++++++++++++ photo : upload "image" of "item" ++++++++++++++++
            // upload "image" of "item"
            if ($request->has('photo'))
            {
                // old photo
                $oldphotoPath = $data['photo'];
                // upload "photo" of "item"
                $the_file_path = uploadFile($request,'photo','uploads/item_card/');
                // Delete "old photo" of "item"
                deleteFile($oldphotoPath,'uploads/item_card/');
                // store new "photo" in DB
                $data_to_update['photo'] = $the_file_path;
            }
            // has_fixed_price : هل للصنف سعر ثابت
            $data_to_update['has_fixed_price'] = $request->has_fixed_price;
            // active : حالة الصنف
            $data_to_update['active'] = $request->active;
            // updated_by : تم التعديل بواسطة
            $data_to_update['updated_by'] = auth()->user()->id;
            // ========== update "item" using "update_data" helper function ==========
            update_data(new InvItemCard() ,$data_to_update,["id"=>$request->id,"com_code"=>$com_code]);
            return redirect()->route('inv_item_cards.index')->with(['record_updated' => 'لقد تم تحديث البيانات بنجاح']);
        }
        catch (\Exception $e)
        {
            dd($e);
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ ما' . $e->getMessage()])->withInput();
        }
    }
    /* ++++++++++++++++++ destroy() ++++++++++++++++++ */
    public function destroy(Request $request)
    {
        try
        {
            // company code
            $com_code = Admin::where('id',auth()->user()->id)->value("com_code");
            // Get data of deleted "item"
            $item = get_cols_where_row(new InvItemCard() , ['*'],["id"=>$request->id,"com_code"=>$com_code]);
            if( !empty($item) )
            {
                // Delete Item "Image" From "Disk"
                deleteFile($item->photo,"uploads/item_card");
                // Delete Item "Image" From "DB"
                $item->delete();
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
            return redirect()->back()->with(['error' => 'عفوا حدث خطأ ما' . $e->getMessage()])->withInput();
        }
    }
    /* ++++++++++++++++++ show() ++++++++++++++++++ */
    public function show($id)
    {
        // company code
        $com_code = Admin::where('id',auth()->user()->id)->value('com_code');
        // Get "data" of "item"
        $info = get_cols_where_row( new InvItemCard() ,["*"], ['id' => $id,'com_code'=>$com_code]);
        if( !empty($info) && $info != null)
        {
            // وحدة القياس الاب
            $info['Uom_name'] = get_field_value(new InvUom(), 'name', array('id' => $info['uom_id']));
            // وحدة القياس التجزئه
            if ($info['does_has_retail_unit'] == 1)
            {
                $info['retail_uom_name'] = get_field_value(new InvUom(), 'name', array('id' => $info['retail_uom_id']));
            }
            if( !empty($info) )
            {
                // added_by_admin
                $info['added_by_admin'] = get_field_value( new Admin() , 'name' ,['id'=>$info->added_by]);
                // updated_by_admin
                if( $info->updated_by > 0 && $info->updated_by != null)
                {
                    $info['updated_by_admin'] = get_field_value( new Admin() , 'name' ,['id'=>$info->updated_by]);
                }
                return view('admin.inv_item_card.show',compact('info'));
            }
        }
        else
        {
            return redirect()->back()->with(['error_msg' => 'غير قادر علي الوصول للبيانات المطلوبة']);
        }
    }
    // ++++++++++++ Download_attachment ++++++++++++
    public function Download_attachment($fileName)
    {
        return response()->download(public_path('assets/admin/uploads/item_card/'.$fileName));
    }
    // ++++++++++++ view Attachment ++++++++++++
    public function view_attachment($file_name)
    {
        return response()->file(public_path('assets/admin/uploads/item_card/'.$file_name));
    }
    /* ++++++++++++ Delete_attachment() : Delete Item photo ++++++++++++ */
    public function Delete_attachment(Request $request)
    {
        try
        {
            $item = InvItemCard::findOrFail($request->id);
            // Delete "photo" From "Disk" using "deleteFile()" helper function
            deleteFile($item->photo,'uploads/item_card/');
            // Delete "photo" From "DB" , Set 'photo" column with "empty value"
            InvItemCard::where('id', $request->id)->where('photo',$item->photo)->update(['photo'=>'']);
            return redirect()->back()->with('success','تم حذف الصورة بنجاح');
        }
        catch(\Exception $e)
        {
            dd($e);
            return redirect()->back()->with('record_deleted','فشل عملية حذف الصورة');
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
            // [item_type_search] "selectbox value"
            $item_type_search = $request->item_type_search;
            // "inv_itemCard_category_id_search selectbox" value
            $inv_itemCard_category_id_search = $request->inv_itemCard_category_id_search;
            // +++++++++++++++ Filter 1 : search_by_text +++++++++++++++
            //  if search_by_text = "" : بتعها اكبر من 0 فهيجيب كل حاجة id لو حقل البحث "فارغ" هيجيب "كل الفئات" اللي ال
            if( $search_by_text == "" )
            {
                $field1 = "id";
                $operator1 = ">";
                $value1 = "0";
            }
            else
            {
                // if "search_by_text" using "name"      then $field1 = "name";
                // if "search_by_text" using "barcode"   then $field1 = "barcode";
                // if "search_by_text" using "item_code" then $field1 = "item_code";
                $field1 = $search_by_text_radio;
                $operator1 = "LIKE";
                $value1 = "%{$search_by_text}%";
            }
            // +++++++++++++++ Filter 2 : item_type_search +++++++++++++++
            //  if [item_type_search = "all"] => Search By "id > 0" بتعها اكبر من 0 فهيجيب كل حاجة id لو ببحث "بالكل" هيجيب "كل الفئات" اللي ال
            if( $item_type_search == "all" )
            {
                $field2 = "id";
                $operator2 = ">";
                $value2 = "0";
            }
            //  if [item_type != "all"] => Search By "item_type" بتعها بيساوي الاختيار اللي المستخدم اختاره item_type لو ببحث "بالكل" هيجيب "كل الفئات" اللي ال
            else
            {
                $field2 = "item_type";
                $operator2 = "=";
                $value2 = $item_type_search;
            }
            // +++++++++++++++ Filter 3 : inv_itemCard_category_id_search +++++++++++++++
            //  if [inv_itemCard_category_id_search = "all"] => Search By "id > 0" بتعها اكبر من 0 فهيجيب كل حاجة id لو ببحث "بالكل" هيجيب "كل الفئات" اللي ال
            if( $inv_itemCard_category_id_search == "all" )
            {
                $field3 = "id";
                $operator3 = ">";
                $value3 = "0";
            }
            //  if [inv_itemCard_category_id_search != "all"] => Search By "inv_item_card_categories_id" بتعها بيساوي الاختيار اللي المستخدم اختاره inv_itemCard_category_id لو ببحث "بالكل" هيجيب "كل الفئات" اللي ال
            else
            {
                $field3 = "inv_item_card_categories_id";
                $operator3 = "=";
                $value3 = $inv_itemCard_category_id_search;
            }
            // Get "ItemCard" that "match" the "search value"
            $data = InvItemCard::where($field1,$operator1,$value1)
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
                    // Get "name" of "inv_item_card_categories" using "inv_item_card_categories_id" foreign_key from "inv_item_card_categories" table : فئة الصنف
                    $info->inv_item_card_categories_name = get_field_value(new InvItemCardCategory() , "name" , ["id" => $info->inv_item_card_categories_id]);
                    // Get "name" of "parent_inv_item_card" using "parent_inv_item_card_id" foreign_key from "inv_item_cards" table : الصنف الاب
                    $info->parent_inv_item_card_name = get_field_value( new InvItemCard() ,"name" , ["id" => $info->parent_inv_item_card_id]);
                    // Get "name" of "uom" using "uom_id" foreign_key from "inv_uoms" table : وحدة القياس الاب (الاساسية)
                    $info->uom_name = get_field_value(new InvUom(),"name",["id"=>$info->uom_id]);
                    // Get "name" of "retial_uom" using "retail_uom_id " foreign_key from "inv_uoms" table : وحدة القياس التجزئه
                    $info->retial_uom_name = get_field_value(new InvUom(),"name",["id"=>$info->retail_uom_id]);
                }
            }
            return view('admin.inv_item_card.partials.ajax_search',['data'=>$data]);
        }
    }
}
