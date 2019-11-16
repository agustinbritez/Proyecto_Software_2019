<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-primary sidebar-color-success">
  <!-- Brand Logo -->
  <a href="/home" class="brand-link">

    <span class="brand-text font-weight-bold align-content-center">MyG Sublimacion</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar ">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{asset('admin_panel/dist/img/user6-128x128.jpg')}}" class="img-circle elevation-2" alt="User Image">
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

        <li class="nav-item has-treeview  ">
          {{-- <a href="#" class="nav-link active"> --}}
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-warehouse"></i>
            <p>
              Gestion Produccion
              <i class="right fas fa-angle-left"></i>

            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('materiaPrima.index') }}" class="nav-link">
                <i class="fas fa-cube nav-icon"></i>
                <p>Materia Prima</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('proveedor.index') }}" class="nav-link">
                <i class="fas fa-people-carry nav-icon"></i>
                <p>Proveedores</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('movimiento.index') }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Movimientos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('modelo.index') }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Modelos</p>
              </a>
            </li>

          </ul>
        </li>
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
                <i class="fas  nav-icon"></i>
                <p>Tienda</p>
              </a>
            </li>
          </ul>



        </li>
        <li class="nav-item has-treeview  ">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>

            <p>
              Imagenes
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('imagen.index') }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Imagenes</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('tipoImagen.index') }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Tipo de Imagenes</p>
              </a>
            </li>
          </ul>





        </li>
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
                <i class="fas  nav-icon"></i>
                <p>Ver flujos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('estado.index') }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Ver estados</p>
              </a>
            </li>
          </ul>

        </li>
        <li class="nav-item has-treeview  ">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>

            <p>
              Pedidos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('pedido.misPedidos',auth()->user()->id) }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Mis Pedidos</p>
              </a>
            </li>

          </ul>

        </li>


        <li class="nav-item has-treeview  ">
          <a href="#" class="nav-link">
            <i class="far fa-circle nav-icon"></i>

            <p>
              Gestion Parametros
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('direccion.index') }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Direcciones</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('documento.index') }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Documentos</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('tipoMovimiento.index') }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Tipos de Movimientos</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('medida.index') }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Medidas</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('pais.index') }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Paises</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('provincia.index') }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Provincias</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('localidad.index') }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Localidades</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('calle.index') }}" class="nav-link">
                <i class="fas  nav-icon"></i>
                <p>Calles</p>
              </a>
            </li>


          </ul>
        </li>


        <li class="nav-item">
          <a href="{{ route('auditoria.index') }}" class="nav-link">
            {{-- <i class="far fa-circle nav-icon"></i> --}}
            <i class="fad fa-table nav-icon"></i>
            <p>
              Auditoria
              {{-- <span class="right badge badge-danger">New</span> --}}
            </p>
          </a>
        </li>

        @can('usuarios_index')


        {{-- <li class="nav-item has-treeview ">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-users-cog"></i>
                    <p>
                      Gestion Usuarios
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="{{ route('usuarios.index') }}" class="nav-link">
        <i class="far fa-user nav-icon"></i>
        <p>Usuarios</p>
        </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="/" class="nav-link">
            <i class="fas fa-user-lock nav-icon"></i>
            <p>Roles</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="fas fa-user-tag nav-icon"></i>
            <p>Permisos</p>
          </a>
        </li>
      </ul>
      </li> --}}
      @endcan
      </ul>

    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>