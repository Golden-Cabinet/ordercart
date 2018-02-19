<!-- Navigation -->

<nav class="navbar navbar-expand-lg bg-white fixed-top" style="border-bottom: 1px solid #dedede; background: #f5f5f5">
  <div class="container-fluid">
      <a class="navbar-brand" href="/"><img src="/images/header-logo.svg" style="height: 56px"> View Site <i class="fas fa-external-link-alt"></i></a>
      <button class="navbar-toggler bg-dark btn-dark" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link mr-2" href="/dashboard/">Dashboard
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link mr-2" href="/dashboard/patients">Patients</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mr-2" href="/dashboard/orders">Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link mr-2" href="/dashboard/formulas">Formulas</a>
          </li>     
       
          <li class="nav-item">
            <a class="nav-link mr-2" href="/dashboard/users/show/{{ \Auth::id() }}">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-outline-secondary mr-2" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout
        </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
          </form>
          </li>  
        </ul>
      </div>
    </div>
  </nav>