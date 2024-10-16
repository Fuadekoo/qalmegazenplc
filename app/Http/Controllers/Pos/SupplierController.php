<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\User;


class SupplierController extends Controller
{
    //
    public function index(){
        // this is for get all data from supplier table
        // $suppliers = Supplier::all();
        // this is for get all data from supplier table in descending order
        $suppliers = Supplier::latest()->get();
        return view('backend.supplier.supplier_all', compact('suppliers'));
    }  //end method

    public function create(){
        return view('backend.supplier.supplier_add');
    }  //end method

    public function store(){
    supplier::insert([
        'name' => request('name'),
        'mobile_no' => request('mobile_no'),
        'email' => request('email'),
        'address' => request('address'),
        'created_by' => Auth::User()->id,
        'created_at' => Carbon::now()
    ]);
    $notification = array(
        'message' => 'Supplier Added Successfully',
        'alert-type' => 'success'
    );

    return redirect()->route('supplier.all')->with($notification);
    }

    public function edit($id){
        // this is used for get single data from supplier table
        $supplier=Supplier::findOrFail($id);
        return view('backend.supplier.supplier_edit',compact('supplier'));
    } //end method

    public function update(Request $request){
        $id = request('id');
        Supplier::findOrFail($id)->update([
            'name' => $request->name,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'address' => $request->address,
            'updated_by' => Auth::User()->id,
            'updated_at' => Carbon::now()
        ]);
        $notification = array(
            'message' => 'Supplier Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('supplier.all')->with($notification);
    }

    public function destroy($id){
        Supplier::findOrFail($id)->delete();
        $notification = array(
            'message' => 'Supplier Deleted Successfully',
            'alert-type' => 'error'
        );

        return redirect()->route('supplier.all')->with($notification);
    }

}
