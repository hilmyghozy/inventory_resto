<div class="col-lg-6">
    <nav class="d-inline-block">
        <ul class="pagination mb-0">
            <li class="page-item">
                <a class="page-link" tabindex="-1" id="page-next"><i class="fas fa-chevron-left"></i></a>
            </li>
            @for ($i = 1; $i <= $jumlah; $i++)
                <li class="page-item">
                    <a class="page-link" id="page-{{ $i }}">{{ $i }}</a>
                </li>
            @endfor
            
            {{-- <li class="page-item active">
              <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
            </li>
            
            <li class="page-item"><a class="page-link" href="#">3</a></li> --}}
            <li class="page-item">
                <a class="page-link" id="page-next"><i class="fas fa-chevron-right"></i></a>
            </li>
        </ul>
    </nav>
</div>