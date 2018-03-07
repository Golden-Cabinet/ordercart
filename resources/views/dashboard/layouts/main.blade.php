  @include('dashboard.layouts.partials.header')  
  
      <div class="container-fluid no-gutters mb-4">
        @if(\Auth::user()->user_roles_id == 2)
          @include('dashboard.layouts.partials.admintopnav')
        @endif
        
        @if(\Auth::user()->user_roles_id == 3)
          @include('dashboard.layouts.partials.practitionertopnav')
        @endif

        @if(\Auth::user()->user_roles_id == 4)
          @include('dashboard.layouts.partials.studenttopnav')
        @endif
      </div> 


  
  <!-- Page Content -->
    <div class="container mt-4 mb-4">
      <div class="row" >
        <div class="col-lg-12 mt-3" style="min-height: 800px">
            @include('dashboard.layouts.partials.alerts')
          @yield('content')
          
        </div>
      </div>
    </div>
  
    @include('dashboard.layouts.partials.footer')
