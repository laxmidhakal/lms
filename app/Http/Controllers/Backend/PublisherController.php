<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Helper\Helper;
use Auth;
use Response;
use Validator;
use App\Publisher;
use App\Book;

class PublisherController extends Controller
{
   
  public function __construct(Request $request, Helper $helper)
  {
    $this->middleware('auth');
    $this->request = $request;
    $this->helper = $helper;
  }

  public function index()
  {
    $publishers=Publisher::orderBy('id','DESC')->orderBy('sort_id','DESC')->orderBy('created_at','DESC')->paginate(10);
    $currentPath=Route::currentRouteName();
    return view('backend.publisher.index',compact('publishers','currentPath'));
  }

  public function create()
  {
        //
  }
  
  public function detail($slug)
  {
    $publisher_id = Publisher::where('slug',$slug)->value('id'); 
    $books = Book::where('publisher_id',$publisher_id)->orderBy('sort_id','DESC')->orderBy('created_at','DESC')->paginate(10);
    $currentPath=Route::currentRouteName();
    return view('backend.publisher.detail',compact('books','publisher_id','currentPath'));
  }

  public function store(Request $request)
  {
    $rules = array(
      'name' => 'required',
      'address' => 'required',
    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return redirect('/home/publisher')
      ->withErrors($validator)
      ->withInput();
    }
    $main_store = new Publisher;
    $main_store->name = Input::get('name');
    $main_store->slug = $this->helper->slug_converter($main_store->name);
    $main_store->address = Input::get('address');
    $main_store->created_by = Auth::user()->id;
    if($main_store->save()){
      $notification = array(
        'message' => 'Data added successfully!',
        'alert-type' => 'success'
      );
    }else{
      $notification = array(
        'message' => 'Data added successfully!',
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
    $publishers = Publisher::where('id', $id)->get();
    return view('backend.publisher.edit', compact('publishers','currentPath'));
  }

  public function update(Request $request, $id)
  {
    $rules = array(
      'name' => 'required',
      'address' => 'required',
    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return redirect('/home/publisher')
      ->withErrors($validator)
      ->withInput();
    }
    $main_store = Publisher::find($id);
    $main_store->name = Input::get('name');
    $main_store->slug = $this->helper->slug_converter($main_store->name);
    $main_store->address = Input::get('address');
    $main_store->created_by = Auth::user()->id;
    if($main_store->save()){
      $notification = array(
        'message' => 'Data updated successfully!',
        'alert-type' => 'success'
      );
    }else{
      $notification = array(
        'message' => 'Data could not be updated successfully!',
        'alert-type' => 'error'
      );
    }
    return redirect('/home/publisher')->with($notification);
  }

  public function destroy($id)
  {
    $publisher=Publisher::find($id);
    if($publisher->delete()){
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

  public function isactive(Request $request,$id)
  {
    $get_is_active = Publisher::where('id',$id)->value('is_active');
    $isactive = Publisher::find($id);
    if($get_is_active == 0){
      $isactive->is_active = 1;
      $notification = array(
        'message' => 'Data is published!',
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
    
  public function isSort($value)
  {
    $id = Input::get('id');
    $sort_ids =  Publisher::find($id);
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
}
