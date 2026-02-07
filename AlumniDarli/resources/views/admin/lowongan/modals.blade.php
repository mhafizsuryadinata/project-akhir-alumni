<!-- Create Job Modal -->
<div class="modal fade" id="createJobModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Tambah Lowongan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.lowongan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Judul Posisi <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control" required placeholder="Contoh: Staff IT">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="perusahaan" class="form-control" required placeholder="Contoh: PT. Maju Jaya">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="lokasi" class="form-control" required placeholder="Kota, Provinsi">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Tipe <span class="text-danger">*</span></label>
                            <select name="tipe_pekerjaan" class="form-select" required>
                                <option value="Full Time">Full Time</option>
                                <option value="Part Time">Part Time</option>
                                <option value="Freelance">Freelance</option>
                                <option value="Internship">Internship</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Level <span class="text-danger">*</span></label>
                            <select name="level" class="form-select" required>
                                <option value="Entry Level">Entry Level</option>
                                <option value="Mid Level">Mid Level</option>
                                <option value="Senior Level">Senior Level</option>
                                <option value="Manager">Manager</option>
                                <option value="Director">Director</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Kualifikasi <span class="text-danger">*</span></label>
                            <textarea name="kualifikasi" class="form-control" rows="3" required placeholder="- S1 Teknik Informatika&#10;- Menguasai Laravel"></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Benefit (Opsional)</label>
                            <textarea name="benefit" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gaji Min (Opsional)</label>
                            <input type="number" name="gaji_min" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gaji Max (Opsional)</label>
                            <input type="number" name="gaji_max" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Kontak <span class="text-danger">*</span></label>
                            <input type="email" name="email_kontak" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Website (Opsional)</label>
                            <input type="url" name="website" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Tutup <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_tutup" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Logo Perusahaan</label>
                            <input type="file" name="logo_perusahaan" class="form-control" accept="image/*">
                        </div>
                    </div>
                    
                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Lowongan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Job Modal -->
<div class="modal fade" id="editJobModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Edit Lowongan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Judul Posisi</label>
                            <input type="text" id="edit_judul" name="judul" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Nama Perusahaan</label>
                            <input type="text" id="edit_perusahaan" name="perusahaan" class="form-control" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Lokasi</label>
                            <input type="text" id="edit_lokasi" name="lokasi" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tipe</label>
                            <select id="edit_tipe" name="tipe_pekerjaan" class="form-select" required>
                                <option value="Full Time">Full Time</option>
                                <option value="Part Time">Part Time</option>
                                <option value="Freelance">Freelance</option>
                                <option value="Internship">Internship</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Level</label>
                            <select id="edit_level" name="level" class="form-select" required>
                                <option value="Entry Level">Entry Level</option>
                                <option value="Mid Level">Mid Level</option>
                                <option value="Senior Level">Senior Level</option>
                                <option value="Manager">Manager</option>
                                <option value="Director">Director</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold text-primary">Status Lowongan</label>
                            <select id="edit_status" name="status" class="form-select border-primary" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Ditutup">Ditutup</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi Pekerjaan</label>
                            <textarea id="edit_deskripsi" name="deskripsi" class="form-control" rows="4" required></textarea>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label">Kualifikasi</label>
                            <textarea id="edit_kualifikasi" name="kualifikasi" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Benefit</label>
                            <textarea id="edit_benefit" name="benefit" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gaji Min</label>
                            <input type="number" id="edit_gaji_min" name="gaji_min" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Gaji Max</label>
                            <input type="number" id="edit_gaji_max" name="gaji_max" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Email Kontak</label>
                            <input type="email" id="edit_email" name="email_kontak" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Website</label>
                            <input type="url" id="edit_website" name="website" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Tutup</label>
                            <input type="date" id="edit_tanggal_tutup" name="tanggal_tutup" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Update Logo Perusahaan</label>
                            <input type="file" name="logo_perusahaan" class="form-control" accept="image/*">
                        </div>
                    </div>
                    
                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update Lowongan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
