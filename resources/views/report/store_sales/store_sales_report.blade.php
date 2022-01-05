@extends('dashboard.layout')

@section('page title','Store Sales Report')

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
                                            <th>Store</th>
                                            <td class="pl-3">: 
                                                @if ($datastore!=null)
                                                    {{$datastore->first()->nama_store}}
                                                @else
                                                    All
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td class="pl-3">: {{ucfirst($status)}}</td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal</th>
                                            <td class="pl-3">: {{date( "d M Y", strtotime($date))}}</td>
                                        </tr>
                                    </table>
                                </h4>
                                <div class="card-header-form">
                                <form action="{{ url('report/store_sales') }}" method="post">
                                    @csrf
                                    <div class="input-group">
                                    <input type="hidden" name="id_store" id="id_store" value="{{$store}}">
                                    <input type="hidden" name="status" id="status" value="{{$status}}">
                                    <input type="hidden" name="date" id="date" value="{{$date}}">
                                    <input type="text" class="form-control" name="search" id="search" value="{{ ($search) }}" placeholder="Search">
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-primary h-100"  id="id-btn-search"><i class="fas fa-search"></i></button>
                                    </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                <table id="pos_store" class="table table-hover text-center border-bottom border-dark">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Invoice</th>
                                            @if ($datastore==null)
                                                <th>Store</th>
                                            @endif
                                            <th>Kasir</th>
                                            <th>
                                                Item
                                            </th>
                                            <th>Subtotal</th>
                                            <th>Diskon</th>
                                            <th>Total Bayar</th>
                                            {{-- <th>Tipe Bayar</th> --}}
                                            @if ($status=='all')
                                                <th>Status</th>
                                            @endif
                                            @if ($status=='refund')
                                                <th>Keterangan</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @if ($count!=0)
                                            @foreach ($datasales as $data)
                                            <tr class="border-top border-dark">
                                                <td>{{$start++}}</td>
                                                <td>{{$data->no_invoice}}</td>
                                                @if ($datastore==null)
                                                    <td>{{$data->nama_store}}</td>
                                                @endif
                                                <td>{{$data->nama}}</td>
                                                <td>
                                                    <div class="table-responsive">
                                                        <table class="table text-center m-0 table-borderless" >
                                                            @foreach ($dataitems as $item)
                                                                @if ($item->no_invoice == $data->no_invoice)
                                                                    <tr>
                                                                        <td>{{$item->nama_item}}</td>
                                                                        <td>{{$item->qty}}</td>
                                                                        {{-- <td>{{$item->total}}</td> --}}
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </table>
                                                    </div>
                                                </td>
                                                <td>{{number_format($data->subtotal,0,",",".")}}</td>
                                                <td>
                                                    @if ($data->id_discount!=null)
                                                    @foreach ($datavoucher as $item)
                                                        @if ($item->id_voucher == $data->id_discount)
                                                            {{$item->nama_voucher}}
                                                        @endif
                                                    @endforeach
                                                    @else
                                                        -
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($data->is_split==0)
                                                        {{$data->tipe_payment}} - {{number_format($data->total,0,",",".")}}
                                                    @else
                                                        {{$data->tipe_payment}} - {{number_format($data->debit_cash,0,",",".")}} <br>
                                                        Tunai - {{number_format(($data->total-$data->debit_cash),0,",",".")}}
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    @if ($data->is_split==0)
                                                    @else
                                                        {{$data->tipe_payment}}(Tunai)
                                                    @endif
                                                </td> --}}
                                                @if ($status=='all')
                                                    <td>{{ucfirst($data->status)}}</td>
                                                @endif
                                                @if ($status=='refund')
                                                <td>
                                                    @foreach ($datarefund as $item)
                                                        @if ($item->no_invoice == $data->no_invoice)
                                                            {{$item->keterangan}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                            @elseif($count==0)
                                            <tr>
                                                <td colspan="9">
                                                    Tidak ada transaksi
                                                </td>
                                            </tr>   
                                        @endif
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
                                <form action="{{ url('report/store_sales') }}" method="post" class="row ml-1">
                                    <li class="page-item {{ $pagination==1 ? 'disabled' : '' }} mr-1">
                                        <button class="page-link" tabindex="-1" value="{{$pagination-1}}"><i class="fas fa-chevron-left"></i></button>
                                    </li>
                                    
                                    @csrf
                                    <input type="hidden" name="id_store" id="id_store1" value="{{$store}}">
                                    <input type="hidden" name="status" id="status1" value="{{$status}}">
                                    <input type="hidden" name="date" id="date1" value="{{$date}}">
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
    
</script>
@endsection
