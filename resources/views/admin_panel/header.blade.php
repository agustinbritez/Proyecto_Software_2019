<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <div class="col">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link " href="{{ url('/home') }}">
          {{-- {{ config('app.name', 'Laravel') }} --}}
          Inicio
        </a>

        {{-- <a href="/home" class="nav-link">Home</a> --}}
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
                <a href="#" class="nav-link">Contacto</a>
              </li> --}}
    </ul>
  </div>
  <div class="col">

    <ul class="navbar-nav">
      <li class="nav-item ">

        <a href="{{route('producto.tienda')}}" class="btn btn-success " style="border-radius:0%"><i
            class="far fa-shopping-bag nav-icon"></i> Tienda </a>
      </li>

    </ul>




  </div>




  <!-- Authentication Links -->
  @guest
  <div class="col-3">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link  " href="{{ route('login') }}">{{ __('Iniciar Sesion') }}</a>
      </li>
      @if (Route::has('register'))
      <li class="nav-item">
        <a class="nav-link " href="{{ route('register') }}">{{ __('Registrarse') }}</a>
      </li>
      @endif
    </ul>
  </div>
  @else
  <div class="col-2">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item ">
        <a href="{{route('pedido.misPedidos',auth()->user()->id)}}" class="btn btn-info  " style="border-radius:0%">
           <i class="far fa-shopping-cart nav-icon"></i>
          Mis
          Pedidos</a>

      </li>
      <li class="nav-item dropdown">
        @if (auth()->user()!=null)
        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false" v-pre>
          {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="{{ route('usuario.editMiPerfil') }}" onclick="event.preventDefault();
                  document.getElementById('perfil-form').submit();">
            {{ __('Editar Perfil') }}
          </a>

          <form id="perfil-form" action="{{ route('usuario.editMiPerfil') }}" method="GET" style="display: none;">
            @csrf
          </form>
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
            {{ __('Cerrar Sesion') }}
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>

        </div>


        @endif


      </li>
    </ul>
  </div>
  @endguest


</nav>



















{{-- <nav class="navbar  navbar-expand-md navbar-light bg-white  shadow-sm"> --}}
{{-- <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a class="nav-link " href="{{ url('/home') }}">
{{ config('app.name', 'Laravel') }}
Inicio
</a>

<a href="/home" class="nav-link">Home</a>
</li>
<li class="nav-item d-none d-sm-inline-block">
  <a href="#" class="nav-link">Contacto</a>
</li>
</ul>



<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
  <span class="navbar-toggler-icon"></span>
</button>






<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <!-- Left Side Of Navbar -->
  <ul class="navbar-nav mr-auto">

  </ul>

  <!-- Right Side Of Navbar -->
  <ul class="navbar-nav ml-auto">
    <!-- Authentication Links -->
    @guest
    <li class="nav-item">
      <a class="nav-link  " href="{{ route('login') }}">{{ __('Iniciar Sesion') }}</a>
    </li>
    @if (Route::has('register'))
    <li class="nav-item">
      <a class="nav-link " href="{{ route('register') }}">{{ __('Registrarse') }}</a>
    </li>
    @endif
    @else
    <li class="nav-item dropdown">
      <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false" v-pre>
        {{ Auth::user()->name }} <span class="caret"></span>
      </a>

      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
        <a class="dropdown-item" href="{{ route('usuario.editMiPerfil') }}" onclick="event.preventDefault();
              document.getElementById('perfil-form').submit();">
          {{ __('Editar Perfil') }}
        </a>

        <form id="perfil-form" action="{{ route('usuario.editMiPerfil') }}" method="GET" style="display: none;">
          @csrf
        </form>
        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
          {{ __('Cerrar Sesion') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>

      </div>

    </li>
    @endguest
  </ul>
</div>

</nav> --}}

<!-- Navbar -->
{{-- <nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/home" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contacto</a>
    </li>
  </ul>

  <!-- SEARCH FORM -->
  <form class="form-inline ml-3">
    <div class="input-group input-group-sm">
      <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-navbar" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
  </form>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Messages Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-comments"></i>
        <span class="badge badge-danger navbar-badge">3</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="#" class="dropdown-item">
          <!-- Message Start -->
          <div class="media">
            <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Brad Diesel
                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">Call me whenever you can...</p>
              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
            </div>
          </div>
          <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <!-- Message Start -->
          <div class="media">
            <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                John Pierce
                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">I got your message bro</p>
              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
            </div>
          </div>
          <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <!-- Message Start -->
          <div class="media">
            <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
            <div class="media-body">
              <h3 class="dropdown-item-title">
                Nora Silvester
                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
              </h3>
              <p class="text-sm">The subject goes here</p>
              <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
            </div>
          </div>
          <!-- Message End -->
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
      </div>
    </li>
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i class="fas fa-th-large"></i></a>
    </li>
  </ul>
</nav> --}}
<!-- /.navbar -->