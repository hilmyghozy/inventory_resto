@extends('dashboard.layout')

@section('page title','Session')

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
                                    
                                </h4>
                                <div class="card-header-form">
                                <form action="{{ url('transaction/session') }}" action="get">
                                    <div class="input-group">
                                        <input type="date" class="form-control mr-3 rounded" name="tanggal" value="{{$tanggal}}" id="session-tanggal" style="border-radius:12px !important">
                                        {{-- <button class="btn btn-xs btn-primary"><i class="fas fa-arrow-right"></i></button> --}}
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
                                            <th>Nama Kasir</th>
                                            <th>Store</th>
                                            <th>Deposit</th>
                                            <th>Total Tunai</th>
                                            <th>Total</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datasession as $data)
                                            @if ($data->tanggal==$today)
                                                @if ($data->status==1)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$data->nama}}</td>
                                                        <td>{{$data->nama_store}}</td>
                                                        <td>{{number_format($data->deposit,0,",",".")}}</td>
                                                        <td>
                                                            <?php
                                                                $tun = 0; 
                                                                foreach($total_tunai[$start++] as $key=>$item){
                                                                $tun = $item->total_tunai;
                                                                echo number_format($item->total_tunai,0,",",".");
                                                            } ?>
                                                        </td>
                                                        <td>{{number_format(($data->deposit+$tun),0,",",".")}}</td>
                                                        <td>{{date("d M Y", strtotime($data->tanggal))}}</td>
                                                    </tr>
                                                @endif
                                            @else
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$data->nama}}</td>
                                                    <td>{{$data->nama_store}}</td>
                                                    <td>{{number_format($data->deposit,0,",",".")}}</td>
                                                    <td>
                                                        <?php
                                                            $tun = 0; 
                                                            foreach($total_tunai[$start++] as $key=>$item){
                                                            $tun = $item->total_tunai;
                                                            echo number_format($item->total_tunai,0,",",".");
                                                        } ?>
                                                    </td>
                                                    <td>{{number_format(($data->deposit+$tun),0,",",".")}}</td>
                                                    <td>{{date("d M Y", strtotime($data->tanggal))}}</td>
                                                    {{-- <td>
                                                        <form action="{{url('transaction/session/detail')}}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id_store" value="{{$data->id_store}}">
                                                            <input type="hidden" name="id_kasir" value="{{$data->id_kasir}}">
                                                            <input type="hidden" name="tanggal" value="{{$data->tanggal}}">
                                                            <button class="btn btn-info text-white">Detail</button>
                                                        </form>
                                                    </td> --}}
                                                </tr>
                                            @endif
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
  
  $('#session-tanggal').on('change', function (ev) {
    var tanggal = $(this).val();
    window.location.href = "{{ url('transaction/session') }}?tanggal="+tanggal;
    
  });
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
