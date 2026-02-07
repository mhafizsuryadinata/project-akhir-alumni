@extends('admin-master')

@section('judul', 'Edit FAQ')

@section('isi')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit FAQ</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.faq.update', $faq->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <input type="text" name="question" class="form-control" value="{{ $faq->question }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jawaban</label>
                        <textarea name="answer" class="form-control" rows="5" required>{{ $faq->answer }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Urutan Tampil (Opsional)</label>
                        <input type="number" name="order" class="form-control" value="{{ $faq->order }}">
                        <div class="form-text">Angka lebih kecil akan tampil lebih atas.</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.faq.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-warning text-dark">Update FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
