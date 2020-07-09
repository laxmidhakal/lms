@extends('backend.main.app')
@section('style')
<link href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
<link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
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
        <h4>ADD BOOK</h4>
        <a href="{{URL::to('/')}}/home/book/create" class="brand-link">
            <img src="https://image.shutterstock.com/image-vector/open-book-vector-clipart-silhouette-260nw-358417976.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          </a>
        <div class="card-tools">
        </div>
      </div>
      <?php $page = substr((Route::currentRouteName()), 0, strpos((Route::currentRouteName()), ".")); ?>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover" id="mytable">
            <thead class="bg-dark">
              <tr>
                <th style="width: 10px">SN</th>
                <th>Title</th>
                <th>Author</th>
                <th>Publisher</th>
                <th>Bookrack</th>
                <th style="width: 105px" class="text-center">CoverImage</th>
                <th>Information</th>
                <!-- <th>Pdf Status</th> -->
                <!-- <th>Pdf</th> -->
                <th style="width: 10px" class="text-center">Status</th>
                <th>Sort</th>
                <th style="width: 105px" class="text-center">Action</th>
              </tr>
            </thead>              
            @foreach($books as $key=>$book)  
            @php
                if($book->is_active == '1')
               { 
                 $color="#cde0ba";
               }
               else
               {
                  
                 $color="#eccdcd";
               }
            @endphp            
            <tr data-toggle="tooltip" data-placement="top" title="{{ $book->is_active == '1' ? 'This data is published':' This data is not published'}}"   style="background-color: {{$color}}">
              <td>{{$key+1}}</td>
              <td>{{$book->title}}</td>
              <td>
                @foreach($book->getBookHasAuthor()->get() as $author)
                {{$author->getAuthor->name}} ,
                @endforeach
              </td>
              <td>{{$book->getPublisher->name}}</td>
              <td>{{$book->getBookrack->title}}</td>
              <td class="text-center">
                <a href="{{URL::to('/')}}/images/coverimage/{{$book->image_enc}}" data-toggle="lightbox" data-title="Image">
                  @if($book->image_enc != "")
                  <img src="{{URL::to('/')}}/images/coverimage/{{$book->image_enc}}" style="height: 30px;" class="img-thumbnail img-fluid back-img center-block">
                  @else
                  <img src="https://image.shutterstock.com/image-vector/open-book-vector-clipart-silhouette-260nw-358417976.jpg" style="height: 30px;" class="img-thumbnail img-fluid back-img">
                  @endif
                </a>
              </td>
              <td>{{$book->information}}</td>
              <!-- <td class="text-center">
                <a href="{{URL::to('/')}}/home/book/ispdf/{{$book->id}}">
                  <i class="fa {{ $book->is_pdf == '1' ? 'fa-check check-css':'fa-times cross-css'}}"></i>
                </a>
              </td> -->
              <!-- <td>
              @if($book->is_active == 1)
                <a href="{{URL::to('/')}}/images/pdf/{{$book->pdf_enc}}" target="_blank">
                  <img alt="Qries" src="{{URL::to('/')}}/images/pdf.jpg"
                  height="35">
                </a>
              @else
              <a class="disabled">
                <img src="{{URL::to('/')}}/images/pdfdisable.jpg" height="35">
              </a>
              @endif
              </td> -->
              <td class="text-center">
                <a href="{{URL::to('/')}}/home/book/isactive/{{$book->id}}">
                  <i class="fa {{ $book->is_active == '1' ? 'fa-check check-css':'fa-times cross-css'}}"></i>
                </a>
              </td>
              <td>
                <p id="book{{$book->id}}" ids="{{$book->id}}" class="text-center sort mb-0" contenteditable="plaintext-only">{{$book->sort_id}}</p>
              </td>
              <td class="text-center"><a href="{{URL::to('/')}}/home/pdf/{{$book->slug}}">
                  <ion-icon size="small" name="md-add" ></ion-icon>
                </a>||
               <a href="{{URL::to('/')}}/home/book/{{$book->id}}/edit"><ion-icon size="small" name="md-create"></ion-icon></a> ||<a class="button delete-confirm" href="{{URL::to('/')}}/home/book/{{$book->id}}/delete"><ion-icon size="small" name="md-trash" color="danger"></ion-icon></a> 
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
<script type="text/javascript">
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#profile-img-tag').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#image").change(function(){
    readURL(this);
  });
</script>
<script type="text/javascript">
 $(document).on('click', '[data-toggle="lightbox"]', function(event) {
   event.preventDefault();
   $(this).ekkoLightbox();
 });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js"></script>
<script type="text/javascript">
  $(".sort").keydown(function (e) {
    Pace.start();
    if (e.which == 9){
      var id = $(event.target).attr('ids'),
      token = $('meta[name="csrf-token"]').attr('content');
      value = document.getElementById('book'+id).innerHTML; //value of the text input
      var url= "{{URL::to('/')}}/home/sort/book/"+value;
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
 <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
 <script>
  $(document).ready( function () {
    $('#mytable').DataTable();
  } );
</script>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection

