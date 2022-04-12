@extends('dashboard.layout')

@section('page title','Edit Item Produk Management')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg">
                <div class="card bg-white">
                    <div class="container">
                    
                        @foreach ($dataitem as $item)
                          <form action="{{ url('pos/kategori/update-additional-menu') }}" method="POST">
                            @csrf 
                            <div class="form-row mt-3">
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault02">Nama Additional Menu</label>
                                <input type="hidden" name="id" value="{{ $item->id }}" required>
                                <input type="text" class="form-control" id="validationDefault02" value="{{ $item->nama_additional_menu }}" placeholder="Nama Additional Menu" name="nama_additional_menu" required>
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