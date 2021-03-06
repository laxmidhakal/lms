@extends('backend.main.app')
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
        @foreach($authors as $author)
        <form role="form" method="POST" action="{{URL::to('/')}}/home/author/{{$author->id}}/update" >
          {{ csrf_field() }}
          <div class="modal-body" >
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text"  class="form-control max" id="name" placeholder="Enter name" name="name" required="true"  autocomplete="off"  value="{{ $author->name }}">
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text"  class="form-control max" id="address" placeholder="Enter address" name="address" required="true"  autocomplete="off"  value="{{ $author->address }}">
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


