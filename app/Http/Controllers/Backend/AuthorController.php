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
use App\Author;
use App\Book;
use App\Book_has_author;
use DB;

class AuthorController extends Controller
{
  
  public function __construct(Request $request, Helper $helper)
  {
    $this->middleware('auth');
    $this->request = $request;
    $this->helper = $helper;
  }

  public function index()
  {
    $currentPath=Route::currentRouteName();
    $authors=Author::orderBy('id','DESC')->orderBy('sort_id','DESC')->withCount('getBookAuthor')->paginate(10);
    return view('backend.author.index',compact('authors','currentPath'));
  }

  public function create()
  {
        //
  }

  public function store(Request $request)
  {
    $rules = array(
      'name' => 'required',
      'address' => 'required',
    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return redirect('/home/author')
      ->withErrors($validator)
      ->withInput();
    }
    $main_store = new Author;
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
    
  public function isSort($value)
  {
    $id = Input::get('id');
    $sort_ids =  Author::find($id);
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

  public function show($id)
  {
        //
  }

  public function edit($id)
  {
    $authors = Author::where('id', $id)->get();
    $currentPath=Route::currentRouteName();
    return view('backend.author.edit', compact('authors','currentPath'));
  }

  public function update(Request $request, $id)
  {
    $rules = array(
      'name' => 'required',
      'address' => 'required',
    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return redirect('/home/author')
      ->withErrors($validator)
      ->withInput();
    }
    $main_store = Author::find($id);
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
          'message' => 'Data could not be updated!',
          'alert-type' => 'error'
      );
    }
    return redirect('/home/author')->with($notification);
  }

  public function destroy($id)
  {
    $author=Author::find($id);
    if($author->delete()){
      $notification = array(
          'message' => 'Data deleted successfully!',
          'alert-type' => 'success'
      );
    }else{
      $notification = array(
          'message' => 'Data couldnot be deleted!',
          'alert-type' => 'error'
      );
    }
    return back()->with($notification)->withInput();
  }

  public function isactive(Request $request,$id)
  {
    $get_is_active = Author::where('id',$id)->value('is_active');
    $isactive = Author::find($id);
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
