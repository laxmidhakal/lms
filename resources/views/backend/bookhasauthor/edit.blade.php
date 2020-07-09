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
      <?php $page = substr((Route::currentRouteName()), 0, strpos((Route::currentRouteName()), ".")); ?>
      <div class="card-body">
        @foreach($bookauthors as $bookauthor)
        <form role="form" method="POST" action="{{URL::to('/')}}/home/bookhasauthor/{{$bookauthor->id}}/update">
          {{ csrf_field() }}
          <div class="modal-body" >
            <div class="form-group ">
              <label for="book_id">Book ({{ $bookauthor->getBook->title }})</label>
              <select name="book_id" id="book_id" class="form-control js-single">
                <option  value="{{ $bookauthor->book_id }}" >--Select Book </option>
                @foreach($books as $book)
                <option value="{{$book->id}}">{{$book->title}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group ">
              <label for="author_id">Author ({{ $bookauthor->getAuthor->name }})</label>
              <select name="author_id" id="author_id" class="form-control js-single" >
                @foreach($authors as $author)
                <option value="{{$author->id}}">{{$author->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
        @endforeach
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
      $('.js-single').select2();
  });
</script>
<!-- <script type="text/javascript">
  $(document).ready(function() {
    $('#author_id').multiselect({
      includeSelectAllOption: true,
      buttonWidth: 250,
      enableFiltering: true
    });
  });
</script> -->

@endsection





