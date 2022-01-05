@extends('dashboard.layout')

@section('page title','Edit Item Group Produk Management')

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

                        <form action="{{ url('pos/item-group/edit/'.$datagroup[0]->id_item_group) }}" method="POST">
                            @csrf
                            <div class="form-row mt-3">
                                <div class="col-md-6 mb-3">
                                    <label for="validationDefault02">Nama Item Group</label>
                                    <input type="text" class="form-control" id="validationDefault02" placeholder="Nama Group" name="nama_item_group" value="{{ $datagroup[0]->nama_item_group }}" required>
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