@extends('dashboard.layout')

@section('page title','Edit Item Produk Management')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
  /* Customize the label (the container) */
  .container-checkbox {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }

  /* Hide the browser's default checkbox */
  .container-checkbox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
  }

  /* Create a custom checkbox */
  .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #eee;
  }

  /* On mouse-over, add a grey background color */
  .container-checkbox:hover input ~ .checkmark {
    background-color: #ccc;
  }

  /* When the checkbox is checked, add a blue background */
  .container-checkbox input:checked ~ .checkmark {
    background-color: #2196F3;
  }

  /* Create the checkmark/indicator (hidden when not checked) */
  .checkmark:after {
    content: "";
    position: absolute;
    display: none;
  }

  /* Show the checkmark when checked */
  .container-checkbox input:checked ~ .checkmark:after {
    display: block;
  }

  /* Style the checkmark/indicator */
  .container-checkbox .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }
</style>
@endsection

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
                                  <input type="number" class="form-control" value="{{ $item->harga }}" id="validationDefault05" placeholder="Harga" name="harga" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                  <label for="validationDefault06">Pajak </label><small> (Nominal)</small>
                                  <input type="number" class="form-control" value="{{ $item->pajak }}" id="validationDefault06" placeholder="Pajak" name="pajak" required>
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
                                    <input type="number" class="form-control" id="validationDefault08" placeholder="ThirdParty"
                                      value="{{ $item->harga_thirdparty }}"
                                      name="harga_thirdparty" required>
                                  </div>
                                  <div class="col-md-4 mb-3">
                                    <label for="validationDefault10">Pajak Third Party</label><small> (Nominal)</small>
                                    <input type="number" class="form-control" id="validationDefault10" placeholder="Pajak Third Party" value="{{ $item->pajak_thirdparty }}" name="pajak_thirdparty" required>
                                  </div>
                                  <div class="col-md-4 mb-3">
                                    <label for="validationDefault09">Harga Third Party </label><small> (Nominal)</small>
                                    <input type="number" readonly class="form-control" value="{{ $item->thirdparty }}" id="validationDefault09" placeholder="thirdparty" name="thirdparty" required>
                                  </div>
                                 </div>
                                </div>
                                @if(!$item->is_paket)
                                <div class="col-md-12 item-types-{{ $item->id_item }}">
                                </div>
                                <div class="col-md-12 my-2">
                                  <button type="button" class="btn btn-outline-primary" id="btnTambahItemType_{{ $item->id_item }}" onclick="tambahItemType({{$item->id_item}})">
                                    Tambah Item Type <span aria-hidden="true">&plus;</span>
                                  </button>
                                </div>
                                @endif
                                @if($item->is_paket)
                                <div class="col-md-12">
                                  <div class="row">
                                    <div class="col-md-12 mb-3">
                                      <h4>Opsi Menu :</h4>
                                      <div id="opsiMenus">
                                        @foreach ($item->opsi_menu as $item_opsi_menu)
                                          @foreach ($item_opsi_menu->menu_type as $menu_type)
                                            <input type="hidden"
                                              name="paket_item_menu[{{ $menu_type->id_item_paket}}][]"
                                              value="{{ $menu_type->id_item_type }}">
                                          @endforeach
                                        @endforeach
                                      </div>
                                      <div class="row">
                                        <div class="col-12">
                                          <button type="button" class="btn btn-outline-primary" id="btnAddOpsiMenu">
                                            <span aria-hidden="true">&plus;</span>
                                          </button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                @endif
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

@section('modals')
<div class="modal fade" id="modalOpsiMenu" tabindex="-1" aria-labelledby="modalOpsiMenuLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalOpsiMenuLabel">Opsi Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalOpsiMenuBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" onclick="pilihOpsiMenu()" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">  
  $(document).ready(function() {
    $('input[name="harga"]').on('input', function (change) {
      var pajak = $(this).parent().parent().find('input[name="pajak"]').val()
      var harga = change.target.valueAsNumber
      var harga_jual = Number(pajak) + harga
      $(this).parent().parent().find('input[name="harga_jual"]').val(harga_jual)
    })
    $('input[name="pajak"]').on('input', function (change) {
      var harga = $(this).parent().parent().find('input[name="harga"]').val()
      var pajak = change.target.valueAsNumber
      var harga_jual = pajak + Number(harga)
      $(this).parent().parent().find('input[name="harga_jual"]').val(harga_jual)
    })
    $('input[name="harga_thirdparty"]').on('input', function (change) {
      var pajak = $(this).parent().parent().find('input[name="pajak_thirdparty"]').val()
      var harga = change.target.valueAsNumber
      var harga_jual = Number(pajak) + harga
      $(this).parent().parent().find('input[name="thirdparty"]').val(harga_jual)
    })
    $('input[name="pajak_thirdparty"]').on('input', function (change) {
      var harga = $(this).parent().parent().find('input[name="harga_thirdparty"]').val()
      var pajak = change.target.valueAsNumber
      var harga_jual = pajak + Number(harga)
      $(this).parent().parent().find('input[name="thirdparty"]').val(harga_jual)
    })
  });
</script>

@if (!$dataitem[0]->is_paket)
<script>
  var dataitem = {!! $dataitem !!}
  $(document).ready(function () {
    dataitem = dataitem.map(function (item) {
      item.new_item_types = []
      return item;
    })
    dataitem.forEach(function (item, key) {
      var id_item = item.id_item
      item.item_types = item.item_types.map(function (type) {
        type.new_item_sizes = []
        return type;
      })
      item.item_types.forEach( function (type, index) {
        $(`div.item-types-${id_item}`).append(templateItemType(item.id_item, type, type.id_type))
        var item_sizes = type.item_sizes
        item_sizes.forEach( function (item_size) {
          $(`div.item-sizes-${type.id_type}`).append(templateItemSize(item.id_item, type, item_size, item_size.id_type))
        })
      })
      updateHargaItemSize()
    })
  })
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
  function tambahItemType(id_item) {
    var item = dataitem.filter(function (data) {
      return data.id_item == id_item;
    })
    if (item.length > 0) {
      item = item[0]
      var type = {
        id_type: `${id_item}-${item.item_types.length}`,
        nama_type: '',
        item_sizes: []
      }
      var item_size = {
        id_type: 0,
        id_size: 0,
        pajak: 0,
        pajak_thirdparty: 0,
        harga: 0,
        harga_thirdparty: 0,
        harga_jual: 0,
        thirdparty: 0,
        item_size: '',
      }
      type.item_sizes.push(item_size)
      $(`div.item-types-${id_item}`).append(templateItemType(id_item, type))
      dataitem = dataitem.map(function (data) {
        if (data.id_item == id_item) data.item_types.push(type)
        return data;
      })
      type.item_sizes.forEach(function (item_size) {
        $(`div.item-sizes-${type.id_type}`).append(templateItemSize(id_item, type, item_size))
      })
      updateHargaItemSize()
    }
  }
  function tambahItemSize (id_item, id_type) {
    var item = dataitem.filter(function (data) {
      return data.id_item == id_item;
    })
    if (item.length > 0) {
      item = item[0]
      var item_types = item.item_types
      var item_type = item_types.filter (function (data) {
        return data.id_type == id_type;
      })
      if (item_type.length > 0) {
        item_type = item_type[0];
        var item_size = {
          id_type: id_type,
          id_size: `${id_item}-${id_type}-${item_type.item_sizes.length}`,
          pajak: 0,
          pajak_thirdparty: 0,
          harga: 0,
          harga_thirdparty: 0,
          harga_jual: 0,
          thirdparty: 0,
          item_size: '',
        }
        $(`div.item-sizes-${id_type}`).append(templateItemSize(id_item, item_type, item_size))
        item_type.item_sizes.push(item_size)
        item_types = item_types.map( function (data) {
          if (data.id_type == id_type) data = item_type
          return data;
        })
      }
      dataitem = dataitem.map( function (data) {
        if (data.id_item == id_item) data.item_types = item_types
        return data;
      })
      updateHargaItemSize()
    }
  }
  function hapusItemType(item_type) {
    var id_item = dataitem[0].id_item
    $(`div.item-type-${item_type}`).find(`input[name="item_type_id[${item_type}]"]`).each(function (index, data) {
      var value = $(data).val()
      if (value != 0) {
        $(`div.item-types-${id_item}`).prepend(hiddenInput(`delete_item_types[]`, value))
      }
    })
    $(`div.item-sizes-${item_type}`).find(`input[name="item_size_id[${item_type}][]"]`).each(function (index, data) {
      var value = $(data).val()
      if (value != 0) {
        $(`div.item-types-${id_item}`).prepend(hiddenInput(`delete_item_types[]`, value))
      }
    })
    $(`div.item-type-${item_type}`).remove()
    $(`div.item-sizes-${item_type}`).remove()
  }
  function hapusItemSize(item_type, item_size) {
    var id_item = dataitem[0].id_item
    $(`div.item-size-${item_type}-${item_size}`)
      .find(`input[name="item_size_id[${item_type}][]"]`).each(function(index, data) {
        var value = $(data).val()
        if (value != 0) {
          $(`div.item-types-${id_item}`).prepend(hiddenInput(`delete_item_types[]`, value))
        }
      })
    $(`div.item-size-${item_type}-${item_size}`).remove()
  }
  function templateItemType (id_item, item_type, id = 0) {
    var id_type = item_type.id_type
    var nama_type = item_type.nama_type
    return `
      <div class="row item-type-${id_type}">
        <div class="col-md-8 mb-3">
          <input type="hidden" name="item_type_id[${id_type}]" value="${ id }">
          <label for="nama_item_type${id_type}">Item Type </label>
          <input type="text" id="nama_item_type${id_type}" class="form-control" placeholder="Nama Item Type" name="nama_item_type[${id_type}]" value="${nama_type}" required>
        </div>
        <div class="col-md-4 mb-3 align-self-end">
          <div class="btn-group" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-outline-primary" onclick="tambahItemType('${id_item}')">
              Tambah Item Type <span aria-hidden="true"><i class="fas fa-plus"></i></span>
            </button>
            <button type="button" class="btn btn-danger" onclick="hapusItemType('${id_type}')">
              <i class="fas fa-trash"></i>
            </button>
          </div>
        </div>
      </div>
      <div class="item-sizes-${id_type}">
      </div>
    `
  }
  function templateItemSize (id_item, item_type, item_size, id = 0) {
    var id_type = item_type.id_type
    var id_size = item_size.id_type
    var pajak = item_size.pajak
    var pajak_thirdparty = item_size.pajak_thirdparty
    var harga = item_size.harga
    var harga_thirdparty = item_size.harga_thirdparty
    var harga_jual = item_size.harga_jual
    var thirdparty = item_size.thirdparty
    var item_size = item_size.item_size
    return `
      <div class="item-size-${id_type}-${id_size}">
        <div class="row">
          <div class="col-8 mb-3">
            <input type="hidden" name="item_size_id[${id_type}][]" value="${ id }">
            <label for="nama_item_size${id_size}">Item Size</label>
            <input type="text" class="form-control" placeholder="Nama Item Size" aria-label="Nama Item Size" aria-describedby="basic-addon2" id="nama_item_size${id_size}" name="nama_item_size[${id_type}][]" value="${item_size}" required>
          </div>
          <div class="col-4 mb-3 align-self-end">
            <div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-outline-primary" onclick="tambahItemSize('${id_item}','${id_type}')">
                Tambah Item Size <span aria-hidden="true"><i class="fas fa-plus"></i></span>
              </button>
              <button type="button" class="btn btn-danger" onclick="hapusItemSize('${id_type}','${id_size}')">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="harga_item_size${id_size}">Harga </label> <small> (Nominal)</small>
            <input type="number" id="harga_item_size${id_size}" class="form-control" placeholder="Nama Item Size" name="harga_item_size[${id_type}][]" value="${harga}" required>
          </div>
          <div class="col-md-4 mb-3">
            <label for="pajak_item_size${id_size}">Pajak</label><small> (Nominal)</small>
            <input type="number" class="form-control" required id="pajak_item_size${id_size}" name="pajak_item_size[${id_type}][]" value="${pajak}">
          </div>
          <div class="col-md-4 mb-3">
            <label for="harga_jual_item_size${id_size}">Harga Jual</label><small> (Nominal)</small>
            <input type="number" disabled class="form-control" placeholder="Harga Item Size" required id="harga_jual_item_size${id_size}" name="harga_jual_item_size[${id_type}][]" value="${harga_jual}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <label for="harga_thirdparty_item_size${id_size}">Harga </label> <small> (Nominal)</small>
            <input type="number" id="harga_thirdparty_item_size${id_size}" class="form-control" placeholder="Nama Item Size" name="harga_thirdparty_item_size[${id_type}][]" required value="${harga_thirdparty}">
          </div>
          <div class="col-md-4 mb-3">
            <label for="pajak_thirdparty_item_size${id_size}">Pajak</label><small> (Nominal)</small>
            <input type="number" class="form-control" required id="pajak_thirdparty_item_size${id_size}" name="pajak_thirdparty_item_size[${id_type}][]" value="${pajak_thirdparty}">
          </div>
          <div class="col-md-4 mb-3">
            <label for="harga_jual_thirdparty_item_size${id_size}">Harga Jual</label><small> (Nominal)</small>
            <input type="number" disabled class="form-control" placeholder="Harga Item Size" required id="harga_jual_thirdparty_item_size${id_size}" name="harga_jual_thirdparty_item_size[${id_type}][]" value="${thirdparty}">
          </div>
        </div>
      </div>
    `
  }
  function hiddenInput(name, value) {
    return `<input type="hidden" name="${name}" value="${value}">`
  }
</script>
@endif

@if($item->is_paket)
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
  var opsi_menu = {!! $opsi_menu !!}
  var kategori = {!! $datakategori !!}
  var selected_kategori = []  
  var jumlahKategoriOpsiMenu = 0
  $(document).ready(function () {
    for (let index = 0; index < kategori.length; index++) {
      const element = kategori[index];
      kategori[index].id = element.id_kategori
      kategori[index].text = element.nama_kategori
      if (Boolean(element.is_paket)) kategori = kategori.slice(0, index)
    }
    var menu = 0;
    while (menu < opsi_menu.length) {
      var menu_item = opsi_menu[menu]
      menu_item.id = menu_item.id_item
      menu_item.text = menu_item.nama_item
      menu_item.selected = menu_item.selected
      if (menu_item.selected == true) {
        selected_kategori = selected_kategori.filter ( function (select) {
          return select != menu_item.id_kategori
        })
        selected_kategori.push(menu_item.id_kategori)
      }
      menu += 1;
    }
    jumlahKategoriOpsiMenu = selected_kategori.length
    for (let index = 0; index < jumlahKategoriOpsiMenu; index++) {
      var elements = kategori.map(function (map) {
        map.selected = false
        if (map.id == selected_kategori[index]) map.selected = true
        return map;
      })
      initiateOpsiMenu((index + 1), elements)
    }
  })
  $('.kategori-opsi-menu').select2({
    placeholder: 'Kategori Opsi Menu',
    width: 'element'
  });
  $('#btnAddOpsiMenu').on('click', function (event) {
    jumlahKategoriOpsiMenu += 1
    initiateOpsiMenu(jumlahKategoriOpsiMenu, kategori)
  })

  function initiateOpsiMenu (jumlahOpsiMenu, datakategori = []) {
    var selectedKategori = datakategori.filter( function (kategori) {
      return kategori.selected == true;
    })
    var options = {
      placeholder: 'Pilih Opsi Menu',
      data: [],
      maximumSelectionLength: 0
    }
    var jumlahSelectedAvailableOpsiMenu = 0
    if (selectedKategori.length > 0) {
      selectedKategori = selectedKategori[0]
      var availableOpsiMenu = opsi_menu.filter(function (menu) {
        return menu.id_kategori == selectedKategori.id_kategori
      })
      options.data = availableOpsiMenu
      jumlahSelectedAvailableOpsiMenu = availableOpsiMenu.filter(function (filter) {
        return filter.selected == true
      }).length
      options.maximumSelectionLength = jumlahSelectedAvailableOpsiMenu
    }
    $('#opsiMenus').append(templateOpsiMenu(jumlahOpsiMenu, jumlahSelectedAvailableOpsiMenu));
    // Datatable
    tableOpsiMenu(options.data, jumlahOpsiMenu, selectedKategori)

    // Select 2
    $('.kategori-opsi-menu').select2({
      placeholder: 'Pilih Kategori',
      width: 'element',
      data: datakategori
    });
    
    var opsiMenu = $(`#opsiMenu_${jumlahOpsiMenu}`).select2(options)
    // $(`#jumlahOpsiMenu_${jumlahOpsiMenu}`).on('input || change', function (el) {
    //   var jumlahOpsiMenu = el.target.valueAsNumber
    //   options.maximumSelectionLength = jumlahOpsiMenu
    //   opsiMenu.select2(options)
    //   var selectedOpsiMenu = opsiMenu.find(':selected')
    //   if (selectedOpsiMenu.length > jumlahOpsiMenu) {
    //     var allowedMenu = []
    //     for (let index = 0; index < selectedOpsiMenu.length; index++) {
    //       const element = selectedOpsiMenu[index];
    //       var value = $(element).val()
    //       if (index < jumlahOpsiMenu) allowedMenu.push(value)
    //     }
    //     opsiMenu.val(allowedMenu)
    //     opsiMenu.trigger('change')
    //   }
    // })

    $(`#kategoriOpsiMenu_${jumlahOpsiMenu}`).on('select2:select', function (e) {
      opsiMenu.empty()
      var data = e.params.data;
      var availableOpsiMenu = opsi_menu.filter(function (menu) {
        return menu.id_kategori == data.id_kategori
      })
      options.data = availableOpsiMenu
      $(`.table_opsi_menu_body_${jumlahOpsiMenu}`).find('input[name="opsi_menu[]"]').each(function (index, menu) {
        if (menu.checked) {
          $(`input[name="paket_item_menu[${menu.value}][]"]`).remove()
        }
      })
      tableOpsiMenu(availableOpsiMenu, jumlahOpsiMenu, selectedKategori)
      opsiMenu.select2(options)
    })

    options.data = options.data.map(function (data) {
      data.selected = false
      return data;
    })

    opsiMenu.on('select2:select', function (e) {
      var data = e.params.data;
      $.ajax({
        url: '{{ url("pos/item-type/item/") }}' + `/${data.id_item}`,
        method: 'GET',
        success: function (response) {
          if (response.length > 0) {
            $('#modalOpsiMenuBody').html(templatePilihOpsiMenu(data.id_item, response))
            $('#modalOpsiMenu').modal('show')
          }
          $('#modalOpsiMenu').on('hidden.bs.modal', function () {
            $('#modalOpsiMenuBody').html('')
          })
        }
      })
    })
    opsiMenu.on('select2:unselect', function (e) {
      data = e.params.data;
      $(`input[name="paket_item_menu[${data.id_item}][]"]`).remove()
    })
  }
  var _selectOpsiMenu
  function selectOpsiMenu(event) {
    _selectOpsiMenu = event
    if (event.checked) {
      $.ajax({
        url: '{{ url("pos/item-type/item/") }}' + `/${event.value}`,
        method: 'GET',
        success: function (response) {
          if (response.length > 0) {
            $('#modalOpsiMenuBody').html(templatePilihOpsiMenu(event.value, response))
            $('#modalOpsiMenu').modal('show')
          }
          $('#modalOpsiMenu').on('hidden.bs.modal', function () {
            $('#modalOpsiMenuBody').html('')
          })
        }
      })
    } else {
      $(event).parent().parent().parent().find('.opsi_menu_type').html('')
      $(`input[name="paket_item_menu[${event.value}][]"]`).remove()
    }
  }

  function tableOpsiMenu(data, jumlahOpsiMenu, selectedKategori) {
    var tableMenu = '';
    data.forEach(function (value) {
      var checked = ''
      var menuType = ''
      if (value.selected && value.id_kategori == selectedKategori.id) {
        checked = 'checked'
        value.menu_type.forEach(function (item) {
          menuType = `${menuType} <span class="badge badge-info">${item.nama_item}</span>`
        })
      }
      var html = `
        <tr>
          <th scope="row">
            <div class="form-check">
              <input ${checked} class="form-check-input" type="checkbox" value="${value.id_item}" onChange="selectOpsiMenu(this)" name="opsi_menu[]" />
            </div>
          </th>
          <td>${value.nama_item}</td>
          <td colspan="2" class="opsi_menu_type">${menuType}</td>
        </tr>
      `
      tableMenu = `${tableMenu} ${html}`
    })
    if ($.fn.DataTable.isDataTable( `.table_opsi_menu_${jumlahOpsiMenu}` )) {
      $(`.table_opsi_menu_${jumlahOpsiMenu}`).DataTable().destroy()
    }
    $(`.table_opsi_menu_body_${jumlahOpsiMenu}`).html('')
    $(`.table_opsi_menu_body_${jumlahOpsiMenu}`).html(tableMenu)
    $(`.table_opsi_menu_${jumlahOpsiMenu}`).DataTable();
  }

  function pilihOpsiMenu () {
    $(_selectOpsiMenu).parent().parent().parent().find('.opsi_menu_type').html('')
    $('#modalOpsiMenuBody').find('input[name*="paket_item_menu"]').each(function (index, item) {
      item = $(item)
      item = item[0]
      var text = $(item).siblings('.text').html()
      var template = `<input type="hidden" name="${item.name}[]" value="${item.value}" >`
      $(`input[name="${item.name}"][value="${item.value}[]"]`).remove()
      if (item.checked) {
        $('div#opsiMenus').prepend(template)
        $(_selectOpsiMenu).parent().parent().parent().find('.opsi_menu_type').append(`
          <span class="badge badge-info">${text}</span>
        `)
      }
    })
    $('#modalOpsiMenu').modal('hide')
  }

  function templateOpsiMenu (jumlahOpsiMenu, jumlahMenu = 0) {
    return `
      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="kategoriOpsiMenu_${jumlahOpsiMenu}">Kategori :</label>
          <select class="form-control kategori-opsi-menu" id="kategoriOpsiMenu_${jumlahOpsiMenu}" name="" required>
            <option></option>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <label for="jumlahOpsiMenu_${jumlahOpsiMenu}">Jumlah :</label>
          <input type="number" id="jumlahOpsiMenu_${jumlahOpsiMenu}" name="jumlah_opsi_menu[${jumlahOpsiMenu}][]" class="form-control" placeholder="Jumlah Menu" value="${ jumlahMenu > 0 ? jumlahMenu : ''}">
        </div>
        <div class="col-md-12 mb-3">
          {{-- <div class="accordion" id="accordionExample_${jumlahOpsiMenu}">
            <div class="card">
              <div class="card-header" id="headingOne_${jumlahOpsiMenu}">
                <h2 class="mb-0">
                  <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne_${jumlahOpsiMenu}" aria-expanded="true" aria-controls="collapseOne_${jumlahOpsiMenu}">
                    Pilih Opsi Menu
                  </button>
                </h2>
              </div>
              <div id="collapseOne_${jumlahOpsiMenu}" class="collapse" aria-labelledby="headingOne_${jumlahOpsiMenu}" data-parent="#accordionExample_${jumlahOpsiMenu}">
                <div class="card-body">
                  <table class="table table_opsi_menu_${jumlahOpsiMenu}">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Item</th>
                        <th scope="col">Type</th>
                      </tr>
                    </thead>
                    <tbody class="table_opsi_menu_body_${jumlahOpsiMenu}">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> --}}
          <label for="opsiMenu_${jumlahOpsiMenu}">Menu</label>
          <select class="form-control opsi-menu" id="opsiMenu_${jumlahOpsiMenu}" name="opsi_menu[${jumlahOpsiMenu}][]" multiple="multiple" required>
          </select>
        </div>
      </div>
    `
  }

  function templatePilihOpsiMenu(id_item, data = []) {
    var template = '';
    data.forEach(function (item) {
      template = `${template} <label class="container-checkbox">
          <span class="text">${item.text}</span>
          <input type="checkbox" name="paket_item_menu[${id_item}]" value="${item.id_type}">
          <span class="checkmark"></span>
        </label>
      `
    })
    return template
  }
</script>
@endif
@endsection