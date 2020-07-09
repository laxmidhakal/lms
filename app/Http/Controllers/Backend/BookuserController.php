<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Helper\Helper;
use Auth;
use Validator;
use App\Bookuser;
use App\Borrower;
use App\Book;

class BookuserController extends Controller
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
        $books=Book::get();
        $borrowers=Borrower::get();
        $bookusers=Bookuser::get();
        $currentPath=Route::currentRouteName();
        return view('backend.bookuser.index',compact('books','bookusers','borrowers','currentPath'));
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
    
    public function getBorrowerDetail(){
        $borrow_id = Input::get('borrow_id');
        $borrowers = Borrower::where('id', $borrow_id)->get();
        return Response()->json($borrowers);
    }
    
    public function isSort()
    {
      $id = Input::get('id');
      $value = Input::get('value');
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

    public function detail($slug)
    {
        $borrow_id = Borrower::where('slug',$slug)->value('id'); 
        $bookusers = Bookuser::where('borrow_id',$borrow_id)->orderBy('sort_id','DESC')->orderBy('created_at','DESC')->paginate(10);
        return view('backend.bookuser.detail',compact('bookusers','borrow_id'));
    }
    
    public function add()
    {
        $books=Book::get();
        $borrowers=Borrower::get();
        $bookusers=Bookuser::get();
        $currentPath=Route::currentRouteName();
        return view('backend.bookuser.add',compact('bookusers','books','borrowers','currentPath'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $main_store = new Bookuser;
        $main_store->book_id = Input::get('book_id');
        $main_store->borrow_id = Input::get('borrow_id');
        $main_store->created_by = Auth::user()->id;
        $main_store->save();
        return back()->withInput();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
}
