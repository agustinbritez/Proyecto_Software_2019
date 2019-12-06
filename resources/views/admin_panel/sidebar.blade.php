<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-primary sidebar-color-success">
  <!-- Brand Logo -->
  <a href="/home" class="brand-link">

    <span class="brand-text font-weight-bold align-content-center">MyG Sublimacion</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar ">
    <!-- Sidebar user panel (optional) -->
    @guest

    @else


    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @if (!is_null(auth()->user()->imagenPrincipal))
        <img src="{{  asset('imagenes/usuarios/'.auth()->user()->imagenPrincipal)}}" class="img-circle elevation-3"
          alt="User Image">

        @else
        <img src="{{  asset('images/userIcon.jpg')}}" class="img-circle elevation-2" alt="User Image">

        @endif
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->


        @if (auth()->user()->hasRole('empleado')||auth()->user()->hasRole('admin')||auth()->user()->hasRole('gerente'))

        <li class="nav-item">
          <a href="{{ route('pedido.trabajo') }}" class="nav-link">
            <i class="far fa-user-hard-hat nav-icon"></i>
            <p>Trabajos</p>
          </a>
        </li>
        @endif
        <li class="nav-item has-treeview  ">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>

            <p>
              Pedidos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            @if (auth()->user()->hasRole('cliente')||auth()->user()->hasRole('admin'))

            <li class="nav-item">
              <a href="{{ route('pedido.misPedidos',auth()->user()->id) }}" class="nav-link">
                <i class="far fa-shopping-cart nav-icon"></i>
                <p>Mis Pedidos</p>
              </a>
            </li>
            @endif
            @if(auth()->user()->hasRole('empleado')||auth()->user()->hasRole('admin')||auth()->user()->hasRole('gerente'))
            <li class="nav-item">
              <a href="{{ route('pedido.index') }}" class="nav-link">
                <i class="fas fa-list-ol nav-icon"></i>
                <p>Listar Pedidos</p>
              </a>
            </li>
            @endif



          </ul>

        </li>

        @if (auth()->user()->hasRole('empleado')||auth()->user()->hasRole('admin')||auth()->user()->hasRole('gerente'))
        <li class="nav-item has-treeview  ">
          {{-- <a href="#" class="nav-link active"> --}}
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p>
              Gestion Produccion
              <i class="right fas fa-angle-left"></i>

            </p>
          </a>
          <ul class="nav nav-treeview">


            <li class="nav-item">
              <a href="{{ route('movimiento.index') }}" class="nav-link">
                <i class="fal fa-exchange-alt nav-icon"></i>
                <p>Movimientos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('modelo.index') }}" class="nav-link">
                <i class="fad fa-tshirt nav-icon"></i>
                <p>Productos Bases</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('modelo.indexBase') }}" class="nav-link">
                <i class="far fa-layer-group nav-icon"></i>
                <p>Opciones de Productos </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('materiaPrima.index') }}" class="nav-link">
                <i class="fas fa-cube nav-icon"></i>
                <p>Materia Prima</p>
              </a>
            </li>
          </ul>
        </li>
        @endif



        <li class="nav-item has-treeview  ">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>

            <p>
              Productos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('producto.tienda') }}" class="nav-link">
                <i class="far fa-shopping-bag nav-icon"></i>
                <p>Tienda</p>
              </a>
            </li>
          </ul>
        </li>


        @if (auth()->user()->hasRole('empleado')||auth()->user()->hasRole('admin')||auth()->user()->hasRole('gerente'))

        <li class="nav-item has-treeview  ">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>

            <p>
              Proveedores
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('proveedor.index') }}" class="nav-link">
                <i class="fas fa-list-ol nav-icon"></i>

                <p>Listar Proveedores</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('materiaPrima.stockMinimo') }}" class="nav-link">
                {{-- <i class="fal fa-arrow-alt-circle-right nav-icon"></i> --}}
                <i class="fal fa-file-alt nav-icon"></i>
                <p>Propuestas de Proveedores</p>
              </a>


          </ul>
        </li>
        @endif

        @if (auth()->user()->hasRole('empleado')||auth()->user()->hasRole('admin')||auth()->user()->hasRole('gerente'))

        <li class="nav-item has-treeview  ">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>

            <p>
              Flujos trabajos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('flujoTrabajo.index') }}" class="nav-link">
                <i class="fal fa-arrow-alt-right nav-icon"></i>


                <p>Listar Flujos</p>
              </a>
            </li>
            @if (auth()->user()->hasRole('empleado')||auth()->user()->hasRole('admin'))

            <li class="nav-item">
              <a href="{{ route('estado.index') }}" class="nav-link">
                <i class="fal fa-arrow-alt-circle-right nav-icon"></i>
                <p> Estados</p>
              </a>
            </li>
            @endif

          </ul>

        </li>
        @endif


        @if (auth()->user()->hasRole('empleado')||auth()->user()->hasRole('admin'))

        <li class="nav-item has-treeview  ">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>

            <p>
              Gestion Parametros
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item has-treeview  ">
              <a href="#" class="nav-link">
                <i class="far fa-clone nav-icon"></i>
                <p>
                  Imagenes
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ route('imagen.index') }}" class="nav-link">
                    <i class="fad fa-clone nav-icon""></i>
                    <p>Listar Imagenes</p>
                  </a>
                </li>
                <li class=" nav-item">
                      <a href="{{ route('tipoImagen.index') }}" class="nav-link">
                        <i class="fas fa-clone nav-icon"></i>
                        <p>Tipos de Imagenes</p>
                      </a>
                </li>
              </ul>
            </li>


            <li class="nav-item">
              <a href="{{ route('documento.index') }}" class="nav-link">
                <i class="fal fa-address-card nav-icon"></i>
                <p>Tipos de Documentos</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('tipoMovimiento.index') }}" class="nav-link">
                <i class="fal fa-exchange-alt nav-icon"></i>

                <p>Tipos de Movimientos</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('medida.index') }}" class="nav-link">
                <i class="fal fa-ruler-horizontal nav-icon"></i>
                <p>Unidades de Medidas</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('direccion.index') }}" class="nav-link">
                <i class="fad fa-map-marked nav-icon"></i>

                <p>Direcciones</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('pais.index') }}" class="nav-link">
                <i class="fal fa-flag nav-icon"></i>
                <p>Paises</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('provincia.index') }}" class="nav-link">
                <i class="fal fa-pennant nav-icon"></i>
                <p>Provincias</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('localidad.index') }}" class="nav-link">
                <i class="fal fa-map-marker nav-icon"></i>
                <p>Localidades</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('calle.index') }}" class="nav-link">
                <i class="fal fa-road nav-icon"></i>
                <p>Calles</p>
              </a>
            </li>


          </ul>
        </li>
        @endif
        <li class="nav-header pl-3">Otros</li>

        @if (auth()->user()->hasRole('empleado')||auth()->user()->hasRole('admin')||auth()->user()->hasRole('gerente'))

        <li class="nav-item">
          <a href="{{ route('usuario.index') }}" class="nav-link">

            <i class="fal fa-users nav-icon"></i>
            <p>Gestion Usuarios</p>
          </a>
        </li>
        @endif

        @if (auth()->user()->hasRole('auditor')||auth()->user()->hasRole('admin'))

        <li class="nav-item">
          <a href="{{ route('auditoria.index') }}" class="nav-link">
            <i class="fad fa-circle nav-icon"></i>
            <p>
              Auditoria
              {{-- <span class="right badge badge-danger">New</span> --}}
            </p>
          </a>
        </li>
        @endif
        @if (auth()->user()->hasRole('gerente')||auth()->user()->hasRole('admin'))

        <li class="nav-item">
          <a href="{{ route('estadistica.index') }}" class="nav-link">
            <i class="fal fa-chart-bar nav-icon"></i>
            <p>
              Estadisticas
              {{-- <span class="right badge badge-danger">New</span> --}}
            </p>
          </a>
        </li>
        @endif

      </ul>

    </nav>
    @endguest
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>