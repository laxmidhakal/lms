@extends('backend.main.app')
@section('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="content-wrapper">
  @include('backend.flash.alertmsg')
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="text-capitalize">{{$currentPath}} Page</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/home">Home</a></li>
            <li class="breadcrumb-item active text-capitalize">{{$currentPath}} Page</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="card">
      <div class="card-header">
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header bg-dark">
              <h3 class="card-title">Add Author</h3>
            </div>
            <form role="form" method="POST" action="{{URL::to('/')}}/home/bookhasauthor/store"  >
              {{ csrf_field() }}
              <div class="modal-body" >
                <div class="row">
                  <div class="form-group col-sm-12">
                    <label for="book_id">Book</label>
                    <select name="book_id" id="book_id" class="form-control js-single">
                      <option >--Select Book</option>
                      @foreach($books as $book)
                      <option value="{{$book->id}}">{{$book->title}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-12">
                    <label for="author_id">Author</label>
                    <select name="author_id[]" id="author_id" class="form-control js-multiple" multiple="multiple" style=" width:100%;">
                      @foreach($authors as $author)
                      <option value="{{$author->id}}">{{$author->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <button type="submit" class="btn bg-dark">Save</button>
              </div>
            </form>
          </div>
        </div>
        <div class="card-tools">
        </div>
      </div>
      <?php $page = substr((Route::currentRouteName()), 0, strpos((Route::currentRouteName()), ".")); ?>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead class="bg-dark">
              <tr>
                <th style="width: 10px">SN</th>
                <th>Book</th>
                <th>Author</th>
                <th style="width: 20px" class="text-center">Status</th>
                <th style="width: 10px" class="text-center">Sort</th>
                <th style="width: 95px" class="text-center">Action</th>
              </tr>
            </thead>              
            @foreach($bookhasauthors as $key=>$bookhasauthor) 
            @php
                if($bookhasauthor->is_active == '1')
               { 
                 $color="#cde0ba";
               }
               else
               {
                  
                 $color="#eccdcd";
               }
            @endphp             
            <tr  data-toggle="tooltip" data-placement="top" title="{{ $bookhasauthor->is_active == '1' ? 'This data is published':' This data is not published'}}"   style="background-color: {{$color}}">
              <td>{{$key+1}}</td>
              <td>{{$bookhasauthor->getBook->title}}</td>
              <td>
                {{$bookhasauthor->getAuthor->name}} ,
              </td>
              <td class="text-center">
                <a href="{{URL::to('/')}}/home/bookhasauthor/isactive/{{$bookhasauthor->id}}">
                  <i class="fa {{ $bookhasauthor->is_active == '1' ? 'fa-check check-css':'fa-times cross-css'}}"></i>
                </a>
              </td>
              <td>
                <p id="bookhasauthor{{$bookhasauthor->id}}" ids="{{$bookhasauthor->id}}" class="text-center sort mb-0" contenteditable="plaintext-only">{{$bookhasauthor->sort_id}}</p>
              </td>
              <td class="text-center">
               <a href="{{URL::to('/')}}/home/bookhasauthor/{{$bookhasauthor->id}}/edit"><ion-icon size="small" name="md-create"></ion-icon></a> ||<a class="button delete-confirm" href="{{URL::to('/')}}/home/bookhasauthor/{{$bookhasauthor->id}}/delete"><ion-icon size="small" name="md-trash" color="danger"></ion-icon></a> 
              </td> 
            </tr>
            @endforeach
          </table>
        </div>
      </div>
      <style type="text/css">
      </style>
      <div class="card-footer">
     </div>
   </div>
 </section>
 <!-- /.content -->
</div>
@endsection
@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
  $(".sort").keydown(function (e) {
    Pace.start();
    if (e.which == 9){
      var id = $(event.target).attr('ids'),
      token = $('meta[name="csrf-token"]').attr('content');
      value = document.getElementById('bookhasauthor'+id).innerHTML; //value of the text input
      var url= "{{URL::to('/')}}/home/sort/bookhasauthor/"+value;
      $.ajax({
        type:"POST",
        dataType:"JSON",
        url:url,
        data:{
          _token:token,
          id : id,
        },
        success:function(e){
        toastr.success('Successfully updated');
          location.reload();
        },
        error: function (e) {
         toastr.error('Sorry! this data is used some where');
          Pace.start();
        }
      });
    }
  });
</script>
<script>
  $(document).ready(function() {
      $('.js-single').select2();
  });
</script>
<script>
  $(document).ready(function() {
      $('.js-multiple').select2();
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection


