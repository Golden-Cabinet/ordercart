<!-- Navigation -->


<nav class="navbar navbar-expand-lg bg-white fixed-top">
    <div class="container">
      <a class="navbar-brand" href="/"><img src="/images/header-logo.svg" style="height: 56px"></a>
      <button class="navbar-toggler bg-dark btn-dark" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/about">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/order">Order</a>
          </li>    
          <li class="nav-item">
            <a class="nav-link" href="/location">Location</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/faq">FAQ</a>
          </li>          
          @if(Auth::check())
          <li class="nav-item">
              <a class="nav-link" href="/dashboard">My Cabinet</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/policies">Policies &amp; Procedures</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                Logout
            </a>
  
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            </li>
          @else
          <li class="nav-item">
              <a class="nav-link" href="/register">Register</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" href="/login">Login</a>
          </li>
          @endif         

        </ul>
      </div>
    </div>
  </nav>