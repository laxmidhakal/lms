@extends('backend.main.app')
@section('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
  <style>
    form.pdfform label.error {
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
        <div class="col-md-12">
          <div class="card card-primary">
            <div class="card-header bg-dark">
              <h3 class="card-title">Do you have any Pdf??</h3>
            </div>
            <form role="form" method="POST" action="{{URL::to('/')}}/home/pdf/store" enctype="multipart/form-data" class="pdfform" id="signup">
              {{ csrf_field() }}
              <input type="hidden" name="book_id" value="{{$book_id}}">
              <div class="modal-body" >
                <div class="form-group ">
                  <label for="title">Title</label>
                  <input type="text" class="form-control" id="title" placeholder="Enter title" name="title" autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="pdf">Choose pdf</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="pdf" name="pdf">
                      <label class="custom-file-label" for="pdf">Choose pdf</label>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn bg-dark">Save Pdf</button>
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
                <th style="width: 10px" >SN</th>
                <th>Title</th>
                <th style="width: 20px" class="text-center">Pdf</th>
                <th style="width: 20px" class="text-center">Status</th>
                <th style="width: 10px" class="text-center">Sort</th>
                <th style="width: 95px" class="text-center">Action</th>
              </tr>
            </thead>
            @foreach($pdfs as $key=>$pdf)
            @php
                if($pdf->is_active == '1')
               { 
                 $color="#cde0ba";
               }
               else
               {
                  
                 $color="#eccdcd";
               }
            @endphp
            <tr data-toggle="tooltip" data-placement="top" title="{{ $pdf->is_active == '1' ? 'This data is published':' This data is not published'}}"   style="background-color: {{$color}}">
              <td>{{$key+1}}</td>
              <td>{{$pdf->title}} </td>
              <td>
              @if($pdf->is_active == 1)
                @if($pdf->pdf_enc != "")
                <a href="{{URL::to('/')}}/images/pdf/{{$pdf->pdf_enc}}" target="_blank">
                  <img alt="Qries" src="{{URL::to('/')}}/images/pdf.jpg"
                  height="35">
                </a>
                @else
                <a class="disabled">
                  <img alt="Qries" src="{{URL::to('/')}}/images/pdfdisable.jpg"
                  height="35">
                </a>
                @endif
              @else
              <a class="disabled">
                <img src="{{URL::to('/')}}/images/pdfdisable.jpg" height="35">
              </a>
              @endif
              </td>
              <td class="text-center">
                <a href="{{URL::to('/')}}/home/pdf/isactive/{{$pdf->id}}">
                  <i class="fa {{ $pdf->is_active == '1' ? 'fa-check check-css':'fa-times cross-css'}}"></i>
                </a>
              </td>
              <td>
                <p id="pdf{{$pdf->id}}" ids="{{$pdf->id}}" class="text-center sort mb-0" contenteditable="plaintext-only">{{$pdf->sort_id}}</p>
              </td>
              <td class="text-center">
               <a href="{{URL::to('/')}}/home/pdf/{{$pdf->id}}/edit"><ion-icon size="small" name="md-create"></ion-icon></a> ||<a class="button delete-confirm" href="{{URL::to('/')}}/home/pdf/{{$pdf->id}}/delete"><ion-icon size="small" name="md-trash" color="danger"></ion-icon></a> 
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
      value = document.getElementById('pdf'+id).innerHTML; //value of the text input
      var url= "{{URL::to('/')}}/home/sort/pdf/"+value;
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
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection


