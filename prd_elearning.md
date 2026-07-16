# Product Requirements Document (PRD)
## Sistem Informasi E-Learning Politeknik APP Jakarta

| | |
|--|--|
| **Nama Sistem** | Sistem Informasi E-Learning Politeknik APP Jakarta |
| **Tanggal** | 16 Juli 2026 |
| **Penyusun** | [Nama] — [Jabatan] |
| **Instansi** | Politeknik APP Jakarta |

---

## Ringkasan Sistem

> *Sistem e-learning terpadu untuk mendukung kegiatan belajar mengajar secara digital di Politeknik APP Jakarta.*

Politeknik APP Jakarta membutuhkan sistem e-learning terpadu untuk mengelola kegiatan **pembelajaran daring (online learning)** yang mencakup pengelolaan data akademik, distribusi materi kuliah, evaluasi mahasiswa, dan forum diskusi. Sistem ini memudahkan mahasiswa mengakses materi dan mengikuti course secara mandiri, membantu dosen/admin mengelola konten pembelajaran, serta memberikan pimpinan laporan aktivitas akademik real-time. Target: memangkas proses distribusi materi dan evaluasi dari **manual/tatap muka** menjadi **digital & terintegrasi dalam satu platform**.

---

## 1. Pengguna Sistem

| Peran | Siapa | Yang Mereka Lakukan |
|-------|-------|---------------------|
| **Administrator** | Staf TI / Admin Akademik | Kelola seluruh data master (jurusan, mahasiswa, user, course, bank soal, mata kuliah), kelola hak akses pengguna |
| **Dosen** | Dosen pengampu mata kuliah | Upload materi (modul PDF, video), kelola bank soal, moderasi forum diskusi |
| **Mahasiswa** | Mahasiswa aktif Politeknik APP Jakarta | Mengikuti course, download modul, memutar video, mengerjakan soal/kuis, aktif di forum diskusi |
| **Pimpinan** | Direktur / Ketua Jurusan | Lihat dashboard dan laporan aktivitas e-learning — hanya baca |

---

## 2. Layanan yang Dikelola Sistem

> *Untuk setiap layanan/fitur: jelaskan alurnya dan data apa yang perlu dicatat.*
> *Aturan bisnis penting wajib dituliskan — ini yang akan menjadi validasi di sistem.*

---

### Layanan 1 — Manajemen Data Jurusan

**Deskripsi:** Pengelolaan data jurusan/program studi yang tersedia di Politeknik APP Jakarta. Data jurusan menjadi referensi utama untuk pengelompokan mahasiswa dan mata kuliah.

**Alur:**
1. Admin membuka menu Data Jurusan
2. Admin menambahkan data jurusan baru (kode jurusan, nama jurusan, ketua jurusan)
3. Admin dapat mengedit atau menghapus data jurusan yang sudah ada
4. Data jurusan digunakan sebagai referensi di modul mahasiswa dan mata kuliah

**Data yang dicatat:** kode jurusan · nama jurusan · ketua jurusan · status aktif/tidak aktif · tanggal dibuat

**Aturan bisnis:**
- Kode jurusan bersifat **unik**, tidak boleh duplikat
- Jurusan yang sudah memiliki mahasiswa atau mata kuliah terkait **tidak dapat dihapus**, hanya bisa dinonaktifkan
- Nama jurusan wajib diisi, minimal **3 karakter**

---

### Layanan 2 — Manajemen Data Mahasiswa

**Deskripsi:** Pengelolaan data mahasiswa aktif Politeknik APP Jakarta. Setiap mahasiswa terdaftar pada satu jurusan dan dapat mengikuti beberapa course mata kuliah.

**Alur:**
1. Admin membuka menu Data Mahasiswa
2. Admin menambahkan data mahasiswa baru (NIM, nama, email, jurusan, angkatan)
3. Sistem otomatis membuat akun user untuk mahasiswa tersebut
4. Admin dapat mengedit, menonaktifkan, atau mengekspor data mahasiswa
5. Data mahasiswa terhubung ke enrollment course

**Data yang dicatat:** NIM · nama lengkap · email · nomor telepon · jurusan · angkatan · semester aktif · status (aktif / cuti / lulus / DO) · foto profil

**Aturan bisnis:**
- NIM bersifat **unik**, tidak boleh duplikat
- Satu mahasiswa terdaftar pada **tepat satu jurusan**
- Email mahasiswa harus **valid dan unik** dalam sistem
- Mahasiswa dengan status **non-aktif** tidak dapat login ke sistem e-learning

---

### Layanan 3 — Manajemen Data User

**Deskripsi:** Pengelolaan akun pengguna sistem (admin, dosen, mahasiswa). Mengatur autentikasi, otorisasi, dan hak akses berdasarkan role.

**Alur:**
1. Admin membuka menu Data User
2. Admin menambahkan user baru dengan role (Admin / Dosen / Mahasiswa)
3. Admin menetapkan hak akses berdasarkan role
4. User melakukan login menggunakan email dan password
5. Admin dapat mereset password, menonaktifkan, atau menghapus akun user

**Data yang dicatat:** username · email · password (hashed) · role (admin / dosen / mahasiswa) · status akun (aktif / nonaktif) · last login · tanggal dibuat

**Aturan bisnis:**
- Email bersifat **unik** untuk setiap akun
- Password minimal **8 karakter** dengan kombinasi huruf dan angka
- Role menentukan menu dan fitur yang bisa diakses (RBAC)
- Akun yang nonaktif **tidak dapat login** ke sistem
- Satu user hanya memiliki **satu role utama**

---

### Layanan 4 — Manajemen Data Mata Kuliah

**Deskripsi:** Pengelolaan data mata kuliah yang tersedia pada setiap jurusan. Mata kuliah menjadi dasar pembuatan course dan forum diskusi.

**Alur:**
1. Admin membuka menu Data Mata Kuliah
2. Admin menambahkan mata kuliah baru (kode MK, nama MK, SKS, jurusan, semester, dosen pengampu)
3. Admin dapat mengedit atau menonaktifkan mata kuliah
4. Mata kuliah yang aktif dapat dibuatkan course e-learning
5. Setiap mata kuliah otomatis memiliki forum diskusi terkait

**Data yang dicatat:** kode mata kuliah · nama mata kuliah · jumlah SKS · jurusan · semester · dosen pengampu · status (aktif / tidak aktif) · deskripsi

**Aturan bisnis:**
- Kode mata kuliah bersifat **unik**
- Satu mata kuliah terkait dengan **satu jurusan**
- Satu mata kuliah memiliki minimal **satu dosen pengampu**
- Mata kuliah yang sudah memiliki course aktif **tidak dapat dihapus**, hanya dinonaktifkan

---

### Layanan 5 — Manajemen Course (Pembelajaran)

**Deskripsi:** Pengelolaan course pembelajaran online yang berisi modul (file PDF yang bisa diunduh) dan video pembelajaran yang bisa diputar. Mahasiswa mendaftar/enroll pada course untuk mengakses konten.

**Alur:**
1. Admin/Dosen membuat course baru berdasarkan mata kuliah
2. Admin/Dosen menambahkan konten course: modul (PDF/dokumen) dan video pembelajaran
3. Mahasiswa melakukan enrollment pada course yang tersedia
4. Mahasiswa mengakses materi — download modul PDF atau memutar video
5. Sistem mencatat progress belajar mahasiswa (modul yang sudah diakses, video yang sudah ditonton)
6. Mahasiswa menyelesaikan course setelah semua materi selesai dipelajari

**Data yang dicatat:** nama course · mata kuliah terkait · deskripsi · dosen pengampu · daftar modul (judul, file, tipe: PDF/video) · daftar mahasiswa enrolled · progress per mahasiswa · tanggal mulai · tanggal selesai · status course (draft / aktif / selesai)

**Aturan bisnis:**
- Satu course terkait dengan **satu mata kuliah**
- Mahasiswa harus melakukan **enrollment** sebelum bisa mengakses konten course
- File modul yang diupload maksimal **50 MB** per file
- Video yang diupload mendukung format **MP4, MKV, WEBM**
- Progress mahasiswa dihitung berdasarkan **jumlah materi yang sudah diakses** dibagi total materi
- Course dengan status **draft** hanya bisa dilihat oleh admin dan dosen

---

### Layanan 6 — Manajemen Bank Soal

**Deskripsi:** Pengelolaan kumpulan soal per mata kuliah yang dapat digunakan untuk kuis, ujian, atau latihan. Soal disusun oleh admin/dosen dan dikelompokkan berdasarkan mata kuliah dan tingkat kesulitan.

**Alur:**
1. Admin/Dosen membuka menu Bank Soal
2. Admin/Dosen memilih mata kuliah dan menambahkan soal baru
3. Admin/Dosen mengisi soal (pertanyaan, opsi jawaban, kunci jawaban, tingkat kesulitan)
4. Soal tersimpan di bank soal dan dapat digunakan untuk membuat kuis/ujian di course
5. Admin/Dosen dapat mengedit, menghapus, atau mengimpor soal secara massal

**Data yang dicatat:** mata kuliah · pertanyaan · tipe soal (pilihan ganda / essay / benar-salah) · opsi jawaban · kunci jawaban · tingkat kesulitan (mudah / sedang / sulit) · pembuat soal · tanggal dibuat

**Aturan bisnis:**
- Soal pilihan ganda wajib memiliki **minimal 4 opsi jawaban** dan **1 kunci jawaban**
- Setiap soal wajib dikaitkan dengan **satu mata kuliah**
- Soal yang sudah digunakan di kuis/ujian aktif **tidak dapat dihapus**, hanya dinonaktifkan
- Import soal massal mendukung format **Excel (.xlsx)**

---

### Layanan 7 — Forum Diskusi per Mata Kuliah

**Deskripsi:** Forum diskusi online yang memungkinkan mahasiswa dan dosen berdiskusi terkait materi perkuliahan. Setiap mata kuliah memiliki forum diskusi sendiri.

**Alur:**
1. Mahasiswa/Dosen membuka forum diskusi pada mata kuliah tertentu
2. Mahasiswa membuat topik/thread diskusi baru
3. Mahasiswa/Dosen membalas topik diskusi (reply)
4. Dosen dapat menyematkan (pin) topik penting
5. Dosen/Admin dapat menghapus atau mengunci topik yang tidak sesuai
6. Sistem mengirim notifikasi ketika ada balasan baru pada topik yang diikuti

**Data yang dicatat:** mata kuliah · judul topik · isi topik · pembuat topik · balasan (isi, penulis, waktu) · status topik (terbuka / dikunci) · pin status · jumlah views · jumlah reply

**Aturan bisnis:**
- Hanya mahasiswa yang **ter-enroll** pada mata kuliah terkait yang dapat berdiskusi di forum tersebut
- Dosen pengampu mata kuliah memiliki hak **moderasi** (pin, kunci, hapus topik)
- Satu topik diskusi maksimal **500 karakter** untuk judul
- Balasan diskusi mendukung **teks dan lampiran gambar**
- Topik yang dikunci **tidak dapat dibalas** oleh mahasiswa

---

## 3. Laporan & Dashboard yang Dibutuhkan

### Dashboard Utama (tampil saat login)

| Informasi | Keterangan |
|-----------|------------|
| Total Mahasiswa Aktif | Jumlah mahasiswa dengan status aktif di seluruh jurusan |
| Total Course Aktif | Jumlah course yang sedang berjalan (status aktif) |
| Total Enrollment Bulan Ini | Jumlah enrollment baru mahasiswa pada course dalam bulan berjalan |
| Aktivitas Forum Terkini | Jumlah topik dan balasan diskusi 7 hari terakhir |
| Progress Rata-rata Mahasiswa | Persentase rata-rata penyelesaian course oleh mahasiswa |
| Statistik per Jurusan | Jumlah mahasiswa, mata kuliah, dan course per jurusan |

### Laporan Berkala

| Laporan | Frekuensi | Isi | Format |
|---------|-----------|-----|--------|
| Rekap Enrollment | Bulanan | Jumlah mahasiswa enrolled per course per bulan | Excel & PDF |
| Progress Pembelajaran | Bulanan | Persentase penyelesaian course per mahasiswa per mata kuliah | Excel & PDF |
| Statistik Mahasiswa per Jurusan | Semesteran | Jumlah mahasiswa aktif, cuti, lulus per jurusan | PDF |
| Aktivitas Forum Diskusi | Bulanan | Jumlah topik, reply, mahasiswa aktif per forum mata kuliah | Excel & PDF |
| Rekap Bank Soal | Semesteran | Jumlah soal per mata kuliah per tipe dan tingkat kesulitan | Excel |

---

> **Catatan untuk AI Coding Assistant:**
> - Setiap **layanan** di Bagian 2 → 1 modul Filament Resource + set tabel database
> - Setiap **alur** → urutan status pada kolom `status` di tabel transaksi
> - Setiap **data yang dicatat** → kolom-kolom pada tabel yang bersangkutan
> - Setiap **aturan bisnis** → validasi dan business logic di Model/Controller
> - Bagian 3 → widget dashboard Filament + fitur ekspor PDF/Excel
> - **Tabel utama:** `jurusan`, `mahasiswa`, `users`, `mata_kuliah`, `courses`, `course_contents` (modul & video), `enrollments`, `bank_soal`, `forum_topics`, `forum_replies`
> - **Relasi:** jurusan → mahasiswa (1:M), jurusan → mata_kuliah (1:M), mata_kuliah → courses (1:M), courses → course_contents (1:M), courses ↔ mahasiswa via enrollments (M:M), mata_kuliah → bank_soal (1:M), mata_kuliah → forum_topics (1:M), forum_topics → forum_replies (1:M)

---
