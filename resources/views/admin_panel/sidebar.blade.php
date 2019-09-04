<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-dark-primary">
        <!-- Brand Logo -->
        <a href="/home" class="brand-link">

          <span class="brand-text font-weight-bold align-content-center">ReCoop</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <img src="{{asset('admin_panel/dist/img/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
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
                    <a href="#" class="nav-link active">
                      <i class="nav-icon fas fa-warehouse"></i>
                      <p>
                        Gestion Almacen
                        <i class="right fas fa-angle-left"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/" class="nav-link">
                                <i class="fas fa-cube nav-icon"></i>
                                <p>Productos</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="/" class="nav-link">
                                    <i class="fas fa-people-carry nav-icon"></i>
                                    <p>Proveedores</p>
                                </a>
                            </li>
                    </ul>

                  </li>

              <li class="nav-item has-treeview ">
                <a href="#" class="nav-link active">
                    <i class="nav-icon fas fa-users-cog"></i>
                    <p>
                      Gestion Usuarios
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  
                      <ul class="nav nav-treeview">
                        <li class="nav-item">
                          <a href="{{ route('materiaPrima.index') }}" class="nav-link">
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
              </li>

            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>
