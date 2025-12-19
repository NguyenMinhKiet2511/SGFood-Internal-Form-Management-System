<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
  <div class="container-fluid">
    
    {{-- Left side: Logo + Title --}}
    <div class="collapse navbar-collapse justify-content">
      <ul class="navbar-nav">
        <li class="nav-item">
          <span class="nav-link disabled text-white"><i class="bi bi-pc-display-horizontal"></i></span>
        </li>
        <li class="nav-item">
          <span class="nav-link disabled text-white"><strong>Request & Maintenance</strong></span>
        </li>
    </div>

    {{-- Right side: Info and Logout --}}
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav align-items-center">

        {{-- Hello User --}}
        @auth
        <li class="nav-item me">
          <span class="nav-link text-white">Hello, <strong>{{ Auth::user()->name }}</strong></span>
        </li>

        {{-- Logout --}}
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-light">
              <i class="bi bi-box-arrow-right me"></i> 
            </button>
          </form>
        </li>
        @endauth

      </ul>
    </div>
  </div>
</nav>
