<!-- Navigation -->

<nav class="navbar navbar-expand-lg bg-white fixed-top" style="border-bottom: 1px solid #dedede; background: #f5f5f5">
    <div class="container-fluid">
      <a class="navbar-brand" href="/"><img src="/images/header-logo.svg" style="height: 56px"></a>
      <button class="navbar-toggler bg-dark btn-dark" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto rightnav">
          <li class="nav-item active">
            <a class="nav-link mr-2" href="/">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link mr-2" href="/about">About Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mr-2" href="/order">Order</a>
          </li>    
          <li class="nav-item">
            <a class="nav-link mr-2" href="/location">Location</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mr-2" href="/faq">FAQ</a>
          </li>          
          @if(Auth::check())
          <li class="nav-item float-right">
            <a class="nav-link mr-2" href="/dashboard">My Cabinet</a>
            </li>
            <li class="nav-item navtextright4">
              <a class="nav-link mr-2" href="/policies">Policies &amp; Procedures</a>
            </li>
            <li class="nav-item navtextright3">
              <a class="nav-link btn btn-outline-secondary mr-2" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                Logout
            </a>
  
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            </li>
          @else
          <li class="nav-item navtextright1">
            <p class="mr-3 pt-2"><strong>Practitioners: </strong></p>
          </li>  
          <li class="nav-item navtextright2">
            <a class="nav-link mr-2" href="/register">Register</a>
          </li>
          <li class="nav-item navtextright3">
            <a class="nav-link btn btn-outline-secondary" href="/login">Login</a>
          </li>
          @endif         

        </ul>
      </div>
    </div>
  </nav>
