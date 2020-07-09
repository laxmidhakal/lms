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
use App\Bookrack;
use App\Book;


class BookRackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(Request $request, Helper $helper)
    {
    $this->middleware('auth');
    $this->request = $request;
    $this->helper = $helper;
    }

    public function index()
    {
      $bookracks=Bookrack::orderBy('id','DESC')->orderBy('sort_id','DESC')->orderBy('created_at','DESC')->paginate(10);
      $currentPath=Route::currentRouteName();
      return view('backend.bookrack.index',compact('bookracks','currentPath'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function detail($slug)
    {
      $bookrack_id = Bookrack::where('slug',$slug)->value('id'); 
      $books = Book::where('bookrack_id',$bookrack_id)->orderBy('sort_id','DESC')->orderBy('created_at','DESC')->paginate(10);
      $currentPath=Route::currentRouteName();
      return view('backend.bookrack.detail',compact('books','bookrack_id','currentPath'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $rules = array(
        'title' => 'required|unique:bookracks',
      );
      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
        return redirect('/home/bookrack')
        ->withErrors($validator)
        ->withInput();
      }
      $main_store = new Bookrack;
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $currentPath=Route::currentRouteName();
      $bookracks = Bookrack::where('id', $id)->get();
      return view('backend.bookrack.edit', compact('bookracks','currentPath'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $rules = array(
        'title' => 'required|unique:bookracks',
      );
      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
        return redirect('/home/bookrack')
        ->withErrors($validator)
        ->withInput();
      }
      $main_store = Bookrack::find($id);
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
          'message' => 'Data could not be updated!!',
          'alert-type' => 'error'
        );
      }
      return redirect('/home/bookrack')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $bookrack=Bookrack::find($id);
      if($bookrack->delete()){
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
      $get_is_active = Bookrack::where('id',$id)->value('is_active');
      $isactive = Bookrack::find($id);
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
    
    public function isSort($value)
    {
      $id = Input::get('id');
      $sort_ids =  Bookrack::find($id);
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
