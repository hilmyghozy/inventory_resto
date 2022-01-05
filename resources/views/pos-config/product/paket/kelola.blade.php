@extends('dashboard.layout')

@section('page title','Kelola Detail Paket Produk Management')

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

            <form>
              <div class="form-row mt-3">
                <div class="col-md-6 mb-3">
                  <label for="validationDefault02">Nama Paket</label>
                  <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Paket" name="nama_paket" value="{{ $datapaket[0]->nama_paket }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="validationDefault04">Store</label>
                  <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Paket" name="nama_paket" value="{{ $datapaket[0]->nama_store }}" readonly>

                </div>
              </div>
              <div class="form-row mt-3">
                <div class="col-md-6 mb-3">
                  <label for="validationDefault02">Pajak</label>
                  <input type="number" class="form-control" id="validationDefault02" placeholder="Pajak" name="pajak" value="{{ $datapaket[0]->pajak }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="validationDefault04">Harga Jual</label>
                  <input type="number" class="form-control" id="validationDefault02" placeholder="Harga Jual" name="harga_jual" value="{{ $datapaket[0]->harga_jual }}" readonly>

                </div>
              </div>

              <!-- <div class="form-row">

                <div class="col-md-12 mb-3">
                  <div class="row">
                    <div class="col-md-6">
                      <h5>
                        Menu item Paket :
                      </h5>
                    </div>
                    <div class="col-md-2  ">
                      <button type="submit" class="btn btn-block btn-primary" id="btnBaru">+</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <div class="col-md-12 mb-3">
                    <div class="row">
                      <div class="col-lg-1">
                        Menu 1 :
                      </div>
                      <div class="col-lg-8">
                        <select class="custom-select select2-item" id="validationDefault03" name="opsi_menu[]" multiple="multiple" required>
                          <option value="">Pilih opsi menu :</option>
                          @foreach ($dataitem as $item)
                          <option value="{{ $item->id_item }}">{{ $item->nama_item }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-lg-2 mt-2 mt-sm-0">
                        <button type="submit" class="btn btn-block btn-danger" id="btnTambahItem">x</button>

                      </div>
                    </div>

                  </div>
                </div>
              </div> -->
            </form>

            <form action="{{ url('pos/paket/kelola/'.$datapaket[0]->id_paket.'/add-detail') }}" method="POST">
              @csrf
              <div class="form-row mt-3">
                <div class="col-md-6 mb-3">
                  <label for="validationDefault02">Nama Opsi Menu :</label>
                  <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Paket" name="nama_paket_detail" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12 mb-3">
                  <label for="validationDefault02">Pilih Opsi Menu :


                  </label>
                  <select class="custom-select select2-item" id="validationDefault03" name="opsi_menu[]" multiple="multiple" required>
                    <option value="">Pilih opsi menu :</option>
                    @foreach ($dataitem as $item)
                    <option value="{{ $item->id_item }}">{{ $item->nama_item }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <!-- <div class="form-row">

                <div class="col-md-12 mb-3">
                  <div class="row">
                    <div class="col-md-6">
                      <h5>
                        Menu item Paket :
                      </h5>
                    </div>
                    <div class="col-md-2  ">
                      <button type="submit" class="btn btn-block btn-primary" id="btnBaru">+</button>
                    </div>
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <div class="col-md-12 mb-3">
                    <div class="row">
                      <div class="col-lg-1">
                        Menu 1 :
                      </div>
                      <div class="col-lg-8">
                        <select class="custom-select select2-item" id="validationDefault03" name="opsi_menu[]" multiple="multiple" required>
                          <option value="">Pilih opsi menu :</option>
                          @foreach ($dataitem as $item)
                          <option value="{{ $item->id_item }}">{{ $item->nama_item }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-lg-2 mt-2 mt-sm-0">
                        <button type="submit" class="btn btn-block btn-danger" id="btnTambahItem">x</button>

                      </div>
                    </div>

                  </div>
                </div>
              </div> -->

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
                        <input type="text" class="form-control" name="search" value="" placeholder="Search">
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
                          <th>Nama Opsi Menu</th>
                          <!-- <th>Nama Kategori</th> -->
                          <th>Opsi Menu</th>
                          <th>Setting</th>
                        </tr>
                      </thead>

                      <?php

                      $start = 1;
                      ?>
                      <tbody id="body-table">
                        @foreach ($datapaketdetail as $data)
                        <tr>
                          <td>{{$start++}}</td>
                          <td>{{$data->nama_paket_detail}}</td>
                          <!-- <td>$data->nama_kategori</td> -->
                          <td>{{$data->opsi_menu}}</td>
                          <td>
                            <div class="row mt-2">
                              <div class="col-lg-4">
                                <a href="{{ url('/pos/paket/kelola/'.$data->id_paket.'/edit/'.$data->id_paket_detail) }}" class="btn btn-warning" style="background-color: #ffc107;color: #212529"> Edit</a>
                                {{-- <button class="btn btn-warning"> Edit</button> --}}
                              </div>
                              <div class="col-lg-4">
                                <form action="{{ url('/pos/paket/kelola/'.$data->id_paket.'/destroy/'.$data->id_paket_detail) }}" method="post">
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