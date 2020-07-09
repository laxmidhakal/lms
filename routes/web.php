<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('frontend.main.home');
});

Auth::routes();
Route::get('/changepassword','HomeController@showChangePasswordForm');
Route::post('/changepassword','HomeController@changePassword')->name('changePassword');

Route::get('/home', 'HomeController@index')->name('backend.main.home');
Route::get('/home/category', 'Backend\CategoryController@index')->name('category');
Route::post('/home/category/store', 'Backend\CategoryController@store')->name('category-store');
Route::get('/home/category/isactive/{id}', 'Backend\CategoryController@isactive')->name('category-active');
Route::post('/home/sort/category/{value}', 'Backend\CategoryController@isSort');
Route::get('/home/category/{id}/edit', 'Backend\CategoryController@edit')->name('category-edit');
Route::post('/home/category/{id}/update', 'Backend\CategoryController@update')->name('category-update');
Route::get('/home/category/{id}/delete', 'Backend\CategoryController@destroy')->name('item-delete');

Route::get('/home/author', 'Backend\AuthorController@index')->name('author');
Route::post('/home/author/store', 'Backend\AuthorController@store')->name('author-store');
Route::get('/home/author/isactive/{id}', 'Backend\AuthorController@isactive')->name('author-active');
Route::post('/home/sort/author/{value}', 'Backend\AuthorController@isSort');
Route::get('/home/author/{id}/delete', 'Backend\AuthorController@destroy')->name('author-delete');
Route::get('/home/author/{id}/edit', 'Backend\AuthorController@edit')->name('author-edit');
Route::post('/home/author/{id}/update', 'Backend\AuthorController@update')->name('author-update');

Route::get('/home/publisher', 'Backend\PublisherController@index')->name('publisher');
Route::post('/home/publisher/store', 'Backend\PublisherController@store')->name('publisher-store');
Route::get('/home/publisher/isactive/{id}', 'Backend\PublisherController@isactive')->name('publisher-active');
Route::post('/home/sort/publisher/{value}', 'Backend\PublisherController@isSort');
Route::get('/home/publisher/{slug}/detail', 'Backend\PublisherController@detail')->name('publisher-detail');
Route::get('/home/publisher/{id}/delete', 'Backend\PublisherController@destroy')->name('publisher-delete');
Route::get('/home/publisher/{id}/edit', 'Backend\PublisherController@edit')->name('publisher-edit');
Route::post('/home/publisher/{id}/update', 'Backend\PublisherController@update')->name('publisher-update');
Route::post('/home/sort/publisher/{value}', 'Backend\PublisherController@isSort');

Route::get('/home/supplier', 'Backend\SupplierController@index')->name('supplier');
Route::post('/home/supplier/store', 'Backend\SupplierController@store')->name('supplier-store');
Route::get('/home/supplier/isactive/{id}', 'Backend\SupplierController@isactive')->name('supplier-active');
Route::get('/home/supplier/{id}/delete', 'Backend\SupplierController@destroy')->name('supplier-delete');
Route::get('/home/supplier/{id}/edit', 'Backend\SupplierController@edit')->name('supplier-edit');
Route::post('/home/supplier/{id}/update', 'Backend\SupplierController@update')->name('supplier-update');
Route::post('/home/sort/supplier/{value}', 'Backend\SupplierController@isSort');

Route::get('/home/bookrack', 'Backend\BookrackController@index')->name('bookrack');
Route::post('/home/bookrack/store', 'Backend\BookrackController@store')->name('bookrack-store');
Route::get('/home/bookrack/isactive/{id}', 'Backend\BookrackController@isactive')->name('bookrack-active');
Route::get('/home/bookrack/{slug}/detail', 'Backend\BookrackController@detail')->name('bookrack-detail');
Route::get('/home/bookrack/{id}/delete', 'Backend\BookrackController@destroy')->name('bookrack-delete');
Route::get('/home/bookrack/{id}/edit', 'Backend\BookrackController@edit')->name('bookrack-edit');
Route::post('/home/bookrack/{id}/update', 'Backend\BookrackController@update')->name('bookrack-update');
Route::post('/home/sort/bookrack/{value}', 'Backend\BookrackController@isSort');

Route::get('/home/borrower', 'Backend\BorrowerController@index')->name('borrower');
Route::post('/home/borrower/store', 'Backend\BorrowerController@store')->name('borrower-store');
Route::get('/home/borrower/isactive/{id}', 'Backend\BorrowerController@isactive')->name('borrower-active');
Route::get('/home/borrower/{id}/edit', 'Backend\BorrowerController@edit')->name('borrower-edit');
Route::post('/home/borrower/{id}/update', 'Backend\BorrowerController@update')->name('borrower-update');
Route::get('/home/borrower/{id}/delete', 'Backend\BorrowerController@destroy')->name('borrower-delete');
Route::post('/home/sort/borrower/{value}', 'Backend\BorrowerController@isSort');
Route::post('/home/borrower/check', 'Backend\BorrowerController@check')->name('borrower_code_available.check');

Route::get('/home/book', 'Backend\BookController@index')->name('book');
Route::get('/home/book/create', 'Backend\BookController@create')->name('book-create');
Route::post('/home/book/create/store', 'Backend\BookController@store')->name('book-store');
Route::post('/home/book/check', 'Backend\BookController@check')->name('bookcode_available.check');
Route::get('/home/book/{id}/edit', 'Backend\BookController@edit')->name('book-edit');
Route::post('/home/book/{id}/update', 'Backend\BookController@update')->name('book-update');
Route::get('/home/book/{id}/delete', 'Backend\BookController@destroy')->name('book-delete');
Route::get('/home/book/isactive/{id}', 'Backend\BookController@isactive')->name('book-active');
Route::get('/home/book/ispdf/{id}', 'Backend\BookController@ispdf')->name('book-pdf');
Route::post('/home/sort/book/{value}', 'Backend\BookController@isSort');
Route::post('/home/book/checkisbn', 'Backend\BookController@checkisbn')->name('isbn_available.check');

Route::get('/home/book/search', 'Backend\BookController@search');
Route::get('/live_search/action', 'Backend\BookController@action')->name('live_search.action');

Route::get('/home/pdf/{slug}', 'Backend\PdfController@index')->name('bookpdf');
Route::post('/home/pdf/store', 'Backend\PdfController@store')->name('bookpdf-store');
Route::get('/home/pdf/isactive/{id}', 'Backend\PdfController@isactive')->name('pdf-active');
Route::post('/home/sort/pdf/{value}', 'Backend\PdfController@isSort');
Route::get('/home/pdf/{id}/delete', 'Backend\PdfController@destroy')->name('pdf-delete');
Route::get('/home/pdf/{id}/edit', 'Backend\PdfController@edit')->name('pdf-edit');
Route::post('/home/pdf/{id}/update', 'Backend\PdfController@update')->name('pdf-update');

Route::get('/home/bookhasauthor', 'Backend\BookAuthorController@index')->name('bookauthor');
Route::post('/home/bookhasauthor/store', 'Backend\BookAuthorController@store')->name('bookauthor-store');
Route::get('/home/bookhasauthor/isactive/{id}', 'Backend\BookAuthorController@isactive')->name('bookauthor-active');
Route::get('/home/bookhasauthor/{id}/delete', 'Backend\BookAuthorController@destroy')->name('bookauthor-delete');
Route::get('/home/bookhasauthor/{id}/edit', 'Backend\BookAuthorController@edit')->name('bookauthor-edit');
Route::post('/home/bookhasauthor/{id}/update', 'Backend\BookAuthorController@update')->name('bookauthor-update');
Route::post('/home/sort/bookhasauthor/{value}', 'Backend\BookAuthorController@isSort');

Route::get('/home/bookuser', 'Backend\BookuserController@index')->name('bookuser');
Route::get('/home/bookuser/add', 'Backend\BookuserController@add')->name('bookuser-add');
Route::post('/home/bookuser/store', 'Backend\BookuserController@store')->name('bookuser-store');
Route::get('/home/bookuser/{slug}/detail', 'Backend\BookuserController@detail')->name('bookuser-detail');
Route::post('/home/bookuser/add/detail', 'Backend\BookuserController@getBorrowerDetail')->name('userdetail');










