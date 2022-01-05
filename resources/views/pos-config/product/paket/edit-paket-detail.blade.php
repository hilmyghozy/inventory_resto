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


                        <form action="{{ url('/pos/paket/kelola/'.$datapaketdetail[0]->id_paket.'/edit/'.$datapaketdetail[0]->id_paket_detail) }}" method="POST">
                            @csrf
                            <div class="form-row mt-3">
                                <div class="col-md-6 mb-3">
                                    <label for="validationDefault02">Nama Opsi Menu :</label>
                                    <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Paket" name="nama_paket_detail" value="{{ $datapaketdetail[0]->nama_paket_detail }}" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12 mb-3">
                                    <label for="validationDefault02">Pilih Opsi Menu :
                                    </label>
                                    <select class="custom-select select2-item" id="validationDefault03" name="opsi_menu[]" multiple="multiple" required>
                                        <option value="">Pilih opsi menu :</option>
                                        @foreach ($dataitem as $item)
                                        <option value="{{ $item->id_item }}" {{  (in_array( $item->id_item,$id_opsi_menu) ? "selected" : "") }}>{{ $item->nama_item }}</option>
                                        @endforeach
                                    </select>
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