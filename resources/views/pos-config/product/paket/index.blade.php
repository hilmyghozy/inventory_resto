@extends('dashboard.layout')

@section('page title','Paket Produk Management')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

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

            <form action="{{ url('pos/paket/add') }}" method="POST">
              @csrf
              <div class="form-row mt-3">
                <div class="col-md-6 mb-3">
                  <label for="validationDefault02">Nama Paket</label>
                  <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Paket" name="nama_paket" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="validationDefault04">Store</label>
                  <select class="custom-select" id="validationDefault04" name="id_store" required>
                    @foreach ($datastore as $datas)
                    <option value="{{ $datas->id_store }}">{{ $datas->nama_store }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-row mt-3">
                <div class="col-md-6 mb-3">
                  <label for="validationDefault02">Pajak</label>
                  <input type="number" class="form-control" id="validationDefault02" placeholder="Pajak" name="pajak" value="0" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="validationDefault04">Harga Jual</label>
                  <input type="number" class="form-control" id="validationDefault02" placeholder="Harga Jual" name="harga_jual" value="0" required>

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
                    <form action="{{ url('pos/paket') }}" action="get">
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
                          <th>Name Paket</th>
                          <th>Store</th>
                          <th>Harga Jual</th>
                          <th>Setting</th>
                        </tr>
                      </thead>
                      <tbody id="body-table">

                        @foreach ($datapaket as $data)
                        <tr>
                          <td>{{$start++}}</td>
                          <td>{{$data->nama_paket}}</td>
                          <td>{{$data->nama_store}}</td>
                          <td>{{$data->harga_jual}}</td>
                          <td>
                            <div class="row mt-2">
                              <div class="col-lg-4">
                                <a href="{{ url('pos/paket/kelola', $data->id_paket) }}" class="btn btn-primary" style="background-color: #ffc107;color: #212529"> Kelola</a>
                              </div>
                              <div class="col-lg-4">
                                <a href="{{ url('pos/paket/edit', $data->id_paket) }}" class="btn btn-warning" style="background-color: #ffc107;color: #212529"> Edit</a>
                                {{-- <button class="btn btn-warning"> Edit</button> --}}
                              </div>
                              <div class="col-lg-4">
                                <form action="{{ url('pos/paket/destroy', $data->id_paket) }}" method="post">
                                  @csrf
                                  @method('delete')
                                  <button type="submit" class="btn btn-danger" id="btnBaru" onclick="return confirm('Yakin data akan di hapus')">Delete</button>
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
                      <a class="page-link" href="{{ url('pos/paket?search='.$search.'&pagination='.($page_now-1)) }}" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                    </li>
                    @for ($i = 1; $i <= $count; $i++) <li class="page-item {{ $i==$page_now ? 'active' : '' }}">
                      <a class="page-link" href="{{ url('pos/paket?search='.$search.'&pagination='.$i) }}">{{ $i }}</a>
                      </li>
                      @endfor
                      <li class="ml-3 page-item {{ $page_now==$count ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ url('pos/paket?search='.$search.'&pagination='.($page_now+1)) }}"><i class="fas fa-chevron-right"></i></a>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.select2-item').select2();
  });
</script>
@endsection