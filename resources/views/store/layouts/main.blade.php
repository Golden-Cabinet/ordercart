@include('store.layouts.partials.header')
  
    <div class="container-fluid no-gutters mb-4">
        @include('store.layouts.partials.topnav')
    </div> 



<!-- Page Content -->
  <div class="container mt-4 mb-4">
    <div class="row" >
      <div class="col-lg-12 mt-3">
          
        @yield('content')
        
      </div>
    </div>
  </div>

  @include('store.layouts.partials.footer')
