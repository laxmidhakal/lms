@extends('backend.main.app')
@section('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
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
        <a href="/home/bookuser/add">Add Bookuser</a>
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
                <th>Borrower</th>
                <th>Address</th>
                <th style="width: 10px" class="text-center">Status</th>
                <th style="width: 95px" class="text-center">Action</th>
              </tr>
            </thead>              
            @foreach($borrowers as $key=>$user)              
            <tr>
              <td>{{$key+1}}</td>
              <td>
                <a href="{{URL::to('/')}}/home/bookuser/{{$user->slug}}/detail">
                {{$user->name}}
                </a>
              </td>
              <td>{{$user->address}}</td>
              <td class="text-center">
                <a href="{{URL::to('/')}}/home/user/isactive/{{$user->id}}">
                  <i class="fa {{ $user->is_active == '1' ? 'fa-check check-css':'fa-times cross-css'}}"></i>
                </a>
              </td>
              <td class="text-center">
               <a href="{{URL::to('/')}}/home/user/{{$user->id}}/edit"><ion-icon size="small" name="md-create"></ion-icon></a> ||<a class="button delete-confirm" href="{{URL::to('/')}}/home/user/{{$user->id}}/delete"><ion-icon size="small" name="md-trash" color="danger"></ion-icon></a> 
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
<div class="modal fade" id="modal-default" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title text-capitalize">Add {{$currentPath}} </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="POST" action="{{URL::to('/')}}/home/bookuser/store"  >
        {{ csrf_field() }}
        <div class="modal-body" >
          <div class="form-group ">
            <label for="book_id">Book</label>
            <select name="book_id" id="book_id" class="form-control mdb-select md-form colorful-select dropdown-primary">
              <option >--Select Book</option>
              @foreach($books as $book)
              <option value="{{$book->id}}">{{$book->title}}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#book_id').multiselect({
      includeSelectAllOption: true,
      buttonWidth: 250,
      enableFiltering: true
    });
  });
</script>
@endsection


