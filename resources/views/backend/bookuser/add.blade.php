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
          <h1 class="text-capitalize">Page</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{URL::to('/')}}/home">Home</a></li>
            <li class="breadcrumb-item active text-capitalize">Page</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="card">
      <div class="card-header">
        ADD
        <div class="card-tools">
          
        </div>
      </div>
      <?php $page = substr((Route::currentRouteName()), 0, strpos((Route::currentRouteName()), ".")); ?>
      <div class="card-body">
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
            <div class="form-group ">
              <label for="borrow_id">Boorower</label>
              <select name="borrow_id" id="borrow_id" class="form-control mdb-select md-form colorful-select dropdown-primary">
                <option >--Select Boorower</option>
                @foreach($borrowers as $borrow)
                <option value="{{$borrow->id}}">{{$borrow->name}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
        Add {{$currentPath}}ress:<img id="loaderDiv" src="https://cdn3.iconfinder.com/data/icons/interaction-design/512/Loading_C-512.png" style="display:none; width: 35px; height: 35px;"/>
       <input type="text" name="item_p" class="form-control" id="item_p">
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
  $(document).ready(function() {
    $('#book').multiselect({
      includeSelectAllOption: true,
      enableFiltering: true
    });
  });
</script>
<script>
  $(document).ready(function() {
  $('.mdb-select').materialSelect();
  });
</script>
<script type="text/javascript">
  $(document).on('change', '#borrow_id', function(event) {
    var borrow_id =$('#borrow_id').val();
    $.ajax({
      type:'POST',
      url:"{{URL::to('/')}}/home/bookuser/add/detail", //Make sure your URL is correct
      dataType: 'json', //Make sure your returning data type dffine as json
      data: {
        "_token": "{{ csrf_token() }}",
        borrow_id: borrow_id,
      },
      beforeSend: function() {
        $("#loaderDiv").show();
      },
      success:function(data){
        $("#item_p").val(data[0].address);
        $("#loaderDiv").hide();
      },
      error:function(data){
        alert('error showing history of custmer');
      }
    });
  });
</script>
@endsection


