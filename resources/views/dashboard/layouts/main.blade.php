  @include('dashboard.layouts.partials.header')
  

      <div class="container-fluid no-gutters mb-4">
          @include('dashboard.layouts.partials.topnav')
      </div> 


  
  <!-- Page Content -->
    <div class="container mt-4 mb-4">
      <div class="row" >
        <div class="col-lg-12 mt-3" style="min-height: 800px">

          @yield('content')
          
        </div>
      </div>
    </div>
  
    @include('dashboard.layouts.partials.footer')
