<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="{{URL::to('/')}}/home" class="brand-link">
    <img src="https://image.shutterstock.com/image-vector/open-book-vector-clipart-silhouette-260nw-358417976.jpg"
    alt="AdminLTE Logo"
    class="brand-image img-circle elevation-3"
    style="opacity: .8">
    <span class="brand-text font-weight-light">LMS</span>

  </a>
  
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{URL::to('/')}}/backend/images/user.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{Auth::user()->name}}</a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{URL::to('/')}}/home/category" class="nav-link  {{ (request()->is('home/category')) ? 'active' : '' }}">
            <i class=" nav-icon fas fa-sliders-h"></i>
            <p>Category</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{URL::to('/')}}/home/author" class="nav-link  {{ Request::is('home/author') ? 'active' : '' }} ">
            <i class=" nav-icon fas fa-address-book"></i>
            <p>Author</p>
          </a>
        </li>
        <li class="nav-item ">
          <a href="{{URL::to('/')}}/home/publisher" class="nav-link  {{ (request()->is('home/publisher')) ? 'active' : '' }}">
            <i class="nav-icon fas fa-file"></i>
            <p>Publisher</p>
          </a>
        </li>
        <li class="nav-item ">
          <a href="{{URL::to('/')}}/home/supplier" class="nav-link  {{ (request()->is('home/supplier')) ? 'active' : '' }}">
            <i class="nav-icon far fa-images"></i>
            <p>Supplier</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{URL::to('/')}}/home/bookrack" class="nav-link  {{ (request()->is('home/bookrack')) ? 'active' : '' }} ">
            <i class=" nav-icon fab fa-product-hunt"></i>
            <p>Bookrack</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{URL::to('/')}}/home/borrower" class="nav-link {{ (request()->is('home/borrower')) ? 'active' : '' }} ">
            <i class=" nav-icon fas fa-building"></i>
            <p>Borrower</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{URL::to('/')}}/home/book" class="nav-link  {{request()->is('home/book') ? 'active' : ''}} ">
            <i class=" nav-icon fas fa-book"></i>
            <p>Book</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{URL::to('/')}}/home/book/search" class="nav-link  {{request()->is('home/book/search') ? 'active' : ''}} ">
            <i class=" nav-icon fas fa-search"></i>
            <p>Search</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{URL::to('/')}}/home/bookhasauthor" class="nav-link  {{request()->is('home/bookhasAuthor') ? 'active' : ''}} ">
            <i class=" nav-icon fas fa-book"></i>
            <p>BookHasAuthor</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>