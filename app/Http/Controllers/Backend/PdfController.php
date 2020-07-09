<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Helper\Helper;
use Auth;
use Validator;
use File;
use Response;
use App\Book;
use App\Book_has_pdf;
use Redirect;
use Session;

class PdfController extends Controller
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

    public function index($slug)
    {
      $currentPath=Route::currentRouteName();
      $book_id = Book::where('slug',$slug)->value('id'); 
      $pdfs = Book_has_pdf::where('book_id',$book_id)->orderBy('sort_id','DESC')->orderBy('created_at','DESC')->paginate(10);
      return view('backend.pdf.index',compact('book_id','currentPath','pdfs'));
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
      $main_store = new Book_has_pdf;
      $main_store->book_id = Input::get('book_id');        
      $main_store->title = Input::get('title');
      $pdf = Input::file('pdf');
      if($pdf != ""){
         $rules = array(
            'pdf' => 'required|mimes:pdf',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
        return redirect('/home/pdf')
        ->withErrors($validator)
        ->withInput();
        }
        $destinationPath = 'images/pdf/';
        $extension = $pdf->getClientOriginalExtension(); 
        $fileName = md5(mt_rand()).'.'.$extension; 
        $pdf->move($destinationPath, $fileName); 
        $file_path = $destinationPath.'/'.$fileName;
        $main_store->pdf_enc = $fileName;
        $main_store->pdf = $pdf->getClientOriginalName();
      }
      $main_store->created_by = Auth::user()->id;
      if($main_store->save()){
        $notification = array(
          'message' => 'Data added successfully!',
          'alert-type' => 'success'
        );
      }else{
        $notification = array(
          'message' => 'Data could not be added!!!',
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
      $pdfs = Book_has_pdf::where('id', $id)->get();
      return view('backend.pdf.edit', compact('pdfs','currentPath'));
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
      $main_store=Book_has_pdf::find($id);
      $main_store->title = Input::get('title');
      $pdf = Input::file('pdf');
      if($pdf != ""){
        $rules = array(
          'pdf' => 'required|mimes:pdf',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
          return redirect('/home/book')
          ->withErrors($validator)
          ->withInput();
        }
        $destinationPath = 'images/pdf/'; 
        $oldFilename=$destinationPath.$main_store->pdf_enc;
        if(File::exists($oldFilename)) {
          File::delete($oldFilename);
        }
        $extension = $pdf->getClientOriginalExtension(); 
        $fileName = md5(mt_rand()).'.'.$extension; 
        $pdf->move($destinationPath, $fileName); 
        $file_path = $destinationPath.'/'.$fileName;
        $main_store->pdf_enc = $fileName;
        $main_store->pdf = $pdf->getClientOriginalName();
      }
      if($main_store->update()){
        $notification = array(
          'message' => 'Data updated successfully!',
          'alert-type' => 'success'
        );
      }else{
        $notification = array(
          'message' => 'Data could not be updated !',
          'alert-type' => 'error'
        );
      }
      return back()->with($notification)->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pdf=Book_has_pdf::find($id);
        $destinationPath = 'images/pdf/'; // upload path
        $oldFilename=$destinationPath.$pdf->pdf_enc;
        if(File::exists($oldFilename)) {
            File::delete($oldFilename);
        }
        if($pdf->delete()){
            $notification = array(
                'message' => 'Data deleted successfully!!',
                'alert-type' => 'error'
            );
        }else{
            $notification = array(
                'message' => 'Data could not be deleted!!',
                'alert-type' => 'error'
            );
        }
        return back()->with($notification)->withInput();
    }

    public function isactive(Request $request,$id)
    {
      $get_is_active = Book_has_pdf::where('id',$id)->value('is_active');
      $isactive = Book_has_pdf::find($id);
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

    public function isSort($value)
    {
      $id = Input::get('id');
      $sort_ids =  Book_has_pdf::find($id);
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
