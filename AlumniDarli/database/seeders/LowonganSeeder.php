<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LowonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lowongan = [
            [
                'judul' => 'Web Developer',
                'perusahaan' => 'PT Tech Indonesia',
                'lokasi' => 'Jakarta',
                'tipe_pekerjaan' => 'Full Time',
                'level' => 'Mid Level',
                'deskripsi' => "Kami mencari Web Developer yang berpengalaman untuk bergabung dengan tim kami.\n\nTanggung Jawab:\n- Mengembangkan dan memelihara aplikasi web\n- Bekerja sama dengan tim desain dan backend\n- Melakukan testing dan debugging\n- Menulis kode yang clean dan terdokumentasi",
                'kualifikasi' => "- Minimal 2 tahun pengalaman sebagai Web Developer\n- Menguasai HTML, CSS, JavaScript\n- Pengalaman dengan framework seperti React, Vue, atau Angular\n- Memahami RESTful API\n- Mampu bekerja dalam tim\n- Komunikasi yang baik",
                'benefit' => "- Gaji kompetitif\n- Asuransi kesehatan\n- Bonus tahunan\n- Kesempatan pengembangan karir\n- Work from home flexibility",
                'gaji_min' => 'Rp 8.000.000',
                'gaji_max' => 'Rp 12.000.000',
                'email_kontak' => 'hr@techindonesia.com',
                'website' => 'https://techindonesia.com',
                'tanggal_tutup' => Carbon::now()->addDays(30)->format('Y-m-d'),
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Digital Marketing Specialist',
                'perusahaan' => 'CV Kreatif Media',
                'lokasi' => 'Bandung',
                'tipe_pekerjaan' => 'Full Time',
                'level' => 'Entry Level',
                'deskripsi' => "Bergabunglah dengan tim marketing kami dan bantu mengembangkan strategi digital marketing!\n\nTugas:\n- Mengelola media sosial perusahaan\n- Membuat konten marketing yang menarik\n- Menganalisis performa campaign\n- Melakukan riset pasar dan kompetitor",
                'kualifikasi' => "- Pendidikan minimal D3/S1 Marketing atau bidang terkait\n- Memahami social media marketing\n- Kreatif dan inovatif\n- Menguasai tools seperti Canva, Adobe Photoshop (nilai plus)\n- Mampu bekerja dengan deadline",
                'benefit' => "- Training dan mentoring\n- Lingkungan kerja yang fun\n- Bonus performa\n- BPJS Kesehatan & Ketenagakerjaan",
                'gaji_min' => 'Rp 4.500.000',
                'gaji_max' => 'Rp 6.000.000',
                'email_kontak' => 'recruitment@kreatifmedia.co.id',
                'website' => 'https://kreatifmedia.co.id',
                'tanggal_tutup' => Carbon::now()->addDays(25)->format('Y-m-d'),
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Backend Developer',
                'perusahaan' => 'Startup Nusantara',
                'lokasi' => 'Jakarta',
                'tipe_pekerjaan' => 'Full Time',
                'level' => 'Senior Level',
                'deskripsi' => "Kami mencari Backend Developer senior untuk memimpin pengembangan sistem kami.\n\nResponsibilities:\n- Merancang dan mengembangkan arsitektur backend\n- Optimasi database dan query\n- Code review dan mentoring junior developer\n- Implementasi best practices dan security",
                'kualifikasi' => "- Minimal 5 tahun pengalaman sebagai Backend Developer\n- Expert dalam PHP/Laravel atau Node.js\n- Pengalaman dengan microservices architecture\n- Mahir database MySQL/PostgreSQL\n- Pengalaman dengan Redis, ElasticSearch (nilai plus)\n- Leadership skill",
                'benefit' => "- Gaji sangat kompetitif\n- Stock options\n- Remote working\n- Latest tech stack\n- Annual team outing",
                'gaji_min' => 'Rp 15.000.000',
                'gaji_max' => 'Rp 25.000.000',
                'email_kontak' => 'jobs@startupnusantara.id',
                'website' => 'https://startupnusantara.id',
                'tanggal_tutup' => Carbon::now()->addDays(45)->format('Y-m-d'),
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'UI/UX Designer',
                'perusahaan' => 'Design Studio',
                'lokasi' => 'Yogyakarta',
                'tipe_pekerjaan' => 'Full Time',
                'level' => 'Mid Level',
                'deskripsi' => "Cari UI/UX Designer yang passionate untuk menciptakan pengalaman pengguna yang luar biasa!\n\nWhat you'll do:\n- Membuat wireframe dan prototype\n- Melakukan user research\n- Desain interface yang user-friendly\n- Kolaborasi dengan developer dan product manager",
                'kualifikasi' => "- Minimal 2-3 tahun pengalaman di bidang UI/UX\n- Mahir menggunakan Figma, Adobe XD, atau Sketch\n- Portfolio yang strong\n- Memahami prinsip design thinking\n- Kemampuan komunikasi yang baik",
                'benefit' => "- Salary sesuai pengalaman\n- Flexible working hours\n- Annual bonus\n- Health insurance\n- Professional development budget",
                'gaji_min' => 'Rp 7.000.000',
                'gaji_max' => 'Rp 10.000.000',
                'email_kontak' => 'career@designstudio.com',
                'website' => 'https://designstudio.com',
                'tanggal_tutup' => Carbon::now()->addDays(20)->format('Y-m-d'),
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Mobile App Developer (Flutter)',
                'perusahaan' => 'Mobile Solutions Inc',
                'lokasi' => 'Surabaya',
                'tipe_pekerjaan' => 'Full Time',
                'level' => 'Mid Level',
                'deskripsi' => "Join our mobile development team!\n\nJob Description:\n- Develop cross-platform mobile apps using Flutter\n- Integrate with backend APIs\n- Ensure app performance and quality\n- Collaborate with cross-functional teams",
                'kualifikasi' => "- 2+ years experience with Flutter development\n- Strong knowledge of Dart programming\n- Experience with state management (Provider, Bloc, Riverpod)\n- Understanding of mobile UI/UX principles\n- Published apps on Play Store/App Store is a plus",
                'benefit' => "- Competitive salary\n- MacBook for development\n- Health & dental insurance\n- Learning budget\n- Hybrid working",
                'gaji_min' => 'Rp 9.000.000',
                'gaji_max' => 'Rp 14.000.000',
                'email_kontak' => 'hr@mobilesolutions.id',
                'website' => 'https://mobilesolutions.id',
                'tanggal_tutup' => Carbon::now()->addDays(35)->format('Y-m-d'),
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Content Writer',
                'perusahaan' => 'Media Online Nusantara',
                'lokasi' => 'Remote',
                'tipe_pekerjaan' => 'Freelance',
                'level' => 'Entry Level',
                'deskripsi' => "Kami mencari content writer yang kreatif untuk membuat konten berkualitas.\n\nTugas:\n- Menulis artikel SEO-friendly\n- Riset topik dan keyword\n- Edit dan proofread konten\n- Mengikuti content calendar",
                'kualifikasi' => "- Kemampuan menulis yang baik dalam Bahasa Indonesia\n- Memahami dasar-dasar SEO\n- Dapat bekerja dengan deadline\n- Kreatif dan detail-oriented\n- Pengalaman menulis (blog/media online) adalah nilai plus",
                'benefit' => "- Bayaran per artikel kompetitif\n- Flexible working time\n- Remote work\n- Kesempatan menjadi full time",
                'gaji_min' => 'Rp 150.000/artikel',
                'gaji_max' => 'Rp 300.000/artikel',
                'email_kontak' => 'editor@medianusantara.com',
                'website' => null,
                'tanggal_tutup' => Carbon::now()->addDays(15)->format('Y-m-d'),
                'status' => 'Aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('lowongan')->insert($lowongan);
    }
}
