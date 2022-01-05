@extends('dashboard.layout')

@section('page title','Sales Report Management')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg">
                <div class="card card-primary card-outline">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                            <div class="card-header">
                                <h4 class="header-sales-report">
                                    <table>
                                        <tr>
                                            <th>Group By</th>
                                            <td class="pl-3">: Kategori Produk</td>
                                            <th class="pl-3">Total </th>
                                            <td class="pl-3">: Rp. {{number_format($jumlah,0,",",".")}}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td class="pl-3">: {{ucfirst($status)}}</td>
                                            <th class="pl-3">Total Item</th>
                                            <td class="pl-3">: {{$jumlah_qty}}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <td class="pl-3">: {{date( "d M Y", strtotime($from))}} s/d {{date( "d M Y", strtotime($to))}}</td>
                                        </tr>
                                    </table>
                                </h4>
                                <div class="card-header-form">
                                    <form action="{{ url('report/sales/kategori') }}" method="post">
                                        @csrf
                                        <div class="input-group">
                                        <input type="hidden" name="sort_by" id="sort_by" value="{{$status}}">
                                        <input type="hidden" name="group_by" id="group_by" value="{{$group_by}}">
                                        <input type="hidden" name="to" id="to" value="{{$to}}">
                                        <input type="hidden" name="from" id="from" value="{{$from}}">
                                        <input type="hidden" name="total" id="total" value="{{$jumlah}}">
                                        <input type="hidden" name="total_item" id="total_item" value="{{$jumlah_qty}}">
                                        <button class="btn btn-success">Export <i class="fas fa-file-excel"></i></button>
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
                                            <th>Nama Kategori</th>
                                            <th>Nama Store</th>
                                            <th>Total Penjualan</th>
                                            <th>Total harga Penjualan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datakategori as $data)
                                        <tr>
                                            <td>{{$start++}}</td>
                                            <td>{{$data->nama_kategori}}</td>
                                            <td>{{$data->nama_store}}</td>
                                            {{-- <td>
                                                @foreach ($item as $key=>$value)
                                                    @if ($value->id_kategori == $data->id_kategori)
                                                        {{$value->nama_kategori}}
                                                    @endif
                                                @endforeach
                                            </td> --}}
                                            {{-- <td>{{$data->nama_kategori}}</td> --}}
                                            <td>{{$data->total_qty}}</td>
                                            <td>{{number_format($data->total_penjualan,0,",",".")}}</td>
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
                                <form action="{{ url('report/sales') }}" method="post" class="row ml-1">
                                    <li class="page-item {{ $pagination==1 ? 'disabled' : '' }} mr-1">
                                        <button class="page-link" tabindex="-1" value="{{$pagination-1}}"><i class="fas fa-chevron-left"></i></button>
                                    </li>
                                    
                                    @csrf
                                    <input type="hidden" name="sort_by" id="sort_by1" value="{{$status}}">
                                    <input type="hidden" name="group_by" id="group_by1" value="{{$group_by}}">
                                    <input type="hidden" name="to" id="to1" value="{{$to}}">
                                    <input type="hidden" name="from" id="from1" value="{{$from}}">
                                    <input type="hidden" name="search" id="search1" value="{{ ($search) }}">

                                    @for ($i = 1; $i <= $count; $i++)
                                    <li class="page-item {{ $i==$pagination ? 'active' : '' }}">
                                        <button  class="page-link" name="pagination" value="{{$i}}">{{$i}}</button>
                                    </li>
                                    @endfor
                                    <li class="page-item {{ $pagination==$count ? 'disabled' : '' }} ml-1">
                                        <button  class="page-link" name="pagination" value="{{$pagination+1}}"><i class="fas fa-chevron-right"></i></button>
                                    </li>
                                </form>
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
