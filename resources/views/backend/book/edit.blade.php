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
        @foreach($books as $book)
        <form role="form" method="POST" action="{{URL::to('/')}}/home/book/{{$book->id}}/update" enctype="multipart/form-data" >
          {{ csrf_field() }}
          <div class="modal-body" >
            <div class="row">
              <div class="form-group col-sm-6">
                <label for="worksheet">Worksheet:</label>
                <input type="text"  class="form-control max" id="worksheet" placeholder="Enter worksheet" name="worksheet"   autocomplete="off" value="{{ $book->worksheet }}" >
              </div>
              <div class="form-group col-sm-6">
                <label for="language">Language(31):</label>
                <input type="text"  class="form-control max" id="language" placeholder="Enter language" name="language"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="bookcode">Call No.(610):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="bookcode" placeholder="Enter call no" name="bookcode" required="true"  autocomplete="off" value="{{ $book->bookcode }}">
                <span id="error_bookcode"></span>
              </div>
              <div class="form-group col-sm-12">
                <label for="corporate_body">Corporate Body(310):</label>
                <input type="text"  class="form-control max" id="corporate_body" placeholder="Enter corporate_body" name="corporate_body"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="title">Title(200):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="title" placeholder="Enter title" name="title" required="true"  autocomplete="off" value="{{ $book->title }}">
              </div>
              <div class="form-group col-sm-6">
                <label for="edition">Edition(260):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="edition" placeholder="Enter edition" name="edition" required="true"  autocomplete="off" value="{{ $book->edition }}">
              </div>
              <div class="form-group col-sm-6">
                <label for="place">place(400)^a:</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="place" placeholder="Enter place" name="place" required="true"  autocomplete="off" value="{{ $book->place }}">
              </div>
              <div class="form-group col-sm-12">
                <label for="publisher_id">Publisher:^b</label>
                <small class="text-danger mr-4">*required value="{{$book->getPublisher->name}}"</small>
                <select name="publisher_id" id="publisher_id" class="form-control">
                  <option  value="{{ $book->publisher_id }}" >--Selectpublisher</option>
                  @foreach($publishers as $publisher)
                  <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-sm-12">
                <label for="year_of_publication">Year of Publication(440):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="year_of_publication" placeholder="Enter year of publication" name="year_of_publication" required="true"  autocomplete="off" value="{{ $book->year_of_publication }}">
              </div>
              <div class="form-group col-sm-6">
                <label for="physical_description">Physical description(460):^a</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="physical_description_a" placeholder="Enter physical description^a" name="physical_description_a" required="true"  autocomplete="off" value="{{ $book->physical_description_a }}">
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
                <input type="text"  class="form-control max" id="broad_subject_heading" placeholder="Enter broad subject heading" name="broad_subject_heading" required="true"  autocomplete="off" value="{{ $book->broad_subject_heading }}">
              </div>
              <div class="form-group col-sm-12">
                <label for="keywords">Keywords(620):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="keywords" placeholder="Enter keywords" name="keywords" required="true"  autocomplete="off" value="{{ $book->keywords }}">
              </div>
              <div class="form-group col-sm-12">
                <label for="geographical_descriptors">Geographical Descriptors(630):</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="geographical_descriptors" placeholder="Enter geographical descriptors" name="geographical_descriptors" required="true"  autocomplete="off" value="{{ $book->geographical_descriptors }}">
              </div>
              <div class="form-group col-sm-6">
                <label for="isbn">ISBN(100):</label>
                <input type="text"  class="form-control max" id="isbn" placeholder="Enter isbn" name="isbn"  autocomplete="off">
              </div>
              <div class="form-group col-sm-6">
                <label for="issn">ISSN(101):</label>
                <input type="text"  class="form-control max" id="issn" placeholder="Enter issn" name="issn"  autocomplete="off">
              </div>
              <div class="form-group col-sm-12">
                <label for="bookrack_id">Location(Holding Library) value="{{$book->getBookrack->title}}"</label>
                <select name="bookrack_id" id="bookrack_id" class="form-control">
                  <option value="{{ $book->bookrack_id }}" >--Select Holding Library</option>
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
                <input type="text"  class="form-control max" id="language_of_text" placeholder="Enter language of text" name="language_of_text" required="true"  autocomplete="off" value="{{ $book->language_of_text }}">
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
                <input type="text"  class="form-control max" id="type_of_material" placeholder="Enter type of material" name="type_of_material" required="true"  autocomplete="off" value="{{ $book->type_of_material }}">
              </div>
              <div class="form-group col-sm-12">
                <label for="accession_no">Accession No:(1)</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="accession_no" placeholder="Enter accession no" name="accession_no" required="true"  autocomplete="off" value="{{ $book->accession_no }}">
              </div>
              <div class="form-group col-sm-12">
                <label for="information">Information</label>
                <small class="text-danger mr-4">*required</small>
                <input type="text"  class="form-control max" id="information" placeholder="Enter information" name="information" required="true"  autocomplete="off" value="{{ $book->information }}" >
              </div>
              <div class="form-group col-sm-6">
                <label for="image">Choose CoverImage</label>
                <div class="input-group">
                  <input type="file" class="form-control d-none" id="image" name="image" >
                  <img src="{{URL::to('/')}}/images/coverimage/{{$book->image_enc}}" id="profile-img-tag" width="200px" onclick="document.getElementById('image').click();" alt="your image" class="img-thumbnail img-fluid editback-gallery-img center-block"  />
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </form>
        @endforeach
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
@endsection




