
@foreach ($datakategori as $data)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>{{$data->nama_kategori}}</td>
    <td>
        <div class="row">
            <div class="col-lg-6">
            <a href="{{ url('pos/product/kategori/edit', $data->id_kategori) }}" class="btn btn-block btn-warning" > Edit</a>
            {{-- <button class="btn btn-block btn-warning"> Edit</button> --}}
            </div>
            <div class="col-lg-6" >
                <form action="{{ url('pos/product/kategori/destroy', $data->id_kategori) }}" method="post">
                @csrf 
                @method('delete')
                <button type="submit" class="btn btn-block btn-danger" id="btnBaru"  onclick="return confirm('Yakin data akan di hapus')">Delete</button> 
                </form>
            </div>
        </div>
    </td>
</tr>
@endforeach