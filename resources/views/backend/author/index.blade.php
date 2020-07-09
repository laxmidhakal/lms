@extends('backend.main.app')
@section('style')
<style>
  form.authorform label.error {
    color: #dc3545;
    font-weight: normal;
  }
</style>
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
        <button class="btn btn-sm btn-info text-capitalize" data-toggle="modal" data-target="#modal-default">Add {{$currentPath}}</button>
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
                <th>Name</th>
                <th style="width: 10px" class="text-center">Books</th>
                <th>Address</th>
                <th style="width: 10px" class="text-center">Status</th>
                <th style="width: 10px" class="text-center">Sort</th>
                <th style="width: 95px" class="text-center">Action</th>
              </tr>
            </thead>              
            @foreach($authors as $key=>$author)   
            @php
                if($author->is_active == '1')
               { 
                 $color="#cde0ba";
               }
               else
               {
                  
                 $color="#eccdcd";
               }
            @endphp            
            <tr data-toggle="tooltip" data-placement="top" title="{{ $author->is_active == '1' ? 'This data is published':' This data is not published'}}"   style="background-color: {{$color}}">
              <td>{{$key+1}}</td>
              <td>{{$author->name}}</td>
              <td>{{$author->getBookAuthor()->count()}}</td>
              <td>{{$author->address}}</td>
              <td class="text-center">
                <a href="{{URL::to('/')}}/home/author/isactive/{{$author->id}}">
                  <i class="fa {{ $author->is_active == '1' ? 'fa-check check-css':'fa-times cross-css'}}"></i>
                </a>
              </td>
              <td>
                <p id="author{{$author->id}}" ids="{{$author->id}}" class="text-center sort mb-0" contenteditable="plaintext-only">{{$author->sort_id}}</p>
              </td>
              <td class="text-center">
               <a href="{{URL::to('/')}}/home/author/{{$author->id}}/edit"><ion-icon size="small" name="md-create"></ion-icon></a> ||<a class="button delete-confirm" href="{{URL::to('/')}}/home/author/{{$author->id}}/delete"><ion-icon size="small" name="md-trash" color="danger"></ion-icon></a> 
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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title text-capitalize">Add {{$currentPath}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="POST" action="{{URL::to('/')}}/home/author/store" class="authorform" id="signup">
        {{ csrf_field() }}
        <div class="modal-body" >
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text"  class="form-control max" id="name" placeholder="Enter name" name="name" required="true"  autocomplete="off">
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text"  class="form-control max" id="address" placeholder="Enter address" name="address" required="true"  autocomplete="off">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn bg-info text-capitalize">Save {{$currentPath}}</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript" src="{{URL::to('/')}}/backend/js/bootstrap-maxlength.min.js"></script>
<script type="text/javascript">
  $(".sort").keydown(function (e) {
    Pace.start();
    if (e.which == 9){
      var id = $(event.target).attr('ids'),
      token = $('meta[name="csrf-token"]').attr('content');
      value = document.getElementById('author'+id).innerHTML; //value of the text input
      var url= "{{URL::to('/')}}/home/sort/author/"+value;
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
<script src="{{URL::to('/')}}/js/jquery.validate.js"></script>
<script>
$().ready(function() {
  // validate signup form on keyup and submit
  $("#signup").validate({
    rules: {
      name: "required",
      address:"required"
    },
    messages: {
      name: "This Field is Required **",
      address: "This Field is Required **"
    }
  });
});
</script>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection

