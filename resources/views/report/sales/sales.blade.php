@extends('dashboard.layout')

@section('page title','Sales Report Management')

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
            
                        <form action="{{ url('report/sales') }}" method="POST" class="mx-auto">
                            @csrf 
                            <div class="col-md-12">
                              <div class="form-row mt-3">
                                <div class="col-md-3 mb-3">
                                  <label for="validationDefault02">From</label>
                                  <input type="date" class="form-control" id="validationDefault02" name="from" required>
                                </div>
                                <div class="col-md-3 mb-3">
                                  <label for="validationDefault03">To</label>
                                  <input type="date" class="form-control" id="validationDefault03" name="to" required>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-12 mt-2 d-flex">
                              <div class="col-md-3">
                                Group By
                              </div>
                              <div class="col-md-3">
                                Status
                              </div>
                            </div>
                            <div class="col-md-12">
                              <div class="form-row mt-3 ml-4">
                                <div class="col-md-3">
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group_by" id="no_invoice" value="no_invoice" checked>
                                    <label class="form-check-label" for="no_invoice">No. Invoice</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group_by" id="item" value="item">
                                    <label class="form-check-label" for="item">Item</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group_by" id="kategori" value="kategori">
                                    <label class="form-check-label" for="kategori">Kategori</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group_by" id="store" value="store">
                                    <label class="form-check-label" for="store">Store</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group_by" id="diskon" value="diskon">
                                    <label class="form-check-label" for="diskon">Diskon</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="group_by" id="kasir" value="kasir">
                                    <label class="form-check-label" for="kasir">Kasir</label>
                                  </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sort_by" id="all" value="all" checked>
                                    <label class="form-check-label" for="all">All</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sort_by" id="success" value="success">
                                    <label class="form-check-label" for="success">Success</label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sort_by" id="refund" value="refund">
                                    <label class="form-check-label" for="refund">Refund</label>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-12 mt-2">
                              <div class="col-md-3 mb-3">
                                <button type="submit" class="btn btn-block btn-primary mt-4" id="btnBaru">Submit</button>
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
  // document.getElementById('pos_store').DataTable();
  var harga = 0;
  var pajak = 0;
  var total = 0;
  
  updateTotal();

  const inHarga = document.getElementById('validationDefault05');
  const inPajak = document.getElementById('validationDefault06');
  const inTotal = document.getElementById('validationDefault07');

  function updateHarga() {
      harga = parseInt($('#validationDefault05').val());
      updateTotal();
  }

  function updatePajak() {
      pajak = parseInt($('#validationDefault06').val());
      updateTotal();
  }

  function updateTotal() {
      total = harga + pajak;
      $('#validationDefault07').val(total);
  }
  
</script>
@endsection
