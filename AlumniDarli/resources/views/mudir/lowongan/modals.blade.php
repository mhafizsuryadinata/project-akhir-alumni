<!-- Create Job Modal -->
<div class="modal fade" id="createJobModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus-circle me-2"></i>Tambah Lowongan Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('mudir.lowongan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Judul Posisi <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control" required placeholder="Contoh: Staff IT">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="perusahaan" class="form-control" required placeholder="Contoh: PT. Maju Jaya">
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Lokasi <span class="text-danger">*</span></label>
                            <input type="text" name="lokasi" class="form-control" required placeholder="Kota, Provinsi">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Tipe <span class="text-danger">*</span></label>
                            <select name="tipe_pekerjaan" class="form-select" required>
                                <option value="Full Time">Full Time</option>
                                <option value="Part Time">Part Time</option>
                                <option value="Freelance">Freelance</option>
                                <option value="Contract">Contract</option>
                                <option value="Internship">Internship</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Level <span class="text-danger">*</span></label>
                            <select name="level" class="form-select" required>
                                <option value="Entry Level">Entry Level</option>
                                <option value="Mid Level">Mid Level</option>
                                <option value="Senior Level">Senior Level</option>
                                <option value="Manager">Manager</option>
                                <option value="Director">Director</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold">Kualifikasi <span class="text-danger">*</span></label>
                            <textarea name="kualifikasi" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Benefit (Opsional)</label>
                            <textarea name="benefit" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Gaji Min (Opsional)</label>
                            <input type="number" name="gaji_min" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Gaji Max (Opsional)</label>
                            <input type="number" name="gaji_max" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email Kontak <span class="text-danger">*</span></label>
                            <input type="email" name="email_kontak" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Website (Opsional)</label>
                            <input type="url" name="website" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Tutup <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_tutup" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Logo Perusahaan</label>
                            <input type="file" name="logo_perusahaan" class="form-control" accept="image/*">
                        </div>
                    </div>
                    
                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan Lowongan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Job Modal -->
<div class="modal fade" id="editJobModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Edit Lowongan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Judul Posisi</label>
                            <input type="text" id="edit_judul" name="judul" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Nama Perusahaan</label>
                            <input type="text" id="edit_perusahaan" name="perusahaan" class="form-control" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold">Lokasi</label>
                            <input type="text" id="edit_lokasi" name="lokasi" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipe</label>
                            <select id="edit_tipe" name="tipe_pekerjaan" class="form-select" required>
                                <option value="Full Time">Full Time</option>
                                <option value="Part Time">Part Time</option>
                                <option value="Freelance">Freelance</option>
                                <option value="Contract">Contract</option>
                                <option value="Internship">Internship</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Level</label>
                            <select id="edit_level" name="level" class="form-select" required>
                                <option value="Entry Level">Entry Level</option>
                                <option value="Mid Level">Mid Level</option>
                                <option value="Senior Level">Senior Level</option>
                                <option value="Manager">Manager</option>
                                <option value="Director">Director</option>
                            </select>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold">Status Lowongan</label>
                            <select id="edit_status" name="status" class="form-select" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Ditutup">Ditutup</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Deskripsi Pekerjaan</label>
                            <textarea id="edit_deskripsi" name="deskripsi" class="form-control" rows="4" required></textarea>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold">Kualifikasi</label>
                            <textarea id="edit_kualifikasi" name="kualifikasi" class="form-control" rows="3" required></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold">Benefit</label>
                            <textarea id="edit_benefit" name="benefit" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Gaji Min</label>
                            <input type="number" id="edit_gaji_min" name="gaji_min" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Gaji Max</label>
                            <input type="number" id="edit_gaji_max" name="gaji_max" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Email Kontak</label>
                            <input type="email" id="edit_email" name="email_kontak" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Website</label>
                            <input type="url" id="edit_website" name="website" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tanggal Tutup</label>
                            <input type="date" id="edit_tanggal_tutup" name="tanggal_tutup" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Update Logo Perusahaan</label>
                            <input type="file" name="logo_perusahaan" class="form-control" accept="image/*">
                        </div>
                    </div>
                    
                    <div class="mt-4 text-end">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning px-4">Update Lowongan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
