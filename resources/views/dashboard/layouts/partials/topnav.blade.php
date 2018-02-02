<!-- Navigation -->
<nav class="navbar navbar-expand-lg bg-light fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">LOGO HERE</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="/dashboard/">Dashboard
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/dashboard/patients">Patients</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/dashboard/orders">Orders</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/dashboard/formulas">Formulas</a>
          </li>      
          <li class="nav-item">
            <a class="nav-link" href="/dashboard/products">Products</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/dashboard/categories">Categories</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/dashboard/brands">Brands</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/dashboard/users">Users</a>
          </li> 
          <li class="nav-item">
            <a class="nav-link" href="/dashboard/users/show/{{ \Auth::id() }}">Profile</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>