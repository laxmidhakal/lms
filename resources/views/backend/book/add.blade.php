@extends('backend.main.app')
@section('style')
<link href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style type="text/css">
 .box{
  width:600px;
  margin:0 auto;
  border:1px solid #ccc;
 }
 .has-error
 {
  border-color:#cc0000;
  background-color:#ffff99;
 }
 form.addform label.error {
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
      <div class="card-header text-center">
        <h1>DOI-Library</h1>
        <h7><b>Jawalakhel,Lalitpur</b></h7>
        <h3><b>Library Form </b></h3>
        <h4 class="pb-1"><b>for</b></h4>
        <h5>National Union  Catalogue on Nepal Publications</h5>
        <div class="card-tools">
        </div>
      </div>
      <?php $page = substr((Route::currentRouteName()), 0, strpos((Route::currentRouteName()), ".")); ?>
      <div class="card-body">
        <form role="form" method="POST" action="{{URL::to('/')}}/home/book/add/store" enctype="multipart/form-data" class="addform" id="signup" >
          {{ csrf_field() }}
          <div class="modal-body" >
            <div class="row">
              <div class="form-group col-sm-6">
                <label for="worksheet">Worksheet:</label>
                <input type="text"  class="form-control max" id="worksheet" placeholder="Enter worksheet" name="worksheet"   autocomplete="off">
              </div>
              <div class="form-group col-sm-6">
                <label for="language">Language(31):</label>
                <input type="text"  class="form-control max" id="language" placeholder="Enter language" name="language"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="bookcode">Call No.(610):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="bookcode" placeholder="Enter call no" name="bookcode" required="true"  autocomplete="off">
                <span id="error_bookcode"></span>
              </div>
              <div class="form-group col-sm-12">
                <label for="corporate_body">Corporate Body(310):</label>
                <input type="text"  class="form-control max" id="corporate_body" placeholder="Enter corporate_body" name="corporate_body"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="title">Title(200):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="title" placeholder="Enter title" name="title" required="true"  autocomplete="off">
                <span id="error_title"></span>

              </div>
              <div class="form-group col-sm-6">
                <label for="edition">Edition(260):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="edition" placeholder="Enter edition" name="edition" required="true"  autocomplete="off">
              </div>
              <div class="form-group col-sm-6">
                <label for="place">place(400)^a:</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="place" placeholder="Enter place" name="place" required="true"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="publisher_id">Publisher:^b</label>
                <small class="text-danger mr-4">*required</small>
                <select name="publisher_id" id="publisher_id" class="form-control">
                  <option >--Selectpublisher</option>
                  @foreach($publishers as $publisher)
                  <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-sm-12">
                <label for="author_id">Author:</label>
                <small class="text-danger mr-4">*required</small>
                <select name="author_id[]" id="author_id" class="js-example-basic-multiple" multiple="multiple" style=" width:100%;">
                  @foreach($authors as $author)
                  <option value="{{$author->id}}">{{$author->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-sm-12">
                <label for="year_of_publication">Year of Publication(440):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="year_of_publication" placeholder="Enter year of publication" name="year_of_publication" required="true"  autocomplete="off">
              </div>
              <div class="form-group col-sm-6">
                <label for="physical_description">Physical description(460):^a</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="physical_description_a" placeholder="Enter physical description^a" name="physical_description_a" required="true"  autocomplete="off">
              </div>
              <div class="form-group col-sm-6">
                <label for="physical_description_b">^b</label>
                <input type="text"  class="form-control max" id="physical_description_b" placeholder="Enter physical description^b" name="physical_description_b"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="series_statement">Series Statement(480):</label>
                <input type="text"  class="form-control max" id="series_statement" placeholder="Enter series statement" name="series_statement"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="note">Note(500):</label>
                <input type="text"  class="form-control max" id="note" placeholder="Enter note" name="note"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="broad_subject_heading">Broad Subject Heading(30):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="broad_subject_heading" placeholder="Enter broad subject heading" name="broad_subject_heading" required="true"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="keywords">Keywords(620):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="keywords" placeholder="Enter keywords" name="keywords" required="true"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="geographical_descriptors">Geographical Descriptors(630):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="geographical_descriptors" placeholder="Enter geographical descriptors" name="geographical_descriptors" required="true"  autocomplete="off">
              </div>
              <div class="form-group col-sm-6">
                <label for="isbn">ISBN(100):</label>
                <input type="text"  class="form-control max" id="isbn" placeholder="Enter isbn" name="isbn"  autocomplete="off">
                <span id="error_isbn"></span>

              </div>
              <div class="form-group col-sm-6">
                <label for="issn">ISSN(101):</label>
                <input type="text"  class="form-control max" id="issn" placeholder="Enter issn" name="issn"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="bookrack_id">Location(Holding Library)</label>
                <select name="bookrack_id" id="bookrack_id" class="form-control">
                  <option >--Select Holding Library</option>
                  @foreach($bookracks as $bookrack)
                  <option value="{{$bookrack->id}}">{{$bookrack->title}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-sm-6">
                <label for="country">Country of Origin:</label>
                <input type="text"  class="form-control max" id="country" placeholder="Enter country of origin" name="country"  autocomplete="off">
              </div>
              <div class="form-group col-sm-6">
                <label for="language_of_text">Language of Text:</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="language_of_text" placeholder="Enter language of text" name="language_of_text" required="true"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="meeting">Conference/Meeting(320):</label>
                <input type="text"  class="form-control max" id="meeting" placeholder="Enter meeting" name="meeting"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="national_union_catologue_no">National Union Catologue No.(110):</label>
                <input type="text"  class="form-control max" id="national_union_catologue_no" placeholder="Enter national union catologue no" name="national_union_catologue_no"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="copyright_no">Copyright No:</label>
                <input type="text"  class="form-control max" id="copyright_no" placeholder="Enter copyright no" name="copyright_no"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="type_of_material">Type of Material(060):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="type_of_material" placeholder="Enter type of material" name="type_of_material" required="true"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="accession_no">Accession No:(1)</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="accession_no" placeholder="Enter accession no" name="accession_no" required="true"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="information">Information</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="information" placeholder="Enter information" name="information" required="true"  autocomplete="off">
              </div>
              <div class="form-group col-sm-6">
                <label for="image">Choose CoverImage</label>
                <div class="input-group">
                  <input type="file" class="form-control d-none" id="image" name="image" >
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQl1xtOkMGh312RKiJXUPbwyODQ7hdHgHFqYR5RwBGHiKaKz9eO&s" id="profile-img-tag" width="200px" onclick="document.getElementById('image').click();" alt="your image" class="img-thumbnail img-fluid editback-gallery-img center-block"  />
                </div>
              </div>
              <div class="form-group col-sm-6">
                <label for="pdf">Choose PDF</label>
                <div class="input-group">
                  <input type="file" class="form-control d-none" id="pdf" name="pdf" >
                  <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQl1xtOkMGh312RKiJXUPbwyODQ7hdHgHFqYR5RwBGHiKaKz9eO&s" id="profile-img-tag" width="200px" onclick="document.getElementById('pdf').click();" alt="your pdf" class="img-thumbnail img-fluid editback-gallery-img center-block"  />
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
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
      
    </div>
  </div>
</div>
@endsection
@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#aid').multiselect({
      includeSelectAllOption: true,
      buttonWidth: 1011,
      enableFiltering: true
    });
  });
</script>
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
<script>
$(document).ready(function(){
 $('#bookcode').blur(function(){
  var error_bookcode = '';
  var bookcode = $('#bookcode').val();
  var _token = $('input[name="_token"]').val();
 $.ajax({
  url:"{{ route('bookcode_available.check') }}",
  method:"POST",
  data:{bookcode:bookcode, _token:_token},
  success:function(result)
  {
   if(result == 'unique')
   {
    $('#error_bookcode').html('<label class="text-success">Bookcode is Available</label>');
    $('#bookcode').removeClass('has-error');
    $('#submit').attr('disabled', false);
   }
   else
   {
    $('#error_bookcode').html('<label class="text-danger">Bookcode is not Available</label>');
    $('#bookcode').addClass('has-error');
    $('#submit').attr('disabled', 'disabled');
   }
  }
 })
 });
});
</script>
<script type="text/javascript">
  $("#isbn").keydown(function (e) {
    Pace.start();
    if (e.which == 9){
      var error_isbn = '';
      var isbn = $('#isbn').val();
      var _token = $('input[name="_token"]').val();
     
      $.ajax({
       url:"{{ route('isbn_available.check') }}",
       method:"POST",
       data:{isbn:isbn, _token:_token},
       success:function(result)
       {
        if(result == 'unique')
        {
         $('#error_isbn').html('<label class="text-success">isbn is Available</label>');
         $('#isbn').removeClass('has-error');
         $('#submit').attr('disabled', false);
        }
        else
        {
         $('#error_isbn').html('<label class="text-danger"> this isbn is already taken</label>');
         $('#isbn').addClass('has-error');
         $('#submit').attr('disabled', 'disabled');
        }
       }
      })
    
    }
  });
</script>
<script>
  $(document).ready(function() {
      $('.js-example-basic-multiple').select2();
  });
</script>
<script src="{{URL::to('/')}}/js/jquery.validate.js"></script>
<script>
$().ready(function() {
  $("#signup").validate({
    rules: {
      bookcode: "required",
      title:"required",
      edition:"required",
      place:"required",
      publisher_id:"required",
      year_of_publication:"required",
      physical_description:"required",
      broad_subject_heading:"required",
      keywords:"required",
      geographical_descriptors:"required",
      bookrack_id:"required",
      language_of_text:"required",
      type_of_material:"required",
      accession_no:"required",
      information:"required"
    },
    messages: {
      bookcode: "This Field is Required **",
      title: "This Field is Required **",
      edition: "This Field is Required **",
      place: "This Field is Required **",
      publisher_id: "This Field is Required **",
      year_of_publication: "This Field is Required **",
      physical_description: "This Field is Required **",
      broad_subject_heading: "This Field is Required **",
      keywords: "This Field is Required **",
      geographical_descriptors: "This Field is Required **",
      bookrack_id: "This Field is Required **",
      language_of_text: "This Field is Required **",
      type_of_material: "This Field is Required **",
      accession_no: "This Field is Required **",
      information: "This Field is Required **"
    }
  });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
@endsection

