@php
$sidebarMenu = \App\Http\Controllers\Dashboard\Structure::sidebarMenu();
$segment = request()->segments();
@endphp

<!-- Brand Logo -->
<!-- <a href="{{ url('/') }}" class="brand-link"> -->
<!-- <img src="{{ asset('images/loader.png') }}" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8"> -->
<!-- <i class="fas fa-city brand-image elevation-3" style="color: yellow"></i> -->
<!-- <span class="brand-text font-weight-light"><strong>{{ config('app.app_name') }}</strong></span> -->
<!-- </a> -->


<!-- /.sidebar -->
<!-- <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
          </div> -->
<ul class="sidebar-menu">
  <li class="menu-header">Menu</li>
  <li>
    <a class="nav-link" href="{{ url('admin') }}">
      <i class="nav-icon fas fa-th"></i>
      <span>Home</span>
    </a>
  </li>

  <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user"></i> <span>User Config</span></a>
    <ul class="dropdown-menu" style="display: none;">
      <li><a class="nav-link" href="{{ url('uc/admin') }}">Admin</a></li>
      {{-- <li><a class="nav-link" href="role">Role</a></li> --}}
      <li><a class="nav-link" href="{{ url('uc/user') }}">User&Employee</a></a></li>
    </ul>
  </li>

  {{-- <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-boxes"></i> <span>Inventory Config</span></a>
                <ul class="dropdown-menu" style="display: none;">
                  <li><a class="nav-link" href="storehouse">Storehouse</a></li>
                  <li><a class="nav-link" href="supplier">Supplier</a></li>
                  <li><a class="nav-link" href="unit">Unit</a></li>
                  <li><a class="nav-link" href="raw_product">Raw Product</a></li>
                  <li><a class="nav-link" href="half_product">Half Product</a></li>
                  <li><a class="nav-link" href="recipe">Recipe</a></a></li>
                  <li><a class="nav-link" href="banquette">Banquette</a></a></li>
                </ul>
              </li> --}}

  <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-check-square"></i> <span>Pos Config</span></a>
    <ul class="dropdown-menu" style="display: none;">
      <li><a class="nav-link" href="{{ url('pos/store') }}">Store</a></a></li>
      <li><a class="nav-link" href="{{ url('pos/kategori') }}">Kategori</a></a></li>
      <li><a class="nav-link" href="{{ url('pos/kategori/additional-menu') }}">Additional Menu</a></a></li>
      <li><a class="nav-link" href="{{ url('pos/item-group') }}">Item Group</a></a></li>
      <li><a class="nav-link" href="{{ url('pos/item') }}">Item</a></a></li>
      <li><a class="nav-link" href="{{ url('pos/item-size') }}">Item Size</a></a></li>
      <li><a class="nav-link" href="{{ url('pos/item-type') }}">Item Type</a></a></li>
      <li><a class="nav-link" href="{{ url('pos/paket') }}">Paket</a></a></li>
      <li><a class="nav-link" href="{{ url('pos/discount') }}">Discount</a></a></li>
      <li><a class="nav-link" href="{{ url('pos/payment') }}">Payment Type</a></a></li>
    </ul>
  </li>
  <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-tasks"></i> <span>Transaction</span></a>
    <ul class="dropdown-menu" style="display: none;">
      {{-- <li><a class="nav-link" href="#">Purchase Order</a></li> --}}
      <li><a class="nav-link" href="{{ url('transaction/log') }}">Transaction Log</a></li>
      <li><a class="nav-link" href="{{ url('transaction/session') }}">Session</a></li>
      {{-- <li><a class="nav-link" href="#">Form Preparation</a></li>
                  <li><a class="nav-link" href="#">Daily Market List</a></a></li>
                  <li><a class="nav-link" href="#">Half Product</a></a></li>
                  <li><a class="nav-link" href="#">Recipe</a></a></li>
                  <li><a class="nav-link" href="#">Store Request</a></a></li>
                  <li><a class="nav-link" href="#">Bunquet</a></a></li> --}}
    </ul>
  </li>

  <li class="nav-item dropdown">
    <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-file-signature"></i> <span>Report</span></a>
    <ul class="dropdown-menu" style="display: none;">
      {{-- <li><a class="nav-link" href="#">Stock</a></li>
                  <li><a class="nav-link" href="#">Bunquet</a></li>
                  <li><a class="nav-link" href="#">Revenue & Cost</a></a></li> --}}
      <li><a class="nav-link" href="{{ url('report/sales') }}">Sales</a></a></li>
      <li><a class="nav-link" href="{{ url('report/store_sales') }}">Store Sales</a></a></li>
      {{-- <li><a class="nav-link" href="#">Profit & Lost</a></a></li> --}}
    </ul>
  </li>

</ul>