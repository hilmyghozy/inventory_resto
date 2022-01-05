@extends('dashboard.layout')

@section('page title','Item Group Produk Management')

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

                        <form action="{{ url('pos/item-group/add') }}" method="POST">
                            @csrf
                            <div class="form-row mt-3">
                                <div class="col-md-6 mb-3">
                                    <label for="validationDefault02">Nama Item Group</label>
                                    <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Group" name="nama_item_group" required>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-6">
                                    </div>
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
                                        <form action="{{ url('pos/item-group') }}" action="get">
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
                                        <table class="table table-hover text-center" id="pos-store">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name Group</th>
                                                    <th>Setting</th>
                                                </tr>
                                            </thead>
                                            <tbody id="body-table">
                                                @foreach ($datagroup as $data)
                                                <tr>
                                                    <td>{{$start++}}</td>
                                                    <td>{{$data->nama_item_group}}</td>
                                                    <td>
                                                        <div class="row mt-2">
                                                            <div class="col-lg-6">
                                                                <a href="{{ url('pos/item-group/edit', $data->id_item_group) }}" class="btn btn-block btn-warning" style="background-color: #ffc107;color: #212529"> Edit</a>
                                                                {{-- <button class="btn btn-block btn-warning"> Edit</button> --}}
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <form action="{{ url('pos/item-group/destroy', $data->id_item_group) }}" method="post">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" class="btn btn-block btn-danger" id="btnBaru" onclick="return confirm('Yakin data akan di hapus')">Delete</button>
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
                                            <a class="page-link" href="{{ url('pos/item-group?search='.$search.'&pagination='.($page_now-1)) }}" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                                        </li>
                                        @for ($i = 1; $i <= $count; $i++) <li class="page-item {{ $i==$page_now ? 'active' : '' }}">
                                            <a class="page-link" href="{{ url('pos/item-group?search='.$search.'&pagination='.$i) }}">{{ $i }}</a>
                                            </li>
                                            @endfor
                                            <li class="ml-3 page-item {{ $page_now==$count ? 'disabled' : '' }}">
                                                <a class="page-link" href="{{ url('pos/item-group?search='.$search.'&pagination='.($page_now+1)) }}"><i class="fas fa-chevron-right"></i></a>
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


</script>
@endsection