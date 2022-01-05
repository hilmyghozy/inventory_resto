@extends('dashboard.layout')

@section('page title','Stock Produk Management')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <a href="{{ url('pos/product/kategori') }}" class="nav-item nav-link " id="nav-home-tab">Kategori</a>
                  <a href="{{ url('pos/product/item') }}" class="nav-item nav-link " id="nav-profile-tab">Item</a>
                  <a href="{{ url('pos/product/stock') }}" class="nav-item nav-link active" id="nav-contact-tab">Stock I/O</a>
                </div>
              </nav>
                <div class="card bg-white">
                    <div class="container">
                        @if (session('status1'))
                            <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status1') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @endif
            
                        <form action="{{ url('pos/product/stock/add') }}" method="POST">
                            @csrf 
                            <div class="form-row mt-3">
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault02">Nama Item</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="validationDefault02" name="nama_item"  required readonly>
                                  <div class="input-group-btn">
                                    <button class="btn btn-primary h-100" style="border-top-left-radius: 0;border-bottom-left-radius: 0;">
                                      <i class="fas fa-search"></i>
                                    </button>
                                  </div>
                                </div>
                                <input type="hidden" id="id_item" name="nama_item">
                              </div>
                              <button type="button" class="btn btn-primary" id="btn-modaldal">
                                Open modal
                              </button>
                            
                              <!-- The Modal -->
                              <div class="modal" id="myModal">
                                <div class="modal-dialog">
                                  <div class="modal-content">
                                  
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">Modal Heading</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                      Modal body..
                                    </div>
                                    
                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    </div>
                                    
                                  </div>
                                </div>
                              </div>


                              <div class="col-md-6 mb-3">
                                <label for="validationDefault03">Jenis</label>
                                <select class="custom-select" id="validationDefault03" name="jenis" required>
                                    <option value="IN">IN</option>
                                    <option value="OUT">OUT</option>
                                </select>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault04">Qty</label>
                                <input type="number" class="form-control" id="validationDefault04" placeholder="Qty" name="qty" required>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault05">Tanggal</label>
                                <input type="date" class="form-control" id="validationDefault05" placeholder="Tanggal" name="tanggal" required>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault06">Keterangan</label>
                                <input type="text" class="form-control" id="validationDefault06" placeholder="Keterangan" name="keterangan" required>
                              </div>
                            </div>
                
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6"></div>
                                    <div class="col-lg-2 mt-2 mt-sm-0">
                
                                    </div>
                                    <div class="col-lg-2 mt-2 mt-sm-0">
                     
                                    </div>
                                    <div class="col-lg-2 mt-2 mt-sm-0">
                                        <button type="submit" class="btn btn-block btn-primary" id="btnBaru">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                  </div>

                  <div class="card card-primary card-outline">
                    <div class="row">
                        <div class="col-12">
                          <div class="card">
                            <div class="card-header">
                              <h4></h4>
                              <div class="card-header-form">
                                <form action="{{ url('pos/product/item') }}" action="get">
                                  <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="{{ ($search) }}" placeholder="Search">
                                    <div class="input-group-btn">
                                      <button class="btn btn-primary h-100" id="id-btn-search"><i class="fas fa-search"></i></button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                            <div class="card-body p-0">
                              <div class="table-responsive">
                                <table id="pos_store" class="table table-hover text-center" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Item</th>
                                            <th>Jenis</th>
                                            <th>Qty</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Setting</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datastock as $data)
                                        <tr>
                                            <td>{{$start++}}</td>
                                            <td>{{$data->nama_item}}</td>
                                            <td>{{$data->jenis}}</td>
                                            <td>{{$data->qty}}</td>
                                            <td>{{$data->tanggal}}</td>
                                            <td>{{$data->keterangan}}</td>
                                            <td>
                                                <div class="row mt-2">
                                                  <div class="col-lg-6">
                                                    <a href="{{ url('pos/product/stock/edit', $data->id_stock) }}" class="btn btn-block btn-warning" > Edit</a>
                                                    {{-- <button class="btn btn-block btn-warning"> Edit</button> --}}
                                                  </div>
                                                  <div class="col-lg-6" >
                                                      <form action="{{ url('pos/product/stock/destroy', $data->id_stock) }}" method="post">
                                                      @csrf 
                                                      @method('delete')
                                                      <button type="submit" class="btn btn-block btn-danger" id="btnBaru"  onclick="return confirm('Yakin data akan di hapus')">Delete</button> 
                                                      </form>
                                                  </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                              <nav class="d-inline-block">
                                <ul class="pagination mb-0">
                                  <li class="page-item mr-3 {{ $page_now==1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ url('pos/product/item?search='.$search.'&pagination='.($page_now-1)) }}" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                  </li>
                                  @for ($i = 1; $i <= $count; $i++)
                                    <li class="page-item {{ $i==$page_now ? 'active' : '' }}">
                                      <a class="page-link" href="{{ url('pos/product/item?search='.$search.'&pagination='.$i) }}">{{ $i }}</a>
                                    </li>
                                  @endfor
                                  <li class="ml-3 page-item {{ $page_now==$count ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ url('pos/product/item?search='.$search.'&pagination='.($page_now+1)) }}"><i class="fas fa-chevron-right"></i></a>
                                  </li>
                                </ul>
                              </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@yield('script');

@section('script')
  <script>
    
  </script>

@endsection
