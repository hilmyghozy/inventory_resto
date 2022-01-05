<div class="container-fluid mb-2">
    <div class="row">
        <div class="col-md-2">
          No Invoice
        </div>
        <div class="col-md-1">:</div>
        <div class="col-md-3">{{$data_inv->first()->no_invoice}}</div>
        <div class="col-md-6"></div>

        <div class="col-md-2">
            Store
          </div>
          <div class="col-md-1">:</div>
          <div class="col-md-3">{{$data_inv->first()->nama_store}}</div>
          <div class="col-md-6"></div>

        <div class="col-md-2">
          Kasir
        </div>
        <div class="col-md-1">:</div>
        <div class="col-md-3">{{$data_inv->first()->nama}}</div>
        <div class="col-md-6"></div>

        <div class="col-md-2">                      
          Tanggal
        </div>
        <div class="col-md-1">:</div>
        <div class="col-md-3">{{date("d M Y", strtotime($data_inv->first()->tanggal))}}</div>
        <div class="col-md-6"></div>
        
        <div class="col-md-2">                      
            Status
        </div>
        <div class="col-md-1">:</div>
        <div class="col-md-3">{{ucfirst($data_inv->first()->status)}}</div>
        <div class="col-md-6"></div>

        @if ($data_inv->first()->status == 'refund')
        <div class="col-md-2">                      
          Keterangan
        </div>
          <div class="col-md-1">:</div>
          <div class="col-md-3">
          @foreach ($data_inv as $data)
            @if ($loop->first)
              @foreach ($datarefund as $items => $item)
                @if ($item->no_invoice == $data->no_invoice)
                  {{$item->keterangan}}
                @endif
              @endforeach
            @endif
          @endforeach
          </div>
          <div class="col-md-6"></div>
        @endif
    </div>
</div>
<div class="container-fluid">
  <table class="table table-sm table-striped">
      <thead>
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nama item</th>
          <th scope="col">Qty</th>
          <th scope="col">Harga</th>
          <th scope="col">Subtotal</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($data_inv as $data)
          <tr>
            <th scope="row">{{$start++}}</th>
            <td>{{$data->nama_item}}</td>
            <td>{{$data->qty}}</td>
            <td>{{$data->harga}}</td>
            <td>Rp. {{$data->subtotal}}</td>
          </tr>
          @endforeach
        @if ($data->id_discount!= null)
        <tr>
          <th scope="row" colspan="4">Subtotal</th>
          <td>Rp. {{$data->sub}}</td>
        </tr>  
        <tr>
            <th scope="row" colspan="4">Diskon ( 
              @foreach ($datavoucher as $item)
                  @if ($item->id_voucher == $data->id_discount)
                      {{$item->nama_voucher}}
                  @endif
              @endforeach
              )
            </th>
            <td>
              {{$data->total - $data->sub}}
            </td>
          </tr>
        @endif
        <tr>
          <th scope="row" colspan="4">Total</th>
          <td>Rp. {{$data->total}}</td>
        </tr>
      </tbody>
    </table>
</div>