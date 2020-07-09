@extends('backend.main.app')
@section('style')
<style>
  form.categoryform label.error {
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
        <div class="col-sm-6 pl-1">
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
          <table class="table table-bordered table-hover">
            <thead class="bg-dark">
              <tr>
                <th style="width: 10px">SN</th>
                <th>Title</th>
                <th style="width: 10px" class="text-center">Status</th>
                <th style="width: 10px" class="text-center">Sort</th>
                <th style="width: 95px" class="text-center">Action</th>
              </tr>
            </thead>              
            @foreach($categories as $key=>$category)             
            @php
                if($category->is_active == '1')
               { 
                 $color="#cde0ba";
               }
               else
               {
                 $color="#eccdcd";
               }
            @endphp 
            <tr data-toggle="tooltip" data-placement="top" title="{{ $category->is_active == '1' ? 'This data is published':' This data is not published'}}"   style="background-color: {{$color}}">
              <td>{{$key+1}}</td>
              <td>{{$category->title}}</td>
              <td class="text-center">
                <a href="{{URL::to('/')}}/home/category/isactive/{{$category->id}}">
                  <i class="fa {{ $category->is_active == '1' ? 'fa-check check-css':'fa-times cross-css'}}"></i>
                </a>
              </td>
              <td>
              <p id="category{{$category->id}}" ids="{{$category->id}}" class="text-center sort mb-0" contenteditable="plaintext-only">{{$category->sort_id}}</p>
              </td>
              <td class="text-center">
               <a href="{{URL::to('/')}}/home/category/{{$category->id}}/edit"><ion-icon size="small" name="md-create"></ion-icon></a> ||<a class="button delete-confirm" href="{{URL::to('/')}}/home/category/{{$category->id}}/delete"><ion-icon size="small" name="md-trash" color="danger"></ion-icon></a> 
              </td> 
            </tr>
            @endforeach
          </table>
        </div>
      </div>
      <div class="card-footer">
      {!! $categories->links("pagination::bootstrap-4") !!}            
     </div>
   </div>
 </section>
 <!-- /.content -->
</div>
<div class="modal fade" id="modal-default" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog"  role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title text-capitalize">Add {{$currentPath}}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="POST" action="{{URL::to('/')}}/home/category/store" class="categoryform" id="signup">
        {{ csrf_field() }}
        <div class="modal-body" >
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text"  class="form-control max" id="title" placeholder="Enter title" name="title" required="true"  autocomplete="off">
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-info text-capitalize">Save {{$currentPath}}</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script type="text/javascript">
  $(".sort").keydown(function (e) {
    Pace.start();
    if (e.which == 9){
      var id = $(event.target).attr('ids'),
      token = $('meta[name="csrf-token"]').attr('content');
      value = document.getElementById('category'+id).innerHTML; //value of the text input
      var url= "{{URL::to('/')}}/home/sort/category/"+value;
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
  $("#signup").validate({
    rules: {
      title: "required"
    },
    messages: {
      title: "Title field is required **"
    },
    highlight: function(element) {
     $(element).css('background', '#ffdddd');
     $(element).css('border-color', 'red');
    },
    unhighlight: function(element) {
     $(element).css('background', '#ffffff');
     $(element).css('border-color', '#ced4da');
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



