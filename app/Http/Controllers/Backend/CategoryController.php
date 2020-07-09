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
use App\Category;

class CategoryController extends Controller
{
  public function __construct(Request $request, Helper $helper)
  {
    $this->middleware('auth');
    $this->request = $request;
    $this->helper = $helper;
  }

  public function index()
  {
    $categories=Category::orderBy('id','DESC')->orderBy('sort_id', 'DESC')->paginate(5);
    $currentPath=Route::currentRouteName();
    return view('backend.category.index',compact('categories','currentPath'));
  }

  public function create()
  {
        //
  }

  public function store(Request $request)
  {
    $rules = array(
      'title' => 'required|unique:categories',
    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return redirect('/home/category')
      ->withErrors($validator)
      ->withInput();
    }
    $main_store = new Category;
    $main_store->title = Input::get('title');
    $main_store->slug = $this->helper->slug_converter($main_store->title);
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

  public function isSort($value)
  {
    $id = Input::get('id');
    $sort_ids =  Category::find($id);
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
   
  public function edit($id)
  {
    $categories = Category::where('id', $id)->get();
    $currentPath=Route::currentRouteName();
    return view('backend.category.edit', compact('categories','currentPath'));
  }

  public function update(Request $request, $id)
  {
    $rules = array(
      'title' => 'required|unique:categories',
    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()
      ->withErrors($validator)
      ->withInput();
    }
    $main_store =Category::find($id);
    $main_store->title = Input::get('title');
    $main_store->slug = $this->helper->slug_converter($main_store->title);
    $main_store->created_by = Auth::user()->id;
    if($main_store->save()){
      $notification = array(
        'message' => 'Data updated successfully!',
        'alert-type' => 'success'
      );
    }else{
      $notification = array(
        'message' => 'Data could not be updated!',
        'alert-type' => 'error'
      );
    }
    return redirect('/home/category')->with($notification);
  }

  public function destroy($id)
  {
    $category=Category::find($id);
    if($category->delete()){
      $notification = array(
        'message' => 'Data deleted successfully!',
        'alert-type' => 'success'
      );
    }else{
      $notification = array(
        'message' => 'Data cannot be deleted successfully!',
        'alert-type' => 'error'
      );
    }
    return back()->with($notification)->withInput();
  }
  
  public function isactive(Request $request,$id)
  {
    $get_is_active = Category::where('id',$id)->value('is_active');
    $isactive = Category::find($id);
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
}
