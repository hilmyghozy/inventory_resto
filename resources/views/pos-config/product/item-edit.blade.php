@extends('dashboard.layout')

@section('page title','Edit Item Produk Management')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg">
              
              {{-- <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">

                </div>
                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">

                </div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                  
                </div>
              </div> --}}
                <div class="card bg-white">
                    <div class="container">
                    
                        @foreach ($dataitem as $item)
                          <form action="{{ url('pos/item/updateProcess') }}" method="POST">
                            @csrf 
                            <div class="form-row mt-3">
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault02">Nama Item</label>
                                <input type="hidden" name="id_item" value="{{ $item->id_item }}" required>
                                <input type="text" class="form-control" id="validationDefault02" value="{{ $item->nama_item }}" placeholder="Nama Item" name="nama_item" required>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault03">Kategori</label>
                                <select class="custom-select" id="validationDefault03" name="id_kategori" required>
                                @foreach ($datakategori as $datak)
                                    <option value="{{ $datak->id_kategori }}" {{ $datak->id_kategori==$item->id_kategori ? 'selected' : null }}>{{ $datak->nama_kategori }}</option>
                                @endforeach
                                </select>
                              </div>
                              <div class="col-md-12 mb-3">
                                <label for="validationDefault04">Store</label>
                                <select class="custom-select" id="validationDefault04" name="id_store" required>
                                    @foreach ($datastore as $datas)
                                        <option value="{{ $datas->id_store }}" {{ $datas->id_store==$item->id_store ? 'selected' : null }}>{{ $datas->nama_store }}</option>
                                    @endforeach
                                </select>
                              </div>
                              <div class="col-md-12">
                                <div class="row">
                                  <div class="col-md-4 mb-3">
                                  <label for="validationDefault05">Harga</label>
                                  <input type="number" class="form-control" value="{{ $item->harga }}" oninput="updateHarga()" id="validationDefault05" placeholder="Harga" name="harga" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                  <label for="validationDefault06">Pajak </label><small> (Nominal)</small>
                                  <input type="number" class="form-control" value="{{ $item->pajak }}" oninput="updatePajak()" id="validationDefault06" placeholder="Pajak" name="pajak" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                  <label for="validationDefault07">Harga Jual</label>
                                  <input type="text" class="form-control" value="{{ $item->harga_jual }}" id="validationDefault07" value="0" name="harga_jual" readonly>
                                </div>
                               </div>
                              </div>
                               <div class="col-md-12">
                                <div class="row">
                                  <div class="col-md-4 mb-3">
                                    <label for="validationDefault08">Third Party </label><small> (Nominal)</small>
                                    <input type="number" class="form-control" oninput="updateThirdParty()" id="validationDefault08" placeholder="ThirdParty" value="0" required>
                                  </div>
                                  <div class="col-md-4 mb-3">
                                    <label for="validationDefault10">Pajak Third Party</label><small> (Nominal)</small>
                                    <input type="number" class="form-control" oninput="updatePajakTP()" id="validationDefault10" placeholder="Pajak Third Party" value="0" required>
                                  </div>
                                  <div class="col-md-4 mb-3">
                                    <label for="validationDefault09">Harga Third Party </label><small> (Nominal)</small>
                                    <input type="number" readonly class="form-control" value="{{ $item->thirdparty }}" oninput="updateThirdParty()" id="validationDefault09" placeholder="thirdparty" name="thirdparty" required>
                                  </div>
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
                        @endforeach
                        
                    </div>
                  </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection

<script type="text/javascript">
const inHarga = document.getElementById('validationDefault05');
    const inPajak = document.getElementById('validationDefault06');
    const inTotal = document.getElementById('validationDefault07');
    const inThird = document.getElementById('validationDefault08');
    const inTotalThirdparty = document.getElementById('validationDefault09');

    var harga = 0;
    var pajak = 0;
    var pajaktp = 0;
    var third = 0;
    var total = 0;
    
    updateTotal();

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
        harga = parseInt($('#validationDefault05').val());
        pajak = parseInt($('#validationDefault06').val());
    }

    function updateThirdparty() {
      totalthidparty = third + pajaktp;
      $('#validationDefault09').val(totalthidparty);
  }

    // $(document).ready(function() {
    //     $('#validationDefault05').DataTable();
    // } );
</script>