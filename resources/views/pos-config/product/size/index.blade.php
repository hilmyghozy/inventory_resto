@extends('dashboard.layout')

@section('page title','Item Produk Size Management')

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
            
                        <form action="{{ url('pos/item-size') }}" method="POST">
                            @csrf 
                            <div class="form-row mt-3">
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault02">Nama Size</label>
                                <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Size" name="nama_size" required>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault03">Harga</label>
                                <input type="number" class="form-control" id="validationDefault05" placeholder="Harga" name="harga" required>
                              </div>
                              <div class="col-md-12 mb-3">
                                <label for="validationDefault04">Store</label>
                                <select class="custom-select" id="validationDefault04" name="id_store" required>
                                    @foreach ($datastore as $datas)
                                        <option value="{{ $datas->id_store }}">{{ $datas->nama_store }}</option>
                                    @endforeach
                                </select>
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
                                <form action="{{ url('pos/item-size') }}" action="get">
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
                                            <th>Nama Size</th>
                                            <th>Store</th>
                                            <th>Harga</th>
                                            <th>Setting</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataitem as $data)
                                        <tr>
                                            <td>{{$start++}}</td>
                                            <td>{{$data->nama_size}}</td>
                                            <td>{{$data->nama_store}}</td>
                                            <td>{{number_format($data->harga,0,",",".")}}</td>
                                            <td>
                                                <div class="row mt-2">
                                                  <div class="col-lg-6">
                                                    <a href="{{ url('pos/item-size/edit', $data->id_size) }}" class="text-white btn btn-block btn-warning" style="background-color: #ffc107;color: #212529">
                                                      <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    {{-- <button class="btn btn-block btn-warning"> Edit</button> --}}
                                                  </div>
                                                  <div class="col-lg-6" >
                                                      <form action="{{ url('pos/item-size', $data->id_size) }}" method="post">
                                                      @csrf 
                                                      @method('delete')
                                                      <button type="submit" class="btn btn-block btn-danger" id="btnBaru"  onclick="return confirm('Yakin data akan di hapus')">
                                                        <i class="fas fa-trash"></i>
                                                      </button> 
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
                                    <a class="page-link" href="{{ url('pos/item?search='.$search.'&pagination='.($page_now-1)) }}" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                  </li>
                                  @for ($i = 1; $i <= $count; $i++)
                                    <li class="page-item {{ $i==$page_now ? 'active' : '' }}">
                                      <a class="page-link" href="{{ url('pos/item?search='.$search.'&pagination='.$i) }}">{{ $i }}</a>
                                    </li>
                                  @endfor
                                  <li class="ml-3 page-item {{ $page_now==$count ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ url('pos/item?search='.$search.'&pagination='.($page_now+1)) }}"><i class="fas fa-chevron-right"></i></a>
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