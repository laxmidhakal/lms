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
use App\Book;
use App\Author;
use App\Book_has_author;

class BookAuthorController extends Controller
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
        $books=Book::orderBy('id','DESC')->orderBy('sort_id','DESC')->get();
        $authors = Author::orderBy('id','DESC')->orderBy('sort_id','DESC')->get();
        $bookhasauthors=Book_has_author::orderBy('id','DESC')->orderBy('sort_id','DESC')->get();
        $currentPath=Route::currentRouteName();
        return view('backend.bookhasauthor.index',compact('books','authors','bookhasauthors','currentPath'));
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
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $author_id = Input::get('author_id');
        foreach( $author_id AS $author ){
            $bookhasauthor = new Book_has_author;
            $bookhasauthor->author_id = $author;
            $bookhasauthor->book_id = Input::get('book_id');
            $bookhasauthor->created_by = Auth::user()->id;
            if($bookhasauthor->save()){
              $notification = array(
                  'message' => 'Data stored successfully!',
                  'alert-type' => 'success'
              );
            }else{
              $notification = array(
                  'message' => 'Data couldnot be deleted!',
                  'alert-type' => 'error'
              );
            }
            ;
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
        $bookauthors = Book_has_author::where('id', $id)->get();
        $books=Book::get();
        $authors = Author::get();
        $currentPath=Route::currentRouteName();
        return view('backend.bookhasauthor.edit', compact('bookauthors','books','authors','currentPath'));
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
        $author_id = Input::get('author_id');
        $bookhasauthor = Book_has_author::find($id);
        $bookhasauthor->author_id = $author_id;
        $bookhasauthor->book_id = Input::get('book_id');
        $bookhasauthor->created_by = Auth::user()->id;
        if($bookhasauthor->save()){
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
        return redirect('/home/bookhasauthor')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $borrow=Book_has_author::find($id);
        if($borrow->delete()){
            $notification = array(
                'message' => 'Data deleted successfully!',
                'alert-type' => 'success'
            );
        }else{
            $notification = array(
                'message' => 'Data could not be deleted',
                'alert-type' => 'error'
            );
        }
        return back()->with($notification)->withInput();
    }
    
    public function isSort($value)
    {
      $id = Input::get('id');
      $sort_ids =  Book_has_author::find($id);
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
      $get_is_active = Book_has_author::where('id',$id)->value('is_active');
      $isactive = Book_has_author::find($id);
      if($get_is_active == 0){
        $isactive->is_active = 1;
        $notification = array(
            'message' => 'Data is published!!',
            'alert-type' => 'success'
        );
      }
      else {
        $isactive->is_active = 0;
        $notification = array(
            'message' => 'Data could not be published!!',
            'alert-type' => 'error'
        );
      }
      $isactive->update();
      return back()->with($notification)->withInput();
    }
}
