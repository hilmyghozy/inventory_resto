@extends('dashboard.layout')

@section('page title','Kategori Produk Management')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg">
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
                        
                        <form action="{{ url('pos/kategori/add') }}" method="POST">
                            @csrf 
                            <div class="form-row mt-3">
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault02">Nama Kategori</label>
                                <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Kategori" name="nama_kategori" required>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault06">Print By</label>
                                <select name="print_by" id="validationDefault06" class="form-control">
                                  <option value="nama">Nama Printer</option>
                                  <option value="ip">IP Address Printer</option>
                                </select>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault03">IP / Nama Printer 1</label> <small>(Boleh dikosongkan)</small>
                                <input type="text" class="form-control" id="validationDefault03" placeholder="IP Printer 1" name="ip_printer1">
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault04">IP / Nama Printer 2</label> <small>(Boleh dikosongkan)</small>
                                <input type="text" class="form-control" id="validationDefault04" placeholder="IP Printer 2" name="ip_printer2">
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault05">IP / Nama Printer 3</label> <small>(Boleh dikosongkan)</small>
                                <input type="text" class="form-control" id="validationDefault05" placeholder="IP Printer 3" name="ip_printer3">
                              </div>
                              
                            </div>
                
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                    </div>
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
                                <form action="{{ url('pos/kategori') }}" action="get">
                                  <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Search">
                                    <div class="input-group-btn">
                                      <button class="btn btn-primary" id="id-btn-search"><i class="fas fa-search"></i></button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                            <div class="card-body p-0">
                              <div class="table-responsive">
                                <table class="table table-hover text-center" id="pos-store">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name Kategori</th>
                                            <th>Print By</th>
                                            <th>Printer 1</th>
                                            <th>Printer 2</th>
                                            <th>Printer 3</th>
                                            <th>Setting</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body-table">
                                      @foreach ($datakategori as $data) 
                                      <tr>
                                        <td>{{$start++}}</td>
                                        <td>{{$data->nama_kategori}}</td>
                                        <td>{{ucfirst($data->print_by)}}</td>
                                        <td>{{$data->ip_printer1}}</td>
                                        <td>{{$data->ip_printer2}}</td>
                                        <td>{{$data->ip_printer3}}</td>
                                        <td>
                                          <div class="row mt-2">
                                            <div class="col-lg-6">
                                              <a href="{{ url('pos/kategori/edit', $data->id_kategori) }}" class="btn btn-block btn-warning" style="background-color: #ffc107;color: #212529"> Edit</a>
                                              {{-- <button class="btn btn-block btn-warning"> Edit</button> --}}
                                            </div>
                                            <div class="col-lg-6" >
                                                <form action="{{ url('pos/kategori/destroy', $data->id_kategori) }}" method="post">
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
                        <div class="row" >
                            <div class="col-lg-6">
                                <nav class="d-inline-block">
                                    <ul class="pagination mb-0">
                                      <li class="page-item mr-3 {{ $page_now==1 ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ url('pos/kategori?search='.$search.'&pagination='.($page_now-1)) }}" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                      </li>
                                      @for ($i = 1; $i <= $count; $i++)
                                        <li class="page-item {{ $i==$page_now ? 'active' : '' }}">
                                          <a class="page-link" href="{{ url('pos/kategori?search='.$search.'&pagination='.$i) }}">{{ $i }}</a>
                                        </li>
                                      @endfor
                                      <li class="ml-3 page-item {{ $page_now==$count ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ url('pos/kategori?search='.$search.'&pagination='.($page_now+1)) }}"><i class="fas fa-chevron-right"></i></a>
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

@section('script')
<script type="text/javascript">

  
</script>
@endsection
