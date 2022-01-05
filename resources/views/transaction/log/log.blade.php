@extends('dashboard.layout')

@section('page title','Log Transaction')

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
                                <h4></h4>
                                <div class="card-header-form">
                                    <form action="{{ url('transaction/log') }}" action="get">
                                        {{-- <div class="input-group">
                                          <input type="text" class="form-control" name="search" value="" placeholder="Search">
                                          <div class="input-group-btn">
                                            <button class="btn btn-primary h-100" id="id-btn-search"><i class="fas fa-search"></i></button>
                                          </div>
                                        </div> --}}
                                        <div class="col-md-12">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                  {{-- <label for="validationDefault01">Tanggal</label> --}}
                                                  <input type="date" class="form-control h-100" id="validationDefault01" name="date">
                                                </div>
                                                <div class="col-md-4">
                                                  {{-- <label for="validationDefault02">Store</label> --}}
                                                  <select class="custom-select form-control h-100" id="validationDefault02" name="id_store" required>
                                                    <option value="all">All</option>
                                                    @foreach ($datastore as $datas)
                                                      <option value="{{ $datas->id_store }}">{{ $datas->nama_store }}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                                <div class="col-md-2 m-auto">
                                                    <button class="btn btn-primary form-control" id="id-btn-search" style="height:40px">
                                                        <i class="fas fa-arrow-right"></i>
                                                    </button>
                                                </div>
                                              </div>
                                        </div>
                                      </form>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @if (session('status1'))
                                    <div class="mt-3 alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('status1') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif
                                <div class="table-responsive">
                                <table id="pos_store" class="table table-hover text-center" >
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No invoice</th>
                                            <th>Store</th>
                                            <th>Kasir</th>
                                            <th>Total</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($count!=0)
                                            @foreach ($datasales as $data)
                                            <tr>
                                                <td>{{$start++}}</td>
                                                <td>{{$data->no_invoice}}</td>
                                                <td>{{$data->nama_store}}</td>
                                                <td>{{$data->nama}}</td>
                                                <td>{{number_format($data->total,0,",",".")}}</td>
                                                <td>{{date( "d M Y", strtotime($data->tanggal))}}</td>
                                                <td>{{ucfirst($data->status)}}</td>
                                                <td>
                                                    <div class="row mt-2">
                                                        <div class="col-lg-6">
                                                            <input type="button" class="btn btn-sm btn-block btn-warning mt-2 btn-detail" style="background-color: #ffc107;color: #FFF" value="Detail" data-id="{{$data->no_invoice}}">
                                                        </div>
                                                        <div class="col-lg-6" >
                                                            <form action="{{ url('transaction/log/void', $data->no_invoice) }}" id="refund-form-{{$data->no_invoice}}" method="post">
                                                                @csrf 
                                                                @method('get')
                                                                @if ($data->status=='refund')
                                                                    <button class="btn btn-sm btn-block btn-danger mt-2 mr-0" disabled>Refunded</button>
                                                                @else
                                                                    @if ($data->tanggal == $today)
                                                                        <button type="submit" class="btn btn-sm btn-block btn-danger mt-2 mr-0 btnVoid" data-id="{{$data->no_invoice}}">Refund</button>    
                                                                    @else
                                                                        <button class="btn btn-sm btn-block btn-primary mt-2 mr-0" disabled>Success</button>    
                                                                    @endif
                                                                @endif
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @elseif($count==0)
                                            <tr>
                                                <td colspan="7">
                                                    Tidak ada data
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
                                    <li class="page-item mr-3 {{ $page_now==1 ? 'disabled' : '' }}">
                                      <a class="page-link" href="{{ url('transaction/log?id_store='.$id_store.'&pagination='.($page_now-1)) }}" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                    </li>
                                    @for ($i = 1; $i <= $count; $i++)
                                      <li class="page-item {{ $i==$page_now ? 'active' : '' }}">
                                        <a class="page-link" href="{{ url('transaction/log?id_store='.$id_store.'&pagination='.$i) }}">{{ $i }}</a>
                                      </li>
                                    @endfor
                                    <li class="ml-3 page-item {{ $page_now==$count ? 'disabled' : '' }}">
                                      <a class="page-link" href="{{ url('transaction/log?id_store='.$id_store.'&pagination='.($page_now+1)) }}"><i class="fas fa-chevron-right"></i></a>
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
$(".btn-detail").on("click",function(){
    var no_inv = $(this).attr("data-id");
    $.ajax({
        url: '{{ url("transaction/log/detail") }}'+"/"+no_inv,
        dataType : 'html',
        
        success:function(response) {
            $('#inv_detail').html(response);
            // console.log(response);
        }
    });
    $('#voucherModal').modal("show");
});

$('.btnVoid').on('click',function(e){
    e.preventDefault();
    var form = $(this).parents('form');
    var data = $(this).parents('form').serialize();
    var no_inv = $(this).attr("data-id");


    Swal.fire({
        title:"Are you sure?",
        type:"warning",
        html: '<label>You will not be able revert this action</label><input type="text" id="keterangan" class="swal2-input" placeholder="Keterangan">',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const keterangan = Swal.getPopup().querySelector('#keterangan').value
            // if (!keterangan) {
            //     Swal.showValidationMessage(`Mohon masukkan keterangan`)
            // }
            return {keterangan: keterangan}
        },
        allowOutsideClick: () => {
            const popup = Swal.getPopup()
            popup.classList.remove('swal2-show')
            return false
        }
    }).then((result) => {
        if (result.dismiss !== 'cancel') {
            $.ajax({
                url: '{{ url("transaction/log/keterangan/") }}'+"/"+no_inv,
                dataType : 'json',
                type: 'post',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "no_inv": no_inv,
                    "keterangan": result.value.keterangan,
                },
                success:function(response) {
                    console.log(response)
                }
            });

            form.submit();
            Swal.fire('Refunded!', 'Invoice has been refunded! ', 'success');
        }else{
            Swal.fire('Cancelled!', 'Refund has been cancelled', 'error');
        }
    });
});

  
</script>
@endsection
