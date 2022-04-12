@extends('dashboard.layout')

@section('page title','Edit Item Produk Management')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg">
                <div class="card bg-white">
                    <div class="container">
                    
                        @foreach ($data as $item)
                          <form action="{{ url('pos/item-type') }}" method="POST">
                            @csrf 
                            @method('PUT')
                            <div class="form-row mt-3">
                              <div class="col-md-6 mb-3">
                                <label for="nama_size">Nama Size</label>
                                <input type="hidden" name="id" value="{{ $item->id_size }}" required>
                                <input type="text" class="form-control" id="nama_size" value="{{ $item->nama_size }}" placeholder="Nama Size" name="nama_size" required>
                              </div>
                              <div class="col-md-12 mb-3">
                                <label for="id_store">Store</label>
                                <select class="custom-select" id="id_store" name="id_store" required>
                                    @foreach ($datastore as $datas)
                                        <option value="{{ $datas->id_store }}" {{ $datas->id_store == $item->id_store ? 'selected' : null }}>{{ $datas->nama_store }}</option>
                                    @endforeach
                                </select>
                              </div>
                              <div class="col-md-12">
                                <div class="row">
                                  <div class="col-md-4 mb-3">
                                  <label for="harga">Harga</label>
                                  <input type="number" class="form-control" value="{{ $item->harga }}" placeholder="Harga" id="harga" name="harga" required>
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