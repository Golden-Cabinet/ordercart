  @include('dashboard.layouts.partials.header')
  
  @include('dashboard.layouts.partials.topnav')
  
  <!-- Page Content -->
    <div class="container">
      <div class="row" >
        <div class="col-lg-12">

          @yield('content')
          
        </div>
      </div>
    </div>
  
    @include('dashboard.layouts.partials.footer')
