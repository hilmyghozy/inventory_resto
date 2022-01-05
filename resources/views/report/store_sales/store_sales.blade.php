@extends('dashboard.layout')

@section('page title','Sales Store Management')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg">
                <div class="card bg-white">
                    <div class="container pt-3">
                        @if (session('status1'))
                            <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status1') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @endif
            
                        <form action="{{ url('report/store_sales') }}" method="POST" class="mx-auto">
                            @csrf 
                            <div class="col-md-12">
                              <div class="form-row mt-3">
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault02">Tanggal</label>
                                    <input type="date" class="form-control" id="validationDefault02" name="date" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault03">Store</label>
                                    <select class="custom-select form-control" id="validationDefault03" name="id_store" required>
                                        <option value="all">All</option>
                                        @foreach ($datastore as $datas)
                                            <option value="{{ $datas->id_store }}">{{ $datas->nama_store }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="validationDefault04">Status</label>
                                    <select class="custom-select form-control" id="validationDefault04" name="status" required>
                                        <option value="all">All</option>
                                        <option value="success">Success</option>
                                        <option value="refund">Refund</option>
                                    </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-9"></div>
                                    <div class="col-md-3 mb-3">
                                        <button type="submit" class="btn btn-block btn-primary mr-2" id="btnBaru">Submit</button>
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
@yield('script');

@section('script')
<script type="text/javascript">

</script>
@endsection
