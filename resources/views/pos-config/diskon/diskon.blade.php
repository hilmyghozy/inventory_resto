@extends('dashboard.layout')

@section('page title','Discount Management')

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
            
                        <form action="{{ url('pos/discount/add') }}" method="POST">
                            @csrf 
                            <div class="form-row mt-3">
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault02">Nama Item</label>
                                <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Diskon" name="nama_diskon" required>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault04">Store</label>
                                <select class="custom-select" id="validationDefault04" name="id_store" required>
                                    @foreach ($datastore as $datas)
                                        <option value="{{ $datas->id_store }}">{{ $datas->nama_store }}</option>
                                    @endforeach
                                </select>
                              </div>
                              <div class="col-md-12 mb-3">
                                  <span>Pilih tipe discount</span>
                                <div class="form-group row ml-2 mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tipe" id="nominal" value="1" checked>
                                        <label class="form-check-label" for="nominal">
                                        Nominal
                                        </label>
                                    </div>
                                    <div class="form-check ml-4">
                                        <input class="form-check-input" type="radio" name="tipe" id="persen" value="2">
                                        <label class="form-check-label" for="persen">
                                        Persentase
                                        </label>
                                    </div>
                                </div>
                              </div>
                              <div class="col-md-12 mb-3 nominal selectt">
                                <label for="validationDefault05">Nominal</label>
                                <input type="number" class="form-control n_nominal" id="validationDefault05" placeholder="Nominal" name="nominal" min="0">
                              </div>
                              <div class="col-md-6 mb-3 persen selectt d-none">
                                <label for="validationDefault06">Persen </label>
                                <input type="number" class="form-control n_persen" id="validationDefault06"  placeholder="Persen" name="persen" min="0" max="100">
                              </div>
                              <div class="col-md-6 mb-3 persen selectt d-none">
                                <label for="validationDefault07">Maksimal persen(Nominal)</label>
                                <input type="number" class="form-control n_persen_max" id="validationDefault07"  placeholder="Nominal" name="maks_persen" min="0">
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
                                <form action="{{ url('pos/discount') }}" action="get">
                                  <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="" placeholder="Search">
                                    {{-- {{ ($search) }} --}}
                                    <div class="input-group-btn">
                                      <button class="btn btn-primary h-100" id="id-btn-search"><i class="fas fa-search"></i></button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                            <div class="card-body p-0">
                              <div class="table-responsive">
                                <table id="pos_discount" class="table table-hover text-center" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Diskon</th>
                                            <th>Store</th>
                                            <th>Nominal</th>
                                            <th>Persen</th>
                                            <th>Maksimal</th>
                                            <th>Status</th>
                                            <th>Setting</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datadiskon as $data)
                                        <tr>
                                            <td>{{$start++}}</td>
                                            <td>{{$data->nama_voucher}}</td>
                                            <td>{{$data->nama_store}}</td>
                                            <td>{{number_format($data->nominal,0,",",".")}}</td>
                                            <td>
                                              @if ($data->persen)
                                                {{$data->persen}} %
                                              @else
                                                0
                                              @endif
                                            </td>
                                            <td>{{number_format($data->maks_persen,0,",",".")}}</td>
                                            <td>
                                              @if ($data->is_used==0)
                                                <span class="badge badge-pill badge-primary">Tersedia</span>
                                              @else
                                                <span class="badge badge-pill badge-danger">Sudah Terpakai</span>
                                              @endif
                                              
                                            </td>
                                            <td>
                                                <div class="row mt-2">
                                                  <div class="col-lg-6">
                                                    <a href="{{ url('pos/discount/edit', $data->id_voucher) }}" class="btn btn-block btn-warning" style="background-color: #ffc107;color: #fff"> Edit</a>
                                                    {{-- <button class="btn btn-block btn-warning"> Edit</button> --}}
                                                  </div>
                                                  <div class="col-lg-6" >
                                                      <form action="{{ url('pos/discount/destroy', $data->id_voucher) }}" method="post">
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
                                    <a class="page-link" href="{{ url('pos/discount?search='.$search.'&pagination='.($page_now-1)) }}" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                  </li>
                                  @for ($i = 1; $i <= $count; $i++)
                                    <li class="page-item {{ $i==$page_now ? 'active' : '' }}">
                                      <a class="page-link" href="{{ url('pos/discount?search='.$search.'&pagination='.$i) }}">{{ $i }}</a>
                                    </li>
                                  @endfor
                                  <li class="ml-3 page-item {{ $page_now==$count ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ url('pos/discount?search='.$search.'&pagination='.($page_now+1)) }}"><i class="fas fa-chevron-right"></i></a>
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
    $('input[type="radio"]').click(function() { 
        var inputValue = $(this).attr("value"); 
        if(inputValue=="persen"){
            $(".n_nominal").val('');
            $(".n_nominal").prop('required',false);
            $(".n_persen").prop('required',true);
            $(".n_persen_max").prop('required',true);
            $(".persen.selectt").removeClass("d-none");
            $(".nominal.selectt").addClass("d-none");
        }else{
            $(".n_persen").val('');
            $(".n_persen_max").val('');
            $(".n_nominal").prop('required',true);
            $(".n_persen").prop('required',false);
            $(".n_persen_max").prop('required',false);
            $(".nominal.selectt").removeClass("d-none");
            $(".persen.selectt").addClass("d-none");
        }
    }); 

</script>
@endsection
