@extends('dashboard.layout')

@section('page title','Item Produk Management')

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
            
                        <form action="{{ url('pos/kategori/additional-menu') }}" method="POST">
                            @csrf 
                            <div class="form-row mt-3">
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault02">Nama Item</label>
                                <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Item" name="nama_item" required>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault03">Kategori</label>
                                <select class="custom-select" id="validationDefault03" name="id_kategori" required>
                                @foreach ($datakategori as $datak)
                                    <option value="{{ $datak->id_kategori }}">{{ $datak->nama_kategori }}</option>
                                @endforeach
                                </select>
                              </div>
                              <div class="col-md-12 mb-3">
                                <label for="validationDefault04">Store</label>
                                <select class="custom-select" id="validationDefault04" name="id_store" required>
                                    @foreach ($datastore as $datas)
                                        <option value="{{ $datas->id_store }}">{{ $datas->nama_store }}</option>
                                    @endforeach
                                </select>
                              </div>
                              <div class="col-md-12">
                                <div class="row">
                                  <div class="col-md-4 mb-3">
                                    <label for="validationDefault05">Harga</label>
                                    <input type="number" class="form-control" oninput="updateHarga()" id="validationDefault05" placeholder="Harga" name="harga" required>
                                  </div>
                                </div>
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
                                <form action="{{ url('pos/item') }}" action="get">
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
                                            <th>Nama Additional Menu</th>
                                            <th>Kategori</th>
                                            <th>Store</th>
                                            <th>Harga Jual</th>
                                            <th>Setting</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataitem as $data)
                                        <tr>
                                            <td>{{$start++}}</td>
                                            <td>{{$data->nama_additional_menu}}</td>
                                            <td>{{$data->nama_kategori}}</td>
                                            <td>{{$data->nama_store}}</td>
                                            <td>{{number_format($data->harga,0,",",".")}}</td>
                                            <td>
                                                <div class="row mt-2">
                                                  <div class="col-lg-6">
                                                    <a href="{{ url('pos/kategori/additional-menu', $data->id) }}" class="text-white btn btn-block btn-warning" style="background-color: #ffc107;color: #212529">
                                                      <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                  </div>
                                                  <div class="col-lg-6" >
                                                      <form action="{{ url('pos/kategori/delete-additional-menu', $data->id) }}" method="post">
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

@section('script')
<script type="text/javascript">
  // document.getElementById('pos_store').DataTable();
  var harga = 0;
  var pajak = 0;
  var pajaktp = 0;
  var third = 0;
  var total = 0;
  
  updateTotal();

  const inHarga = document.getElementById('validationDefault05');
  const inPajak = document.getElementById('validationDefault06');
  const inThrid = document.getElementById('validationDefault08');
  const inTotal = document.getElementById('validationDefault07');
  const inTotalThirdparty = document.getElementById('validationDefault09');
  const inPajakTP = document.getElementById('validationDefault10');

  function updateHarga() {
      harga = parseInt($('#validationDefault05').val());
      updateTotal();
  }

  function updatePajak() {
      pajak = parseInt($('#validationDefault06').val());
      updateTotal();
  }
  function updatePajakTP() {
      pajaktp = parseInt($('#validationDefault10').val());
      updateThirdparty();
  }
  function updateThirdParty() {
      third = parseInt($('#validationDefault08').val());
      updateThirdparty();
  }

  function updateTotal() {
      total = harga + pajak;
      $('#validationDefault07').val(total);
  }

  function updateThirdparty() {
      totalthidparty = third + pajaktp;
      $('#validationDefault09').val(totalthidparty);
  }
  
</script>
@endsection
