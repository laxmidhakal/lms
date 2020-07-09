<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Helper\Helper;
use Auth;
use Validator;
use Response;
use App\Borrower;

class BorrowerController extends Controller
{
  public function __construct(Request $request, Helper $helper)
  {
    $this->middleware('auth');
    $this->request = $request;
    $this->helper = $helper;
  }

  public function index()
  {
    $borrowers=Borrower::orderBy('id','DESC')->get();
    $currentPath=Route::currentRouteName();
    return view('backend.borrower.index',compact('borrowers','currentPath'));
  }

  public function create()
  {
        //
  }

  public  function check(Request $request)
  {
    if($request->get('borrower_code'))
    {
     $borrower_code = $request->get('borrower_code');
      $data = Borrower::
      where('borrower_code','=', $borrower_code)
      ->count();
     if($data > 0)
     {
      echo 'not_unique';
     }
     else
     {
      echo 'unique';
     }
    }
  }

  public function store(Request $request)
  {
    $rules = array(
      'name' => 'required',
      'address' => 'required',
      'borrower_code' => 'required|unique:borrowers',
    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return redirect('/home/borrower')
      ->withErrors($validator)
      ->withInput();
    }
    $main_store = new Borrower;
    $main_store->name = Input::get('name');
    $main_store->slug = $this->helper->slug_converter($main_store->name);
    $main_store->address=Input::get('address');
    $main_store->date_issued=Input::get('date_issued');
    $main_store->date_return=Input::get('date_return');
    $main_store->borrower_code=Input::get('borrower_code');
    $main_store->created_by = Auth::user()->id;
    if($main_store->save()){
      $notification = array(
          'message' => 'Data added successfully!',
          'alert-type' => 'success'
      );
    }else{
      $notification = array(
          'message' => 'Data could not be added!',
          'alert-type' => 'error'
      );
    }
    return back()->with($notification)->withInput();
  }

  public function show($id)
  {
        //
  }

  public function edit($id)
  {
    $currentPath=Route::currentRouteName();
    $borrowers = Borrower::where('id', $id)->get();
    return view('backend.borrower.edit', compact('borrowers','currentPath'));
  }

  public function update(Request $request, $id)
  {
   $rules = array(
     'name' => 'required',
     'address' => 'required',
     'borrower_code' => 'required',
   );
   $validator = Validator::make(Input::all(), $rules);
   if ($validator->fails()) {
     return redirect('/home/borrower')
     ->withErrors($validator)
     ->withInput();
   }
   $main_store = Borrower::find($id);
   $main_store->name = Input::get('name');
   $main_store->slug = $this->helper->slug_converter($main_store->name);
   $main_store->address=Input::get('address');
   $main_store->date_issued=Input::get('date_issued');
   $main_store->date_return=Input::get('date_return');
   $main_store->borrower_code=Input::get('borrower_code');
   $main_store->created_by = Auth::user()->id;;
   if($main_store->save()){
    $notification = array(
      'message' => 'Data updated successfully!',
      'alert-type' => 'success'
    );
    }else{
      $notification = array(
        'message' => 'Data could not be successfully!',
        'alert-type' => 'error'
      );
    }
    return redirect('/home/borrower')->with($notification);
  }

  
  public function destroy($id)
  {
    $borrow=Borrower::find($id);
    if($borrow->delete()){
      $notification = array(
          'message' => 'Data deleted successfully!',
          'alert-type' => 'success'
      );
    }else{
      $notification = array(
          'message' => 'Data could not be deleted!',
          'alert-type' => 'error'
      );
    }
    return back()->with($notification)->withInput();
  }
    
  public function isSort($value)
  {
    $id = Input::get('id');
    $sort_ids =  Borrower::find($id);
    $sort_ids->sort_id = $value;
    if($sort_ids->save()){
      $response = array(
        'status' => 'success',
        'msg' => 'Successfully change',
      );
    }else{
      $response = array(
        'status' => 'failure',
        'msg' => 'Sorry the data could not be change',
      );
    }
    return Response::json($response);
  }
  
  public function isactive(Request $request,$id)
  {
    $get_is_active = Borrower::where('id',$id)->value('is_active');
    $isactive = Borrower::find($id);
    if($get_is_active == 0){
      $isactive->is_active = 1;
      $notification = array(
        'message' => 'Data published!',
        'alert-type' => 'success'
      );
    }
    else {
      $isactive->is_active = 0;
      $notification = array(
        'message' => 'Data could not be published!',
        'alert-type' => 'error'
      );
    }
    $isactive->update();
    return back()->with($notification)->withInput();
  }
}
