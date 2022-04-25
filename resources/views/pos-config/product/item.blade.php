@extends('dashboard.layout')

@section('page title','Item Produk Management')

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
            
                        <form action="{{ url('pos/item/add') }}" method="POST">
                            @csrf 
                            <div class="form-row mt-3">
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault02">Nama Item</label>
                                <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Item" name="nama_item" required>
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault03">Kategori</label>
                                <select class="custom-select" id="validationDefault03" name="id_kategori" required>
                                @foreach ($datakategori as $datak)
                                    <option value="{{ $datak->id_kategori }}">{{ $datak->nama_kategori }}</option>
                                @endforeach
                                </select>
                              </div>
                              <div class="col-md-12 mb-3">
                                <label for="validationDefault04">Store</label>
                                <select class="custom-select" id="validationDefault04" name="id_store" required>
                                    @foreach ($datastore as $datas)
                                        <option value="{{ $datas->id_store }}">{{ $datas->nama_store }}</option>
                                    @endforeach
                                </select>
                              </div>
                              <div class="col-md-12">
                                <div class="row">
                                  <div class="col-md-4 mb-3">
                                    <label for="validationDefault05">Harga</label>
                                    <input type="number" class="form-control" oninput="updateHarga()" id="validationDefault05" placeholder="Harga" name="harga" required>
                                  </div>
                                  <div class="col-md-4 mb-3">
                                    <label for="validationDefault06">Pajak Harga Jual</label><small> (Nominal)</small>
                                    <input type="number" class="form-control" oninput="updatePajak()" id="validationDefault06" placeholder="Pajak" name="pajak" value="0" required>
                                  </div>
                                  
                                  <div class="col-md-4 mb-3">
                                    <label for="validationDefault07">Harga Jual</label>
                                    <input type="text" class="form-control" id="validationDefault07" value="0" name="harga_jual" readonly>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12">
                                <div class="row">
                                  <div class="col-md-4 mb-3">
                                    <label for="validationDefault08">Third Party </label><small> (Nominal)</small>
                                    <input type="number" class="form-control" oninput="updateThirdParty()" id="validationDefault08" placeholder="ThirdParty" value="0" name="harga_thirdparty" required>
                                  </div>
                                <div class="col-md-4 mb-3">
                                  <label for="validationDefault10">Pajak Third Party</label><small> (Nominal)</small>
                                  <input type="number" class="form-control" oninput="updatePajakTP()" id="validationDefault10" placeholder="Pajak Third Party" value="0" name="pajak_thirdparty" required>
                                </div>
                                  <div class="col-md-4 mb-3">
                                    <label for="validationDefault09">Harga Third Party</label>
                                    <input type="text" class="form-control" id="validationDefault09" value="0" name="thirdparty" readonly>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12 item-types">
                              </div>
                              <div class="col-md-12 my-2">
                                <button type="button" class="btn btn-outline-primary" onclick="tambahItemType()">
                                  Tambah Item Type <span aria-hidden="true"><i class="fas fa-plus"></i></span>
                                </button>
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
                    </div>
                  </div>

                  <div class="card card-primary card-outline">
                    <div class="row">
                        <div class="col-12">
                          <div class="card">
                            <div class="card-header">
                              <h4></h4>
                              <div class="card-header-form">
                                <form action="{{ url('pos/item') }}" action="get">
                                  <div class="input-group">
                                    <input type="text" class="form-control" name="search" value="{{ ($search) }}" placeholder="Search">
                                    <div class="input-group-btn">
                                      <button class="btn btn-primary h-100" id="id-btn-search"><i class="fas fa-search"></i></button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                            <div class="card-body p-0">
                              <div class="table-responsive">
                                <table id="pos_store" class="table table-hover text-center" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Item</th>
                                            <th>Kategori</th>
                                            <th>Store</th>
                                            <th>Thrid Party</th>
                                            <th>Harga Jual</th>
                                            <th>Setting</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataitem as $data)
                                        <tr>
                                            <td>{{$start++}}</td>
                                            <td>{{$data->nama_item}}</td>
                                            <td>{{$data->nama_kategori}}</td>
                                            <td>{{$data->nama_store}}</td>
                                            <td>{{number_format($data->thirdparty,0,",",".")}}</td>
                                            <td>{{number_format($data->harga_jual,0,",",".")}}</td>
                                            <td>
                                                <div class="row mt-2">
                                                  <div class="col-lg-6">
                                                    <a href="{{ url('pos/item/edit', $data->id_item) }}" class="text-white btn btn-block btn-warning" style="background-color: #ffc107;color: #212529">
                                                      <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    {{-- <button class="btn btn-block btn-warning"> Edit</button> --}}
                                                  </div>
                                                  <div class="col-lg-6" >
                                                      <form action="{{ url('pos/item/destroy', $data->id_item) }}" method="post">
                                                      @csrf 
                                                      @method('delete')
                                                      <button type="submit" class="btn btn-block btn-danger" id="btnBaru"  onclick="return confirm('Yakin data akan di hapus')">
                                                        <i class="fas fa-trash"></i>
                                                      </button> 
                                                      </form>
                                                  </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-lg-6">
                              <nav class="d-inline-block">
                                <ul class="pagination mb-0">
                                  <li class="page-item mr-3 {{ $page_now==1 ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ url('pos/item?search='.$search.'&pagination='.($page_now-1)) }}" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                  </li>
                                  @for ($i = 1; $i <= $count; $i++)
                                    <li class="page-item {{ $i==$page_now ? 'active' : '' }}">
                                      <a class="page-link" href="{{ url('pos/item?search='.$search.'&pagination='.$i) }}">{{ $i }}</a>
                                    </li>
                                  @endfor
                                  <li class="ml-3 page-item {{ $page_now==$count ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ url('pos/item?search='.$search.'&pagination='.($page_now+1)) }}"><i class="fas fa-chevron-right"></i></a>
                                  </li>
                                </ul>
                              </nav>
                            </div>
                        </div>
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
  var pajaktp = 0;
  var third = 0;
  var total = 0;
  
  updateTotal();

  const inHarga = document.getElementById('validationDefault05');
  const inPajak = document.getElementById('validationDefault06');
  const inThrid = document.getElementById('validationDefault08');
  const inTotal = document.getElementById('validationDefault07');
  const inTotalThirdparty = document.getElementById('validationDefault09');
  const inPajakTP = document.getElementById('validationDefault10');

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
  }

  function updateThirdparty() {
      totalthidparty = third + pajaktp;
      $('#validationDefault09').val(totalthidparty);
  }
  function updateHargaItemSize () {
    $('input[name*="harga_item_size"]').on('input', function (change) {
      var pajak = $(this).parent().parent().find('input[name*="pajak_item_size"]').val()
      var harga = change.target.valueAsNumber
      var harga_jual = Number(pajak) + harga
      $(this).parent().parent().find('input[name*="harga_jual_item_size"]').val(harga_jual)
    })
    $('input[name*="pajak_item_size"]').on('input', function (change) {
      var harga = $(this).parent().parent().find('input[name*="harga_item_size"]').val()
      var pajak = change.target.valueAsNumber
      var harga_jual = pajak + Number(harga)
      $(this).parent().parent().find('input[name*="harga_jual_item_size"]').val(harga_jual)
    })
    $('input[name*="harga_thirdparty_item_size"]').on('input', function (change) {
      var pajak = $(this).parent().parent().find('input[name*="pajak_thirdparty_item_size"]').val()
      var harga = change.target.valueAsNumber
      var harga_jual = Number(pajak) + harga
      $(this).parent().parent().find('input[name*="harga_jual_thirdparty_item_size"]').val(harga_jual)
    })
    $('input[name*="pajak_thirdparty_item_size"]').on('input', function (change) {
      var harga = $(this).parent().parent().find('input[name*="harga_thirdparty_item_size"]').val()
      var pajak = change.target.valueAsNumber
      var harga_jual = pajak + Number(harga)
      $(this).parent().parent().find('input[name*="harga_jual_thirdparty_item_size"]').val(harga_jual)
    })
  }
  var item_types = []
  function tambahItemType() {
    var item_type = item_types.length
    var item_size = 0
    if (item_types.length > 0) {
      item_type = item_types[item_type - 1].item_type + 1
    }
    var data_item_type = {
      item_type: item_type,
      item_sizes: [
        {
          item_size: item_size
        }
      ]
    }
    item_types.push(data_item_type)
    $('div.item-types').append(templateItemType(data_item_type.item_type, item_size))
    updateHargaItemSize()
    disableBaseHarga()
  }

  function hapusItemType(item_type) {
    $(`div.item-type-${item_type}`).remove()
    $(`div.item-sizes-${item_type}`).remove()
    disableBaseHarga()
  }

  function templateItemType (item_type, item_size) {
    return `
      <div class="row item-type-${item_type}">
        <div class="col-md-8 mb-3">
          <label for="nama_item_type${item_type}">Item Type </label>
          <input type="text" id="nama_item_type${item_type}" class="form-control" placeholder="Nama Item Type" name="nama_item_type[${item_type}]" required>
        </div>
        <div class="col-md-4 mb-3 align-self-end">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-outline-primary" onclick="tambahItemType()">
              Tambah Item Type <span aria-hidden="true"><i class="fas fa-plus"></i></span>
            </button>
            <button type="button" class="btn btn-danger" onclick="hapusItemType(${item_type})">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="item-sizes-${item_type}">
        ${templateItemSize(item_type, item_size)}
      </div>
    `
  }

  function tambahItemSize(item_type) {
    let type = item_types.filter( function (value, index) {
      return value.item_type == item_type
    })
    let item_sizes = type[0].item_sizes
    let item_size = item_sizes.length
    item_types = item_types.map( function (value) {
      if (value.item_type == item_type) {
        let data_item_size = {
          item_size: item_size
        }
        value.item_sizes.push(data_item_size)
      }
      return value
    })
    $(`div.item-sizes-${item_type}`).append(templateItemSize(type[0].item_type, item_size))
    updateHargaItemSize()
  }

  function hapusItemSize(item_type, item_size) {
    $(`div.item-size-${item_type}-${item_size}`).remove()
  }

  var item_sizes = 0
  $('#btnTambahItemSize').on('click', function () {
    item_sizes += 1;
    $('.item-sizes').append(templateItemSize(item_sizes))
  })

  function templateItemSize (item_type, item_size) {
    return `
      <div class="item-size-${item_type}-${item_size}">
        <div class="row">
          <div class="col-8 mb-3">
            <label for="nama_item_size${item_size}">Item Size</label>
            <input type="text" class="form-control" placeholder="Nama Item Size" aria-label="Nama Item Size" aria-describedby="basic-addon2" id="nama_item_size${item_size}" name="nama_item_size[${item_type}][]">
          </div>
          <div class="col-4 mb-3 align-self-end">
            <button type="button" class="btn btn-outline-primary" onclick="tambahItemSize(${item_type})">
              Tambah Item Size <span aria-hidden="true"><i class="fas fa-plus"></i></span>
            </button>
            <button type="button" class="btn btn-danger" onclick="hapusItemSize(${item_type},${item_size})">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="harga_item_size${item_size}">Harga </label> <small> (Nominal)</small>
            <input type="number" id="harga_item_size${item_size}" class="form-control" placeholder="Nama Item Size" name="harga_item_size[${item_type}][]" required>
          </div>
          <div class="col-md-4 mb-3">
            <label for="pajak_item_size${item_size}">Pajak</label><small> (Nominal)</small>
            <input type="number" class="form-control" value="0" required id="pajak_item_size${item_size}" name="pajak_item_size[${item_type}][]">
          </div>
          <div class="col-md-4 mb-3">
            <label for="harga_jual_item_size${item_size}">Harga Jual</label><small> (Nominal)</small>
            <input type="number" disabled class="form-control" placeholder="Harga Item Size" value="0" required id="harga_jual_item_size${item_size}" name="harga_jual_item_size[${item_type}][]">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="harga_thirdparty_item_size${item_size}">Harga </label> <small> (Nominal)</small>
            <input type="number" id="harga_thirdparty_item_size${item_size}" class="form-control" placeholder="Nama Item Size" name="harga_thirdparty_item_size[${item_type}][]" required>
          </div>
          <div class="col-md-4 mb-3">
            <label for="pajak_thirdparty_item_size${item_size}">Pajak</label><small> (Nominal)</small>
            <input type="number" class="form-control" value="0" required id="pajak_thirdparty_item_size${item_size}" name="pajak_thirdparty_item_size[${item_type}][]">
          </div>
          <div class="col-md-4 mb-3">
            <label for="harga_jual_thirdparty_item_size${item_size}">Harga Jual</label><small> (Nominal)</small>
            <input type="number" disabled class="form-control" placeholder="Harga Item Size" value="0" required id="harga_jual_thirdparty_item_size${item_size}" name="harga_jual_thirdparty_item_size[${item_type}][]">
          </div>
        </div>
      </div>
    `
  }

  function templateItemSizess (key) {
    return `
      <div class="row item-type">
        <div class="col-md-6 mb-3">
          <label for="validationDefault_size${key}">Nama Item Size </label>
          <input type="text" id="validationDefault_size${key}" class="form-control" placeholder="Nama Item Size" name="nama_item_size[]" required>
        </div>
        <div class="col-md-4 mb-3">
          <label for="validationDefault_sizePrice${key}">Harga</label><small> (Nominal)</small>
          <input type="number" class="form-control" placeholder="Harga Item Size" value="0" required id="validationDefault_sizePrice${key}" name="harga_item_size[]">
        </div>
        <div class="col-md-2 mb-3 align-self-center">
          <button type="submit" class="btn btn-danger" onClick="hapusItemSize(this)">
            <i class="fas fa-trash"></i>
          </button>
        </div>
      </div>
    `
  }

  function disableBaseHarga () {
    var itemTypes = $('div[class*="row item-type"]')
    var input = 'input[name="harga"], input[name="pajak"], input[name="harga_thirdparty"], input[name="pajak_thirdparty"]'
    $(input).prop('disabled', false)
    if (itemTypes.length > 0) $(input).val(0).prop('disabled', true)
  }

  // function hapusItemSize(event) {
  //   $(event).parents('.item-type').remove()
  // }
</script>
@endsection
