@extends('dashboard.layout')

@section('page title','Edit Kategori Produk Management')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg">

                <div class="card bg-white">
                    <div class="container">
                        @foreach ($datakategori as $data)  
                        <form action="{{ url('pos/kategori/updateProcess') }}" method="POST">
                            @csrf 
                            <div class="form-row mt-3">
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault02">Nama Kategori</label>
                                <input type="hidden" class="form-control" id="validationDefault01" placeholder="Name" name="id_kategori" value="{{ $data->id_kategori }}">
                                <input type="text" class="form-control" id="validationDefault02" placeholder="Name" name="nama_kategori" value="{{ $data->nama_kategori }}" required>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault06">Print By</label>
                                <select name="print_by" id="validationDefault06" class="form-control">
                                  <option value="nama" {{ $data->print_by == "nama" ? "selected" : null }}>Nama Printer</option>
                                  <option value="ip" {{ $data->print_by == "ip" ? "selected" : null }}>IP Address Printer</option>
                                </select>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault03">IP Printer 1</label> <small>(Boleh dikosongkan)</small>
                                <input type="text" class="form-control" id="validationDefault03" placeholder="IP Printer 1" name="ip_printer1" value="{{ $data->ip_printer1 }}">
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault04">IP Printer 2</label> <small>(Boleh dikosongkan)</small>
                                <input type="text" class="form-control" id="validationDefault04" placeholder="IP Printer 2" name="ip_printer2" value="{{ $data->ip_printer2 }}">
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault05">IP Printer 3</label> <small>(Boleh dikosongkan)</small>
                                <input type="text" class="form-control" id="validationDefault05" placeholder="IP Printer 3" name="ip_printer3" value="{{ $data->ip_printer3 }}">
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
                                        <button class="btn btn-block btn-primary" id="btnBaru">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endforeach
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

