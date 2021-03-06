<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>AdminLTE 3 | Starter</title>
    
  <link rel="stylesheet" href="/css/app.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper" id="app">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      
    </ul>

    <!-- SEARCH FORM -->
    
      <div class="input-group input-group-sm">
        <input 
          class="form-control 
          form-control-navbar" 
          v-model="search" 
          @keyup.enter="searchit"
          type="search" 
          placeholder="Search" 
          aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="searchit">
            <i class="fa fa-search"></i>
          </button>
        </div>
      </div>
  

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
     
      <!-- Notifications Dropdown Menu -->
     
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fa fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="/img/horse.png" alt="Jugueteria Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Sistema</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/img/boy.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            {{Auth::user()->name}}
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

              <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-cash-register"></i>
                <p>
                  Ventas
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/facturas" class="nav-link">
                   <i class="fas fa-file-invoice-dollar"></i>
                      <p>
                        Facturas de Ventas
                      </p>
                  </router-link>
                 
                </li>
              </ul>
            </li>
            

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fab fa-product-hunt"></i>
                <p>
                  Compras
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <router-link to="/remitos" class="nav-link">
                    <i class="fas fa-receipt"></i>
                      <p>
                        Facturas de Compra
                      </p>
                  </router-link>
                   {{-- <router-link to="/remitos" class="nav-link">
                    <i class="fas fa-receipt"></i>
                      <p>
                       Remitos
                      </p>
                  </router-link> --}}
                   {{-- <router-link to="/compras" class="nav-link">
                    <i class="fas fa-receipt"></i>
                      <p>
                       Reporte Compras
                      </p>
                  </router-link> --}}
                </li>
              </ul>
            </li>

            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="fas fa-boxes"></i>
                <p>
                  Articulos
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                    <router-link to="/articulos" class="nav-link">
                      <i class="fas fa-barcode"></i>
                      <p>Articulos</p>
                    </router-link>
                </li>
                {{-- <li class="nav-item">
                  <router-link to="/inventarios" class="nav-link">
                    <i class="fas fa-warehouse"></i>
                    <p>Inventario</p>
                  </router-link>
                </li> --}}

                <li class="nav-item">
                  <router-link to="/categorias" class="nav-link">
                    <i class="fas fa-tags"></i>
                    <p>Categorias</p>
                  </router-link>
                </li>

                <li class="nav-item">
                  <router-link to="/suppliers" class="nav-link">
                    <i class="fas fa-truck-loading"></i>
                    <p>Suppliers</p>
                  </router-link>
                </li>

                <li class="nav-item">
                  <router-link to="/marcas" class="nav-link">
                    <i class="fas fa-copyright"></i>
                    <p>Marcas</p>
                  </router-link>
                </li>
               
              </ul>
            </li>
             <li class="nav-item">
              <router-link to="/clientes" class="nav-link">
               <i class="fas fa-address-card"></i>
                 <p>
                Clientes
                
               </p>
             </router-link>
           </li>

             <li class="nav-item">
              <router-link to="/dashboard" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                  Dashboard
                 
                </p>
              </router-link>
              
            </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="fas fa-cogs"></i>
              <p>
                Management
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/users" class="nav-link">
                  <i class="fa fas fa-users"></i>
                  <p>Users</p>
                </router-link>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fa fa-circle-o nav-icon"></i>
                  <p>Inactive Page</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- <li class="nav-item">
            <router-link to="/lista" class="nav-link">
             <i class="nav-icon fas fa-tachometer-alt"></i>
               <p>
               Facturas
              
             </p>
           </router-link>
         </li> --}}

            <li class="nav-item">
               <router-link to="/profile" class="nav-link">
                <i class="fas fa-file-invoice"></i>
                  <p>
                  Profile
                 
                </p>
              </router-link>
            </li>
            {{-- <li class="nav-item">
               <router-link to="/grafico" class="nav-link">
                <i class="fas fa-file-invoice"></i>
                  <p>
                  Graficos
                 
                </p>
              </router-link>
            </li> --}}
            @can('isAdmin')
            <li class="nav-item">
               <router-link to="/developer" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                  <p>
                  Dev
                 
                </p>
              </router-link>
            </li>
            @endcan
           

            <li class="nav-item">
              

              <a  href="{{ route('logout') }}" class="nav-link"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    <i class="nav-icon fas fa-power-off"></i>
                    <p>
                      {{ __('Logout') }}
                    </p>
               
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
       <router-view></router-view>
        
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2018 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<script src="/js/app.js"></script>

</body>
</html>
