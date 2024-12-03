<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountTypes\AccountType;
use App\Models\Admin;
use Illuminate\Http\Request;

class AccountTypesController extends Controller
{
    // ++++++++++++++++ index() +++++++++++++++++
    public function index()
    {
        $data = AccountType::orderBy('id', 'asc')->get();
        if( !empty($data) )
        {
            foreach($data as $info)
            {
                // added_by_admin
                $info->added_by_admin = Admin::where('id',$info->added_by)->value('name');
                if( $info->updated_by > 0 && $info->updated_by != null )
                {
                    // updated_by_admin
                    $info->updated_by_admin = Admin::where('id',$info->updated_by)->value('name');
                }
            }
        }
        return view('admin.account_types.index',compact('data'));
    }
    // ++++++++++++++++ create() +++++++++++++++++
    public function create()
    {

    }
    // ++++++++++++++++ store(Request $request) +++++++++++++++++
    public function store(Request $request)
    {
        try
        {
            dd($request);
        }
        catch (\Exception $e)
        {
            dd($e);
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
    }
}
