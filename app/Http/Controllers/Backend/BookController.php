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
use App\Book_has_author;
use App\Category;
use App\Author;
use App\Publisher;
use App\Supplier;
use App\Borrower;
use App\Bookrack;
use Redirect;
use Session;

class BookController extends Controller
{
    
  public function __construct(Request $request, Helper $helper)
  {
    $this->middleware('auth');
    $this->request = $request;
    $this->helper = $helper;
  }

  public function index()
  {
    $books=Book::orderBy('id','DESC')->get();
    $authors=Author::get();
    $publishers=Publisher::get();
    $bookracks=Bookrack::get();
    $publisher_id = Publisher::get(); 
    $currentPath=Route::currentRouteName();
    return view('backend.book.index',compact('books','authors','publishers','bookracks','publisher_id','currentPath'));
  }

  public function create()
  {
    $books=Book::get();
    $author_id = Author::value('id');
    $publishers = Publisher::get();
    $bookracks = Bookrack::get();
    $authors=Author::get();
    $currentPath=Route::currentRouteName();
    return view('backend.book.create',compact('books','author_id','publishers','bookracks','authors','currentPath'));
  }

  public function pdf()
  {
    $books=Book::get();
    $publishers = Publisher::get();
    $bookracks = Bookrack::get();
    $authors=Author::get();
    return view('backend.pdf.index',compact('books','publishers','bookracks','authors'));
  }

  public function store(Request $request)
  {
    $rules = array(
      'title' => 'required|unique:books',
      'information' => 'required',
      'bookcode' => 'required',
      'edition' => 'required',
      'place' => 'required',
      'year_of_publication' => 'required',
      'physical_description_a' => 'required',
      'broad_subject_heading' => 'required',
      'keywords' => 'required',
      'geographical_descriptors' => 'required',
      'language_of_text' => 'required',
      'type_of_material' => 'required',
      'accession_no' => 'required',

    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()
      ->withErrors($validator)
      ->withInput();
    }
    $main_store = new Book;
    $main_store->title = Input::get('title');
    $main_store->slug = $this->helper->slug_converter($main_store->title);
    $image = Input::file('image');
    if($image != ""){
      $rules = array(
        'image' => 'required|mimes:jpeg,jpg|max:1024',
      );
      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
      return redirect('/home/book/add')
      ->withErrors($validator)
      ->withInput();
      }
      $destinationPath = 'images/coverimage/'; // upload path
      $extension = $image->getClientOriginalExtension(); // getting image extension
      $fileName = md5(mt_rand()).'.'.$extension; // renameing image
      $image->move($destinationPath, $fileName); /*move file on destination*/
      $file_path = $destinationPath.'/'.$fileName;
      $main_store->image_enc = $fileName;
      $main_store->image = $image->getClientOriginalName();
    }
    $main_store->information = Input::get('information');
    $main_store->worksheet = Input::get('worksheet');
    $main_store->language = Input::get('language');
    $main_store->bookcode = Input::get('bookcode');
    $main_store->corporate_body = Input::get('corporate_body');
    $main_store->edition = Input::get('edition');
    $main_store->place = Input::get('place');
    $main_store->year_of_publication = Input::get('year_of_publication');
    $main_store->physical_description_a = Input::get('physical_description_a');
    $main_store->physical_description_b = Input::get('physical_description_b');
    $main_store->language_of_text = Input::get('language_of_text');
    $main_store->series_statement = Input::get('series_statement');
    $main_store->note = Input::get('note');
    $main_store->broad_subject_heading = Input::get('broad_subject_heading');
    $main_store->keywords = Input::get('keywords');
    $main_store->geographical_descriptors = Input::get('geographical_descriptors');
    $main_store->isbn = Input::get('isbn');
    $main_store->issn = Input::get('issn');
    $main_store->year_of_publication = Input::get('year_of_publication');
    $main_store->country = Input::get('country');
    $main_store->meeting = Input::get('meeting');
    $main_store->national_union_catologue_no = Input::get('national_union_catologue_no');
    $main_store->copyright_no = Input::get('copyright_no');
    $main_store->type_of_material = Input::get('type_of_material');
    $main_store->accession_no = Input::get('accession_no');
    $main_store->publisher_id = Input::get('publisher_id');        
    $main_store->bookrack_id = Input::get('bookrack_id');  
    $main_store->created_by = Auth::user()->id;
    if($main_store->save()){
      $book_pdf = new Book_has_pdf();
      $uppdf = $request->file('pdf');
      $book_pdf->book_id = $main_store->id;
      if($uppdf != ""){
       $rules = array(
        'pdf' => 'required|mimes:pdf',
      );
       $validator = Validator::make(Input::all(), $rules);
       if ($validator->fails()) {
        return redirect('/home/book/create')
        ->withErrors($validator)
        ->withInput();
      }
      $destinationPath = 'images/pdf/';
      $extension = $uppdf->getClientOriginalExtension();
      $fileName = md5(mt_rand()).'.'.$extension;
      $uppdf->move($destinationPath, $fileName);
      $file_path = $destinationPath.'/'.$fileName;
      $book_pdf->title = Input::get('title');;
      $book_pdf->pdf = $fileName;
      $book_pdf->pdf_enc = $fileName;
      $book_pdf->is_active = '1';
      $book_pdf->sort_id = '0';
      $book_pdf->created_by = Auth::user()->id;
      $book_pdf->save();
      }
      $authors = $request->author_id;
      if($authors != ""){
        foreach ($authors as $author) {
          $book_author = new Book_has_author();
          $book_author->book_id = $main_store->id;
          $book_author->author_id = $author;
          $book_author->is_active = '1';
          $book_author->sort_id = '0';
          $book_author->created_by = Auth::user()->id;
          $book_author->save();
        }
      }
      $notification = array(
          'message' => 'Data stored successfully!',
          'alert-type' => 'success'
      );
    }else{
      $notification = array(
        'message' => 'Data could not be stored !',
        'alert-type' => 'error'
      );
    }
    return redirect()->route('bookpdf',['slug' => $main_store->slug])->with($notification);
  }

  public function show($id)
  {
      //
  }

  public function edit($id)
  {
    $books = Book::where('id', $id)->get();
    $publishers=Publisher::get();
    $bookracks=Bookrack::get();
    $currentPath=Route::currentRouteName();
    return view('backend.book.edit', compact('books','publishers','bookracks','currentPath'));
  }

  public function update(Request $request, $id)
  {
    $rules = array(
      'title' => 'required',
      'information' => 'required',
      'bookcode' => 'required',
      'edition' => 'required',
      'place' => 'required',
      'year_of_publication' => 'required',
      'physical_description_a' => 'required',
      'broad_subject_heading' => 'required',
      'keywords' => 'required',
      'geographical_descriptors' => 'required',
      'language_of_text' => 'required',
      'type_of_material' => 'required',
      'accession_no' => 'required',
    );
    $validator = Validator::make(Input::all(), $rules);
    if ($validator->fails()) {
      return back()
      ->withErrors($validator)
      ->withInput();
    }
    $main_store = Book::find($id);
    $main_store->title = Input::get('title');
    $main_store->slug = $this->helper->slug_converter($main_store->title);
    $image = Input::file('image');
    if($image != ""){
      $rules = array(
        'image' => 'required|mimes:jpeg,jpg|max:1024',
      );
      $validator = Validator::make(Input::all(), $rules);
      if ($validator->fails()) {
      return redirect('/home/book')
      ->withErrors($validator)
      ->withInput();
      }
      $destinationPath = 'images/coverimage/'; // upload path
      $oldFilename=$destinationPath.$main_store->image_enc;
      if(File::exists($oldFilename)) {
          File::delete($oldFilename);
      }
      $extension = $image->getClientOriginalExtension(); // getting image extension
      $fileName = md5(mt_rand()).'.'.$extension; // renameing image
      $image->move($destinationPath, $fileName); /*move file on destination*/
      $file_path = $destinationPath.'/'.$fileName;
      $main_store->image_enc = $fileName;
      $main_store->image = $image->getClientOriginalName();
    }
    $main_store->information = Input::get('information');
    $main_store->worksheet = Input::get('worksheet');
    $main_store->language = Input::get('language');
    $main_store->bookcode = Input::get('bookcode');
    $main_store->corporate_body = Input::get('corporate_body');
    $main_store->edition = Input::get('edition');
    $main_store->place = Input::get('place');
    $main_store->year_of_publication = Input::get('year_of_publication');
    $main_store->physical_description_a = Input::get('physical_description_a');
    $main_store->physical_description_b = Input::get('physical_description_b');
    $main_store->language_of_text = Input::get('language_of_text');
    $main_store->series_statement = Input::get('series_statement');
    $main_store->note = Input::get('note');
    $main_store->broad_subject_heading = Input::get('broad_subject_heading');
    $main_store->keywords = Input::get('keywords');
    $main_store->geographical_descriptors = Input::get('geographical_descriptors');
    $main_store->isbn = Input::get('isbn');
    $main_store->issn = Input::get('issn');
    $main_store->year_of_publication = Input::get('year_of_publication');
    $main_store->country = Input::get('country');
    $main_store->meeting = Input::get('meeting');
    $main_store->national_union_catologue_no = Input::get('national_union_catologue_no');
    $main_store->copyright_no = Input::get('copyright_no');
    $main_store->type_of_material = Input::get('type_of_material');
    $main_store->accession_no = Input::get('accession_no');
    $main_store->publisher_id = Input::get('publisher_id');        
    $main_store->bookrack_id = Input::get('bookrack_id');  
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
    return redirect('/home/book')->with($notification);
  }

    
  public function destroy($id)
  {
    $book=Book::find($id);
    $destinationPath = 'images/coverimage/'; // upload path
    $oldFilename=$destinationPath.$book->image_enc;
    if(File::exists($oldFilename)) {
        File::delete($oldFilename);
    }
    $destinationPath = 'files/pdf/'; // upload path
    $oldFilename=$destinationPath.$book->pdf_enc;
    if(File::exists($oldFilename)) {
        File::delete($oldFilename);
    }
    if($book->delete()){
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
    return redirect('/home/book')->with($notification);
  }

  public function ispdf(Request $request,$id)
  {
    $get_is_pdf = Book::where('id',$id)->value('is_pdf');
    $ispdf = Book::find($id);
    if($get_is_pdf == 0){
      $ispdf->is_pdf = 1;
      $this->request->session()->flash('alert-success', 'Data  published!!');
    }
    else {
      $ispdf->is_pdf = 0;
      $this->request->session()->flash('alert-danger', 'Data could not be published!!');
    }
    $ispdf->update();
    return back()->withInput();
  }

  public function isactive(Request $request,$id)
  {
    $get_is_active = Book::where('id',$id)->value('is_active');
    $isactive = Book::find($id);
    if($get_is_active == 0){
      $isactive->is_active = 1;
      $notification = array(
          'message' => 'Data is published!!!',
          'alert-type' => 'success'
      );
    }
    else {
      $isactive->is_active = 0;
      $notification = array(
          'message' => 'Data could not be published!!!',
          'alert-type' => 'error'
      );
    }
    $isactive->update();
    return back()->with($notification)->withInput();
  }
  
  public function isSort($value)
  {
    $id = Input::get('id');
    $sort_ids =  Book::find($id);
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

  public  function check(Request $request)
  {
    if($request->get('bookcode'))
    {
     $bookcode = $request->get('bookcode');
      $data = Book::
      where('bookcode','=', $bookcode)
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

  public  function checkisbn(Request $request)
  {
    if($request->get('isbn'))
    {
     $isbn = $request->get('isbn');
      $data = Book::
      where('isbn','=', $isbn)
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

  public function search()
  {
    $currentPath=Route::currentRouteName();
    return view('backend.book.search',compact('currentPath'));
  }

  public function action(Request $request)
  {
   if($request->ajax())
   {
    $output = '';
    $query = $request->get('query');
    if($query != '')
    {
     $data =  Book::where('title', 'like', '%'.$query.'%')->orWhere('bookcode', 'like', '%'.$query.'%')->orWhere('bookcode', 'like', '%' . $query . '%')->orderBy('id', 'desc')->get();
    }
    else
    {
     $data = Book::get();
    }
    $total_row = $data->count();
    if($total_row > 0)
    {
     foreach($data as $row)
     {
      $output .= '
      <tr>
       <td class="text-center">'.$row->title.'</td>
       <td class="text-center">'.$row->bookcode.'</td>
       <td class="text-center">'.$row->getBookrack->title.'</td>
      </tr>
      ';
     }
    }
    else
    {
     $output = '
     <tr>
      <td align="center" colspan="5">No Data Found</td>
     </tr>
     ';
    }
    $data = array('table_data'  => $output,'total_data'  => $total_row);
    echo json_encode($data);
   }
  }
}
