<nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
          </li>
          
        </ul>
    
        
        @role('Admin')
        <typeahead2 :url="customerURL" :initialize="form.customer" @input="onCustomer" />
        @endrole  
        @role('Desk User')
        <typeahead2 :url="customerURL" :initialize="form.customer" @input="onCustomer" />
        @endrole  
        
        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
         
  
          <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
              <i class="fas fa-th-large"></i>
            </a>
          </li>

        </ul>

        
      </nav>