@extends('dashboard.layout')

@section('page title','Session Detail')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg">
                <div class="card card-primary card-outline">
                    <div class="row">
                        <div class="col-12">
                            <div class="card pt-5">
                            <div class="card-body p-0">
                                <div class="col-md-6 mx-auto">
                                    <div class="table-responsive">
                                    <table id="pos_store" class="table table-hover text-center" >
                                        <tbody>
                                            <tr>
                                                <th>Deposit</th>
                                                <td>
                                                    @foreach ($deposit as $item)
                                                    @php
                                                        $depo = $item->deposit;
                                                    @endphp
                                                        {{$item->deposit}}
                                                    @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Tunai</th>
                                                <td>
                                                    @foreach ($tunai as $item)
                                                        @php
                                                            $tun = $item->total_tunai;
                                                        @endphp
                                                        {{$item->total_tunai}}
                                                    @endforeach
                                                </td>
                                            </tr>
                                            
                                            @foreach ($debit as $item)
                                            <tr>
                                                <th>{{$item->tipe_payment}}</th>
                                                <td>{{$item->total_debit}}</td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <th>Total Cash</th>
                                                <td>{{$depo+$tun}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                            </div>
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
