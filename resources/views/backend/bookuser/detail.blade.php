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
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-capitalize">{{$currentPath}} Page</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Default box -->
    <div class="card">
      <?php $page = substr((Route::currentRouteName()), 0, strpos((Route::currentRouteName()), ".")); ?>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead class="bg-dark">
              <tr>
                <th style="width: 10px" >SN</th>
                <th>User</th>
                <th>Book</th>
              </tr>
            </thead>
            @foreach($bookusers as $key=>$book)
            <tr>
              <td>{{$key+1}}</td>
              <td>{{$book->getBorrower->name}}</td>
              <td>{{$book->getBook->title}}</td>
            </tr>
            @endforeach
          </table>
        </div>
      </div>
      <!-- /.card-body -->
      <div class="card-footer">
       {!! $bookusers->links("pagination::bootstrap-4") !!}
     </div>
     <!-- /.card-footer-->
   </div>
   <!-- /.card -->
 </section>
 <!-- /.content -->
</div>

@endsection

