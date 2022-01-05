@extends('dashboard.layout')

@section('page title','Payment Type')

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


                        <form action="{{ url('pos/payment/add') }}" method="POST" enctype="multipart/form-data">
                            @csrf 
                            <div class="form-row mt-3">
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault02">Metode Pembayaran</label>
                                <input type="text" class="form-control @error('nama_payment') is-invalid @enderror" id="validationDefault02" value="{{old('nama_payment')}}" placeholder="Name" name="nama_payment">
                                @error('nama_payment')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault05">Tipe Pembayaran</label>
                                <select name="tipe_payment" id="validationDefault05" class="form-control">
                                    <option value="1">Tunai</option>
                                    <option value="2">Debit</option>
                                </select>
                              </div>
                              <div class="col-md-12 mb-3">
                                <label for="validationDefault05">Logo Pembayaran</label> <small>(Boleh dikosongkan)</small>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('gambar_payment') is-invalid @enderror" id="customFile" name="gambar_payment">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                  </div>
                                  @error('gambar_payment')
                                    <div class="invalid-feedback">{{$message}}</div>
                                  @enderror
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
                                <form action="{{ url('pos/payment') }}" action="get">
                                    <div class="input-group">
                                      <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Search">
                                      <div class="input-group-btn">
                                        <button class="btn btn-primary" id="id-btn-search"><i class="fas fa-search"></i></button>
                                      </div>
                                    </div>
                                  </form>
                              </div>
                            </div>
                            <div class="card-body p-0">
                              <div class="table-responsive">
                                <table class="table table-hover text-center" id="pos_payment">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Tipe Pembayarab</th>
                                            <th>Images</th>
                                            <th>Setting</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                        <tr>
                                            <td>{{$start++}}</td>
                                            <td>{{$item->nama_payment}}</td>
                                            <td>{{$item->tipe_payment==1?'Tunai':'Debit'}}</td>
                                            <td>
                                                @if ($item->logo)
                                                    <img src="{{Storage::url($item->logo)}}" width=50px alt="">
                                                @else
                                                Belum ada gambar
                                                @endif
                                            </td>
                                            <td>
                                                <div class="row">
                                                  <div class="col-lg-6">
                                                    <a href="{{ url('pos/payment/edit', $item->id_payment) }}" class="btn btn-block btn-warning" style="background-color: #ffc107;color: #212529"> Edit</a>
                                                    {{-- <button class="btn btn-block btn-warning"> Edit</button> --}}
                                                  </div>
                                                  <div class="col-lg-6" >
                                                      <form action="{{ url('pos/payment/destroy', $item->id_payment) }}" method="post">
                                                      @csrf 
                                                      @method('delete')
                                                      <button type="submit" class="btn btn-block btn-danger" id="btnBaru"  onclick="return confirm('Yakin data akan di hapus')">Delete</button> 
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
                                        <a class="page-link" href="{{ url('pos/payment?search='.$search.'&pagination='.($page_now-1)) }}" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                      </li>
                                      @for ($i = 1; $i <= $count; $i++)
                                        <li class="page-item {{ $i==$page_now ? 'active' : '' }}">
                                          <a class="page-link" href="{{ url('pos/payment?search='.$search.'&pagination='.$i) }}">{{ $i }}</a>
                                        </li>
                                      @endfor
                                      <li class="ml-3 page-item {{ $page_now==$count ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ url('pos/payment?search='.$search.'&pagination='.($page_now+1)) }}"><i class="fas fa-chevron-right"></i></a>
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

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change', '#customFile',function(){
            let gambar = $('#customFile').val();
            $('.custom-file-label').text(gambar);
        });
    });

    $("#search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#pos_payment tbody tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

</script>
@endsection
{{-- @section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const btnHapus = $('#btnHapus');
        const btnEdit = $('#btnEdit');
        const btnBaru = $('#btnBaru');
        const btnClose = $('#btnClose');

        const cardComponent = $('#cardComponent');

        let groupData = [];

        const dataForm = $('#dataForm');
        const inputType = $('#inputType');
        const iID = $('#idGroup');
        const iNama = $('#nama');
        const iSegment = $('#segment_name');
        const iIcon = $('#icon');
        const iOrder = $('#ord');

        function resetForm() {
            iID.val('');
            iNama.val('');
            iSegment.val('');
            iIcon.val('');
            iOrder.val('');
        }

        const tableIndex = $('#tableIndex').DataTable({
            "ajax": {
                "method": "POST",
                "url": "{{ url('admin/system-utility/menu-group/list') }}",
                "header": {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content'),
                },
                "complete": function (xhr,responseText) {
                    if (responseText == 'error') {
                        console.log(xhr);
                        console.log(responseText);
                    }
                }
            },
            "columns": [
                { "data": "name" },
                { "data": "segment_name" },
                { "data": "icon" },
                { "data": "ord" },
            ],
        });
        $('#tableIndex tbody').on( 'click', 'tr', function () {
            let data = tableIndex.row( this ).data();
            iID.val(data.id);
            iNama.val(data.name);
            iSegment.val(data.segment_name);
            iIcon.val(data.icon);
            iOrder.val(data.ord);
            // console.log(data);
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                btnEdit.attr('disabled','true');
                btnHapus.attr('disabled','true');
            } else {
                tableIndex.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                btnEdit.removeAttr('disabled');
                btnHapus.removeAttr('disabled');
            }
        });

        $(document).ready(function () {
            /*
            Button Action
             */
            btnBaru.click(function (e) {
                e.preventDefault();
                inputType.val('new');
                resetForm();
                cardComponent.removeClass('d-none');
                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
            });
            btnEdit.click(function (e) {
                e.preventDefault();
                inputType.val('edit');
                cardComponent.removeClass('d-none');
                $('html, body').animate({
                    scrollTop: cardComponent.offset().top
                }, 500);
            });
            btnHapus.click(function (e) {
                e.preventDefault();
                Swal.fire({
                    title: iNama.val()+" akan dihapus",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus Data'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: '{{ url('admin/system-utility/menu-group/delete') }}',
                            method: 'post',
                            data: {id: iID.val()},
                            success: function (response) {
                                console.log(response);
                                if (response === 'success') {
                                    Swal.fire({
                                        title: 'Data terhapus!',
                                        type: 'success',
                                        onClose: function () {
                                            tableIndex.ajax.reload();
                                        }
                                    })
                                } else {
                                    Swal.fire({
                                        title: 'Gagal',
                                        text: 'Silahkan coba lagi',
                                        type: 'error',
                                    })
                                }
                            }
                        });
                    }
                });

            });
            btnClose.click(function (e) {
                e.preventDefault();
                $("html, body").animate({ scrollTop: 0 }, 500, function () {
                    resetForm();
                    cardComponent.addClass('d-none');
                    tableIndex.ajax.reload();
                    btnEdit.attr('disabled','true');
                    btnHapus.attr('disabled','true');
                });
            });

            /*
            SUBMIT DATA
            First: Check new or edit data
             */
            dataForm.submit(function (e) {
                e.preventDefault();
                let url;
                if (inputType.val() === 'new') {
                    url = "{{ url('admin/system-utility/menu-group/add') }}";
                } else {
                    url = "{{ url('admin/system-utility/menu-group/edit') }}";
                }
                $.ajax({
                    url: url,
                    method: 'post',
                    data: $(this).serialize(),
                    success: function (response) {
                        console.log(response);
                        if (response === 'success') {
                            Swal.fire({
                                type: 'success',
                                title: 'Data Tersimpan',
                                onClose: function () {
                                    $("html, body").animate({ scrollTop: 0 }, 500, function () {
                                        cardComponent.addClass('d-none');
                                        tableIndex.ajax.reload();
                                    });
                                }
                            })
                        } else {
                            Swal.fire(
                                'Gagal!',
                                'Username atau Password Salah',
                                'warning'
                            )
                        }
                    }
                })
            })
        });
    </script>
@endsection --}}
