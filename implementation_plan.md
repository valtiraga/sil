# Implementation Plan — Sistem E-Learning Politeknik APP Jakarta (Updated)

## Background

Berdasarkan PRD dan feedback user, sistem e-learning ini memiliki **3 panel terpisah**:
- **Admin** (`/admin`) — Menyiapkan data master (Prodi, mata kuliah, user), membuat course, dan meng-assign dosen
- **Dosen** (`/dosen`) — Mengelola course yang di-assign, enroll mahasiswa, kelola konten & bank soal, buat kuis, lihat nilai, moderasi forum
- **Mahasiswa** (`/mahasiswa`) — Mengikuti course, akses materi, mengerjakan kuis, forum diskusi

### Tech Stack
- **Laravel 12** + **Filament v5** + **PostgreSQL** + **Livewire 4**

---

## Arsitektur & Alur Kerja

```mermaid
flowchart TD
    A[Admin] -->|Buat & assign| C[Course + Dosen]
    A -->|Kelola| D[Prodi, Mata Kuliah, Users]
    
    DS[Dosen] -->|Kelola course di-assign| E[Konten: PDF & Video]
    DS -->|Enroll| M[Mahasiswa]
    DS -->|Buat| Q[Kuis dari Bank Soal]
    DS -->|Lihat| N[Nilai Mahasiswa]
    DS -->|Moderasi| F[Forum Diskusi]
    
    M -->|Akses| E
    M -->|Kerjakan| Q
    M -->|Diskusi| F
```

---

## Skema Database (ERD)

```mermaid
erDiagram
    users ||--o| mahasiswa : "has profile"
    Prodi ||--o{ mahasiswa : "has many"
    Prodi ||--o{ mata_kuliah : "has many"
    mata_kuliah ||--o{ courses : "has many"
    users ||--o{ courses : "dosen assigned"
    courses ||--o{ course_contents : "has many"
    courses ||--o{ enrollments : "has many"
    mahasiswa ||--o{ enrollments : "has many"
    mata_kuliah ||--o{ bank_soal : "has many"
    courses ||--o{ kuis : "has many"
    kuis ||--o{ kuis_soal : "has questions"
    bank_soal ||--o{ kuis_soal : "used in"
    kuis ||--o{ kuis_attempts : "has attempts"
    mahasiswa ||--o{ kuis_attempts : "attempts"
    kuis_attempts ||--o{ kuis_jawaban : "has answers"
    bank_soal ||--o{ kuis_jawaban : "answered"
    mata_kuliah ||--o{ forum_topics : "has many"
    users ||--o{ forum_topics : "created by"
    forum_topics ||--o{ forum_replies : "has many"
    users ||--o{ forum_replies : "created by"

    users {
        bigint id PK
        string name
        string email UK
        string password
        enum role "admin/dosen/mahasiswa"
        boolean is_active
        timestamp last_login_at
    }

    Prodi {
        bigint id PK
        string kode UK
        string nama
        string ketua_jurusan
        boolean is_active
    }

    mahasiswa {
        bigint id PK
        bigint user_id FK
        bigint jurusan_id FK
        string nim UK
        string nama_lengkap
        string email
        string no_telepon
        int angkatan
        int semester_aktif
        enum status "aktif/cuti/lulus/do"
        string foto_profil
    }

    mata_kuliah {
        bigint id PK
        bigint jurusan_id FK
        string kode UK
        string nama
        int sks
        int semester
        text deskripsi
        boolean is_active
    }

    courses {
        bigint id PK
        bigint mata_kuliah_id FK
        bigint dosen_id FK "assigned dosen"
        string nama
        text deskripsi
        date tanggal_mulai
        date tanggal_selesai
        enum status "draft/aktif/selesai"
    }

    course_contents {
        bigint id PK
        bigint course_id FK
        string judul
        enum tipe "pdf/video"
        string file_path
        text deskripsi
        int urutan
    }

    enrollments {
        bigint id PK
        bigint course_id FK
        bigint mahasiswa_id FK
        decimal progress
        decimal nilai_akhir
        timestamp enrolled_at
    }

    bank_soal {
        bigint id PK
        bigint mata_kuliah_id FK
        bigint created_by FK
        text pertanyaan
        enum tipe_soal "pilihan_ganda/essay/benar_salah"
        json opsi_jawaban
        text kunci_jawaban
        enum tingkat_kesulitan "mudah/sedang/sulit"
    }

    kuis {
        bigint id PK
        bigint course_id FK
        string judul
        text deskripsi
        int durasi_menit
        decimal nilai_minimum
        boolean is_active
        datetime waktu_mulai
        datetime waktu_selesai
    }

    kuis_soal {
        bigint id PK
        bigint kuis_id FK
        bigint bank_soal_id FK
        int urutan
        decimal bobot
    }

    kuis_attempts {
        bigint id PK
        bigint kuis_id FK
        bigint mahasiswa_id FK
        datetime mulai_at
        datetime selesai_at
        decimal total_nilai
        enum status "mengerjakan/selesai/dinilai"
    }

    kuis_jawaban {
        bigint id PK
        bigint kuis_attempt_id FK
        bigint bank_soal_id FK
        text jawaban
        boolean is_correct
        decimal nilai
    }

    forum_topics {
        bigint id PK
        bigint mata_kuliah_id FK
        bigint user_id FK
        string judul
        text isi
        boolean is_pinned
        boolean is_locked
        int views_count
    }

    forum_replies {
        bigint id PK
        bigint forum_topic_id FK
        bigint user_id FK
        text isi
        string attachment
    }
```

---

## Phase 1 — Migrations & Models
> Lihat file migration yang sudah dibuat di `database/migrations/`

## Phase 2 — Admin Panel Resources
- JurusanResource, MataKuliahResource, UserResource, CourseResource (create + assign dosen)

## Phase 3 — Dosen Panel
- Dashboard: daftar course yang di-assign
- Kelola konten course (upload PDF/video)
- Kelola bank soal per mata kuliah
- Buat & kelola kuis (pilih soal dari bank soal)
- Enroll mahasiswa ke course
- Lihat nilai & progress mahasiswa
- Moderasi forum diskusi

## Phase 4 — Mahasiswa Panel
- Dashboard: daftar course enrolled
- Akses materi (download PDF, putar video)
- Kerjakan kuis (timer, submit jawaban, lihat hasil)
- Forum diskusi (buat topik, reply)

## Phase 5 — Dashboard Widgets & Seeder

---
