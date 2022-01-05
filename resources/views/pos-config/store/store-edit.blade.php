@extends('dashboard.layout')

@section('page title','Edit Store Management')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg">

                <div class="card bg-white">
                    <div class="container">
                        @foreach ($datastore as $data)  
                        <form action="{{ url('pos/store/updateProcess') }}" method="POST">
                            @csrf 
                            <div class="form-row mt-3">
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault00">Kode Store</label>
                                <input type="text" class="form-control" id="validationDefault00" placeholder="Name" name="kode_store" value="{{ $data->kode_store }}" required>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault02">Nama Store</label>
                                <input type="hidden" class="form-control" id="validationDefault01" placeholder="Name" name="id_store" value="{{ $data->id_store }}">
                                <input type="text" class="form-control" id="validationDefault02" placeholder="Name" name="nama_store" value="{{ $data->nama_store }}" required>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault03">Jumlah Meja</label>
                                <input type="number" min="0" class="form-control" id="validationDefault03" placeholder="Jumlah Meja" name="jumlah_meja" value="{{ $data->jumlah_meja }}" required>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault04">Printer Kasir</label>
                                <input type="text" class="form-control" id="validationDefault04" placeholder="Printer Kasir" name="print_kasir" value="{{ $data->print_kasir }}" required>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#pos-store').DataTable();
    } );

    function edit_store(){
        alert "wowo";
    }

    $(document).ready( function () {
        var x = $('#validationDefault02').(val);
        console.log(x);
    });

    // $('#btnBaru').onclick(function(){
    //     alert "uy";
    // });
    $(document).on('click', '#btnBaru', function(){
        
    });
</script>
