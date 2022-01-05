@extends('dashboard.layout')

@section('page title','User & Employee Management')

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
                        <form action="{{ url('uc/user/add') }}" method="POST">
                            @csrf 
                            <div class="form-row mt-3">
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault01">Username</label>
                                <input type="text" class="form-control" id="validationDefault01" placeholder="Username" name="username" required>
                              </div>

                              <div class="col-md-6 mb-3">
                                <label for="validationDefault02">Nama Lengkap</label>
                                <input type="text" class="form-control" id="validationDefault02" placeholder="Nama lengkap" name="nama" required>
                              </div>

                              <div class="col-md-6 mb-3">
                                <label for="validationDefault03">Password</label>
                                <input type="password" class="form-control" id="validationDefault03" placeholder="Password" name="password" required>
                              </div>

                              <div class="col-md-6 mb-3">
                                <label for="validationDefault04">Role</label>
                                <select name="role" id="validationDefault04" class="form-control" required>
                                    <option value="cashier">Cashier</option>
                                    <option value="waiters">Waiters</option>
                                </select>
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
                                <form action="{{ url('uc/user') }}" action="get">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="search" value="{{ $search }}" placeholder="Search">
                                        <div class="input-group-btn">
                                        <button class="btn btn-primary h-100" id="id-btn-search"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                              </div>
                            </div>
                            <div class="card-body p-0">
                              <div class="table-responsive">
                                <table class="table table-hover text-center" id="pos-store">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Password</th>
                                            <th>Role</th>
                                            <th>Setting</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datakasir as $data)
                                        <tr>
                                            <td>{{ $start++ }}</td>
                                            <td>{{$data->nama}}</td>
                                            <td>{{$data->username}}</td>
                                            <td>{{$data->password}}</td>
                                            <td>{{ucfirst($data->role)}}</td>
                                            <td>
                                                <div class="row">
                                                  <div class="col-lg-6">
                                                    <a href="{{ url('uc/user/edit', $data->id) }}" class="btn btn-block btn-warning" style="background-color: #ffc107;color: #212529"> Edit</a>
                                                    {{-- <button class="btn btn-block btn-warning"> Edit</button> --}}
                                                  </div>
                                                  <div class="col-lg-6" >
                                                      <form action="{{ url('uc/user/destroy', $data->id) }}" method="post">
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
                                        <a class="page-link" href="{{ url('uc/user?search='.$search.'&pagination='.($page_now-1)) }}" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                      </li>
                                      @for ($i = 1; $i <= $count; $i++)
                                        <li class="page-item {{ $i==$page_now ? 'active' : '' }}">
                                          <a class="page-link" href="{{ url('uc/user?search='.$search.'&pagination='.$i) }}">{{ $i }}</a>
                                        </li>
                                      @endfor
                                      <li class="ml-3 page-item {{ $page_now==$count ? 'disabled' : '' }}">
                                        <a class="page-link" href="{{ url('uc/user?search='.$search.'&pagination='.($page_now+1)) }}"><i class="fas fa-chevron-right"></i></a>
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#pos-store').DataTable();
    } );

    function edit_store(){
        alert "wowo";
    }

    $(document).ready( function () {
        var x = $('#validationDefault02').(val);
        console.log(x);
    });
</script>

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
