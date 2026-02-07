@extends('admin-master')
@section('isi')

<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Data Alumni Dar El-ilmi</h4>
                
                <form action="{{url('alumni/update')}}" method="POST">
                    @csrf
                    
                    <input type="hidden" name="id_user" value="{{$users->id_user}}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nomor_nia" class="form-label">NIA</label>
                                <input type="text" class="form-control" id="nomor_nia" name="nomor_nia" value="{{$users->nomor_nia}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{$users->username}}" required>
                            </div>
                        </div>
                    </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{$users->nama}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tahun_masuk" class="form-label">Tahun Masuk</label>
                                <input type="number" class="form-control" id="tahun_masuk" name="tahun_masuk" value="{{$users->tahun_masuk}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tahun_tamat" class="form-label">Tahun Tamat</label>
                                <input type="number" class="form-control" id="tahun_tamat" name="tahun_tamat" value="{{$users->tahun_tamat}}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required>{{$users->alamat}}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor HP</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{$users->no_hp}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{$users->email}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{$users->pekerjaan}}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi Terkini</label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi" value="{{$users->lokasi}}" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{url('alumni/tampil')}}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.card-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 20px;
}

.form-label {
    font-weight: 500;
    color: #2c3e50;
}

.form-control {
    border-radius: 5px;
    border: 1px solid #ddd;
    padding: 8px 12px;
}

.form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
}

.btn {
    border-radius: 5px;
    padding: 8px 20px;
    font-weight: 500;
}

.btn-primary {
    background-color: #3498db;
    border-color: #3498db;
}

.btn-primary:hover {
    background-color: #2980b9;
    border-color: #2980b9;
}

.btn-secondary {
    background-color: #95a5a6;
    border-color: #95a5a6;
}

.btn-secondary:hover {
    background-color: #7f8c8d;
    border-color: #7f8c8d;
}
</style>

<script>
// Validasi form sederhana
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        
        if (password !== passwordConfirmation) {
            e.preventDefault();
            alert('Password dan Konfirmasi Password tidak sama!');
            return false;
        }
        
        if (password.length < 6) {
            e.preventDefault();
            alert('Password harus minimal 6 karakter!');
            return false;
        }
    });
});
</script>

@endsection