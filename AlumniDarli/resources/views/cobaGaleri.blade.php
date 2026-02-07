@extends('alumni-master')

@section('alumni')
<div class="container py-4">
    <h2>{{ $album->nama_album }}</h2>
    <p class="text-muted">{{ $album->deskripsi }}</p>

    <div class="row g-3 mt-4">
        @foreach ($fotos as $foto)
            <div class="col-md-3">
                <div class="card">
                    <img src="{{ asset($foto->file_path) }}" class="card-img-top" alt="">
                    <div class="card-body p-2">
                        <small>{{ $foto->deskripsi }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
