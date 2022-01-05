@extends('dashboard.layout')

@section('page title','Edit Paket Produk Management')

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

            <form action="{{ url('pos/paket/edit', $datapaket[0]->id_paket) }}" method="POST">
              @csrf
              <div class="form-row mt-3">
                <div class="col-md-6 mb-3">
                  <label for="validationDefault02">Nama Paket</label>
                  <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Paket" name="nama_paket" value="{{ $datapaket[0]->nama_paket }}" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="validationDefault04">Store</label>
                  <select class="custom-select" id="validationDefault04" name="id_store" required>
                    @foreach ($datastore as $datas)
                    <option value="{{ $datas->id_store }}" {{ $datapaket[0]->id_store == $datas->id_store ? "selected" : "" }}>{{ $datas->nama_store }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-row mt-3">
                <div class="col-md-6 mb-3">
                  <label for="validationDefault02">Pajak</label>
                  <input type="number" class="form-control" id="validationDefault02" placeholder="Pajak" name="pajak" value="{{ $datapaket[0]->pajak }}" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="validationDefault04">Harga Jual</label>
                  <input type="number" class="form-control" id="validationDefault02" placeholder="Harga Jual" name="harga_jual" value="{{ $datapaket[0]->harga_jual }}" required>

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
                    <button type="submit" class="btn btn-block btn-primary" id="btnBaru">Update</button>
                  </div>
                </div>
              </div>
            </form>
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