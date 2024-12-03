<?php

use Illuminate\Support\Facades\Storage;
    // ++++++++++++++++++++++ upload File ++++++++++++++++++++++
    function uploadFile($request,$image_file,$folder)
    {

        $file_name = $request->file($image_file)->getClientOriginalName();
        $request->file($image_file)->storeAs('assets/admin/',$folder.'/'.$file_name,'upload_attachments');
        return $file_name;
    }
    // +++++++++++++++++++ deleteFile() function +++++++++++++++++++++++
    function deleteFile($name,$folder)
    {
        // check if "file" exists on Disk
        $exists = Storage::disk('upload_attachments')->exists('assets/admin/'.$folder.'/'.$name);
        // if "file" exists on Disk , delete it
        if($exists)
        {
            Storage::disk('upload_attachments')->delete('assets/admin/'.$folder.'/'.$name);
        }
    }
    /* +++++++++++++++++++ insert_data() function +++++++++++++++++++ */
    function insert_data($model ,$arrayToInsert = [])
    {
        $flag = $model::create($arrayToInsert);
        return $flag;
    }
    // +++++++++++++++++++ update_data() function +++++++++++++++++++++++
    function update_data($model,$data_to_update,$where)
    {
        $flag = $model::where($where)->update($data_to_update);
        // [flag = true] if "update" was successful
        return $flag;
    }
    /* +++++++++++++++++++ get_all() function +++++++++++++++++++ */
    //  get "all rows"
    function get_all($model=null, $order_field="id",$order_type="DESC",)
    {
        $data = $model::select('*')->orderby($order_field, $order_type);
        return $data;
    }
    /* +++++++++++++++++++ get_cols_where_p() function +++++++++++++++++++ */
    //  get "all rows" and "some columns" from table with pagination ( p = pagination )
    // parameter 1 : object from model , parameter 2 : array of column names , parameter 3 : array of conditions , parameter 4 : order_by column , parameter 5 : order_type , parameter 6 : paginate( number of rows)
    // هذه الدالة بستخدمها عشان ارجع عدد من الاعمدة من جدول معين  حسب الترتيب اللي انا هحدده بس هيرجع كل الصفوف
    function get_cols_where_p($model=null, $columns_names = array(), $where = array(), $order_field="id",$order_type="DESC",$paginate)
    {
        $data = $model::select($columns_names)->where($where)->orderby($order_field, $order_type)->paginate($paginate);
        return $data;
    }
    /* +++++++++++++++++++ get_cols_where() function +++++++++++++++++++ */
    //  get "all rows" and "some columns" from table without pagination ( all rows )
    // parameter 1 : object from model , parameter 2 : array of column names , parameter 3 : array of conditions , parameter 4 : order_by column , parameter 5 : order_type
    // هذه الدالة بستخدمها عشان ارجع عدد من الاعمدة من جدول معين  حسب الترتيب اللي انا هحدده بس هيرجع كل الصفوف
    function get_cols_where($model=null, $columns_names = array(), $where = array(), $order_field="id",$order_type="DESC")
    {
        $data = $model::select($columns_names)->where($where)->orderby($order_field, $order_type)->get();
        return $data;
    }
    /* +++++++++++++++++++ get_cols_where_row() function +++++++++++++++++++ */
    //  get "fjrst row" and "some columns" from table ( first row only )
    // parameter 1 : object from model , parameter 2 : array of column names , parameter 3 : array of conditions
    // هذه الدالة بستخدمها عشان ارجع عدد من الاعمدة من جدول معين بس هيرجع اول صف فقط
    function get_cols_where_row($model, $columns_names = array(), $where = array())
    {
        $data = $model::select($columns_names)->where($where)->first();
        return $data;
    }
    /* +++++++++++++++++++ get_cols_where_row_orderby() function +++++++++++++++++++ */
    //  get "fjrst row" and "some columns" from table ( first row only )
    // parameter 1 : object from model , parameter 2 : array of column names , parameter 3 : array of conditions , parameter 4 : order_by column , parameter 5 : order_type
    // هذه الدالة بستخدمها عشان ارجع عدد من الاعمدة من جدول معين بس هيرجع اول صف فقط
    function get_cols_where_row_orderby($model, $columns_names = array(), $where = array(), $order_field="id",$order_type="DESC")
    {
        $data = $model::select($columns_names)->where($where)->orderby($order_field, $order_type)->first();
        return $data;
    }
    /* +++++++++++++++++++ get_field_value() function +++++++++++++++++++ */
    // عشان اجيب قيمة عمود معين من جدول معين
    function get_field_value($model,$field_name,$where=[])
    {
        $data = $model::where($where)->value($field_name);
        return $data;
    }
    /* +++++++++++++++++++ get_field_value() function : get "sum" of "specific field" +++++++++++++++++++ */
    // عشان اجيب مجموع عمود معين من جدول معين
    function get_sum_where($model,$field_name,$where=[])
    {
        $sum = $model::where($where)->sum($field_name);
        return $sum;
    }


?>
