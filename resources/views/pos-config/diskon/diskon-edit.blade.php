@extends('dashboard.layout')

@section('page title','Edit Discount Management')

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
                    
                        @foreach ($datadiskon as $item)
                          <form action="{{ url('pos/discount/updateProcess') }}" method="POST">
                            @csrf 
                            <div class="form-row mt-3">
                                <div class="col-md-6 mb-3">
                                  <label for="validationDefault02">Nama Item</label>
                                <input type="hidden" name="id_voucher" value="{{ $item->id_voucher }}" required>
                                  <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Diskon" name="nama_diskon" value="{{ $item->nama_voucher }}" required>
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
                                          @if (($item->nominal)==0)
                                            <input class="form-check-input" type="radio" name="tipe" id="nominal" value="nominal">
                                          @else
                                            <input class="form-check-input" type="radio" name="tipe" id="nominal" value="nominal" checked>
                                          @endif
                                          <label class="form-check-label" for="nominal">
                                          Nominal
                                          </label>
                                      </div>
                                      <div class="form-check ml-4">
                                        @if (($item->nominal)==0)
                                          <input class="form-check-input" type="radio" name="tipe" id="persen" value="persen" checked>
                                        @else
                                          <input class="form-check-input" type="radio" name="tipe" id="persen" value="persen">
                                        @endif
                                          <label class="form-check-label" for="persen">
                                          Persenan
                                          </label>
                                      </div>
                                  </div>
                                </div>
                                @if (($item->nominal)==0)
                                  <div class="col-md-12 mb-3 nominal selectt d-none">
                                    <label for="validationDefault05">Nominal</label>
                                    <input type="number" class="form-control n_nominal" id="validationDefault05" placeholder="Nominal" name="nominal" min="0" value="{{ $item->nominal }}">
                                  </div>
                                  <div class="col-md-6 mb-3 persen selectt">
                                    <label for="validationDefault06">Persen </label>
                                    <input type="number" class="form-control n_persen" id="validationDefault06"  placeholder="Persen" name="persen" min="0" max="100" value="{{ $item->persen }}">
                                  </div>
                                  <div class="col-md-6 mb-3 persen selectt">
                                    <label for="validationDefault07">Maksimal persen(Nominal)</label>
                                    <input type="number" class="form-control n_persen_max" id="validationDefault07"  placeholder="Maksimal persen" name="maks_persen" min="0" value="{{ $item->maks_persen }}">
                                  </div>
                                @else
                                  <div class="col-md-12 mb-3 nominal selectt">
                                    <label for="validationDefault05">Nominal</label>
                                    <input type="number" class="form-control n_nominal" id="validationDefault05" placeholder="Nominal" name="nominal" min="0" value="{{ $item->nominal }}">
                                  </div>
                                  <div class="col-md-6 mb-3 persen selectt d-none">
                                    <label for="validationDefault06">Persen </label>
                                    <input type="number" class="form-control n_persen" id="validationDefault06"  placeholder="Persen" name="persen" min="0" max="100" value="{{ $item->persen }}">
                                  </div>
                                  <div class="col-md-6 mb-3 persen selectt d-none">
                                    <label for="validationDefault07">Maksimal persen(Nominal)</label>
                                    <input type="number" class="form-control n_persen_max" id="validationDefault07"  placeholder="Maksimal persen" name="maks_persen" min="0" value="{{ $item->maks_persen }}">
                                  </div>
                                @endif
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