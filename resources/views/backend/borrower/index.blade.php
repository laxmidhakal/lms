@extends('backend.main.app')
@section('style')
<link href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css' rel='stylesheet' type='text/css'>
<style>
  form.borrowerform label.error {
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
                <th>Address</th>
                <th>Date Issued</th>
                <th>Date Return</th>
                <th>Borrower Code</th>
                <th class="text-center">Status</th>
                <th style="width: 10px" class="text-center">Sort</th>
                <th style="width: 95px" class="text-center">Action</th>
              </tr>
            </thead> 
            @foreach($borrowers as $key=>$borrower)             
            @php
                if($borrower->is_active == '1')
               { 
                 $color="#cde0ba";
               }
               else
               {
                  
                 $color="#eccdcd";
               }
            @endphp              
            <tr data-toggle="tooltip" data-placement="top" title="{{ $borrower->is_active == '1' ? 'This data is published':' This data is not published'}}"   style="background-color: {{$color}}">
              <td>{{$key+1}}</td>
              <td>{{$borrower->name}}</td>
              <td>{{$borrower->address}}</td>
              <td>{{$borrower->date_issued}}</td>
              <td>{{$borrower->date_return}}</td>
              <td>{{$borrower->borrower_code}}</td>
              <td class="text-center">
                <a href="{{URL::to('/')}}/home/borrower/isactive/{{$borrower->id}}">
                  <i class="fa {{ $borrower->is_active == '1' ? 'fa-check check-css':'fa-times cross-css'}}"></i>
                </a>
              </td>
              <td>
                <p id="borrower{{$borrower->id}}" ids="{{$borrower->id}}" class="text-center sort mb-0" contenteditable="plaintext-only">{{$borrower->sort_id}}</p>
              </td>
              <td class="text-center">
               <a href="{{URL::to('/')}}/home/borrower/{{$borrower->id}}/edit"><ion-icon size="small" name="md-create"></ion-icon></a> ||<a class="button delete-confirm" href="{{URL::to('/')}}/home/borrower/{{$borrower->id}}/delete"><ion-icon size="small" name="md-trash" color="danger"></ion-icon></a> 
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
        <h4 class="modal-title text-capitalize">Add {{$currentPath}} </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form role="form" method="POST" action="{{URL::to('/')}}/home/borrower/store" class="borrowerform" id="signup" >
        {{ csrf_field() }}
        <div class="modal-body" >
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text"  class="form-control max" id="name" placeholder="Enter name" name="name" required="true"  autocomplete="off">
          </div>
          <div class="form-group">
            <label for="borrower_code">Borrower Code</label>
            <input type="text"  class="form-control max" id="borrower_code" placeholder="Enter borrower code" name="borrower_code" required="true"  autocomplete="off">
             <span id="error_borrower_code"></span>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text"  class="form-control max" id="address" placeholder="Enter address" name="address" required="true"  autocomplete="off">
          </div>
          <div class="form-group mb-1">
            <label for="date_issued">Date Issue</label>
          </div>
          <div class="input-group mb-3">
           <input type="text" name="date_issued" class="form-control" id="date_issued" data-provide="datepicker" autocomplete="off">
           <div class="input-group-append">
             <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
           </div>
          </div>
          <div class="form-group mb-1">
            <label for="date_return">Date Return</label>
          </div>
          <div class="input-group mb-3">
           <input type="text" name="date_return" class="form-control" id="date_return" data-provide="datepicker" autocomplete="off">
           <div class="input-group-append">
             <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
           </div>
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
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<script type="text/javascript">
  $(function() {
    $( "#date_issued" ).datepicker({ startDate: new Date()});
    $( "#date_return" ).datepicker({ startDate: new Date()});
  });
</script>
<script type="text/javascript">
  $(".sort").keydown(function (e) {
    Pace.start();
    if (e.which == 9){
      var id = $(event.target).attr('ids'),
      token = $('meta[name="csrf-token"]').attr('content');
      value = document.getElementById('borrower'+id).innerHTML; //value of the text input
      var url= "{{URL::to('/')}}/home/sort/borrower/"+value;
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
$(document).ready(function(){
 $('#borrower_code').blur(function(){
  var error_borrower_code = '';
  var borrower_code = $('#borrower_code').val();
  var _token = $('input[name="_token"]').val();
 $.ajax({
  url:"{{ route('borrower_code_available.check') }}",
  method:"POST",
  data:{borrower_code:borrower_code, _token:_token},
  success:function(result)
  {
   if(result == 'unique')
   {
    $('#error_borrower_code').html('<label class="text-success">Borrower Code is Available</label>');
    $('#borrower_code').removeClass('has-error');
    $('#submit').attr('disabled', false);
   }
   else
   {
    $('#error_borrower_code').html('<label class="text-danger">This Code is already taken</label>');
    $('#borrower_code').addClass('has-error');
    $('#submit').attr('disabled', 'disabled');
   }
  }
 })
 });
});
</script>
<script src="{{URL::to('/')}}/js/jquery.validate.js"></script>
<script>
$().ready(function() {
  $("#signup").validate({
    rules: {
      name: "required",
      address: "required",
      borrower_code: "required"
    },
    messages: {
      name: "This field is required **",
      address: "This field is required **",
      borrower_code:"This field is required **"
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

