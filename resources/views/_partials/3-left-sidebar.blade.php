<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="img/newlogo.png" alt="AdminLTE Logo" class="brand-image " style="opacity: .8">
    <span class="brand-text font-weight-light">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        @auth  
        <!--  {{ Auth::user()->photos }} -->        
        @endauth
        <img src="https://adminlte.io/themes/dev/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>

      <div class="info">
        <a href="#" class="d-block">
          @auth
          {{ Auth::user()->name }}
          @endauth
        </a>
      </div>
    </div>

   <!-----------------------------------------Admin -menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">      
        <li class="nav-item">

        <li class="nav-item">
                <router-link to="/dashboard" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt orange"></i> <p> Dashboard </p>
                </router-link>
        </li>
        
        @can('client-list')
        <li class="nav-item">
            <router-link to="/clients" class="nav-link">
              <i class="nav-icon fas fa-users orange"></i> <p>Clients </p>
            </router-link>
        </li>      
        @endcan

        @can('location-list') 
        <li class="nav-item">
            <router-link to="/locations" class="nav-link">
              <i class="nav-icon fas fa-map-marker orange"></i> <p>Locations </p>
            </router-link>
          </li>         
         @endcan

         @can('task-list') 
         <li class="nav-item">
            <router-link to="/tasks" class="nav-link">
              <i class="nav-icon fas fa-cogs orange"></i> <p>Task </p>
            </router-link>
          </li>                  
          @endcan
          
    
          @can('history-list') 
          <li class="nav-item">
              <router-link to="/history" class="nav-link">
                <i class="nav-icon fa fa-book orange"></i> <p>History </p>
              </router-link>
            </li>
           @endcan

      
        @can('calendar-list')      
        <li class="nav-item">
          <router-link to="/calendar" class="nav-link">
            <i class="nav-icon fas fa-calendar orange"></i>            
            <p>Calendar </p>
          </router-link>
        </li>
        @endcan

        
        @can('user-list')
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link"><i class="nav-icon fa fa-user orange" aria-hidden="true"></i> <p> Users <i class="fas fa-angle-left right"></i>                           
            </p>
          </a>
          <ul class="nav nav-treeview">
            @can('user-create') 
            <li class="nav-item">
              <router-link to="/users/create" class="nav-link sub">
                <i class="fa fa-plus" aria-hidden="true"></i> <p>Create</p>
              </router-link>
            </li>
            @endcan
            <li class="nav-item">
              <router-link to="/users" class="nav-link sub">
                <i class="fa fa-list" aria-hidden="true"></i> <p>List</p>
              </router-link>
            </li>
            
          </ul>
        </li>
        @endcan
       
        @role('Admin')
        <li class="nav-item">
            <router-link to="/globalsettings" class="nav-link">
              <i class="nav-icon fas fa-cog orange"></i> <p>Global settings </p>
            </router-link>
        </li>
        @endrole


        @role('Field User')
        <li class="nav-item">
          <router-link to="/usertasks" class="nav-link">
            <i class="nav-icon fas fa-cogs orange"></i> <p>My Task List</p>
          </router-link>
        </li>
        @endrole


        @role('Field User')
        <li class="nav-item">
          <router-link to="/usersettings" class="nav-link">
            <i class="nav-icon fas fa-cog orange"></i> <p>Settings</p>
          </router-link>
        </li>
        @endrole

         
        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-power-off"></i>
            <p>{{ __('Logout') }}</p>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
    
      </ul>
    </nav>
    <!-----------------------------------------Admin -menu -->




    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>