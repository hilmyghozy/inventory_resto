@extends('dashboard.layout')

@section('page title','Edit Payment Type')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg">

                <div class="card bg-white">
                    <div class="container">
                        
                        @foreach ($data as $item)  
                        <form action="{{ url('pos/payment/updateProcess') }}" method="POST" enctype="multipart/form-data">
                            @csrf 
                            <div class="form-row mt-3">
                                <input type="hidden" class="form-control" id="validationDefault01" placeholder="Name" name="id_payment" value="{{ $item->id_payment }}" required>
                              <div class="col-md-6 mb-3">
                                <label for="nama">Metode Pembayaran</label>
                                <input type="text" class="form-control" id="nama" placeholder="Name" name="nama_payment" value="{{ $item->nama_payment }}">
                                @error('nama_payment')
                                    <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                              </div>
                              <div class="col-md-6 mb-3">
                                <label for="validationDefault05">Tipe Pembayaran</label>
                                <select name="tipe_payment" id="validationDefault05" class="form-control">
                                    <option value="1" {{$item->tipe_payment==1?'selected':''}}>Tunai</option>
                                    <option value="2" {{$item->tipe_payment==2?'selected':''}}>Debit</option>
                                </select>
                              </div>
                              @if ($item->logo)
                                <div class="col-md-12 mt-3">
                                    <div class="mediabody">
                                        <img src="{{Storage::url($item->logo)}}" class="img-thumbnail " alt="" width="150px">   
                                        <div class="hapus">
                                            Hapus Gambar
                                            <div class="form-group row ml-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="hapus" id="hapus" value="yes" >
                                                    <label class="form-check-label" for="hapus">
                                                    Ya
                                                    </label>
                                                </div>
                                                <div class="form-check ml-4">
                                                    <input class="form-check-input" type="radio" name="hapus" id="tidak" value="no" checked>
                                                    <label class="form-check-label" for="tidak">
                                                    Tidak
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 mt-3 yes selectt d-none">
                                @else
                                <div class="col-md-12 mb-3 mt-3 yes selectt">

                              @endif
                              
                              
                                
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
                                        <button class="btn btn-block btn-primary" id="btnBaru">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @endforeach
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
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change', '#customFile',function(){
            let gambar = $('#customFile').val();
            $('.custom-file-label').text(gambar);
        });

        $('input[type="radio"]').click(function() { 
            var inputValue = $(this).attr("value"); 
            if(inputValue=="yes"){
                $(".yes.selectt").removeClass("d-none");
            }else{
                $(".yes.selectt").addClass("d-none");
            }
        }); 
    });
</script>
@endsection