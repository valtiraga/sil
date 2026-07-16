<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ─── Admin Account ────────────────────────────────
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@politeknikapp.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // ─── Dosen Account ────────────────────────────────
        $dosen1 = User::create([
            'name' => 'Dr. Budi Santoso',
            'email' => 'budi.santoso@politeknikapp.ac.id',
            'password' => Hash::make('password'),
            'role' => 'dosen',
            'is_active' => true,
        ]);

        $dosen2 = User::create([
            'name' => 'Dr. Siti Aminah',
            'email' => 'siti.aminah@politeknikapp.ac.id',
            'password' => Hash::make('password'),
            'role' => 'dosen',
            'is_active' => true,
        ]);

        // ─── Departments ──────────────────────────────────
        $tiDept = \App\Models\Department::create([
            'code' => 'TI',
            'name' => 'Teknik Informatika',
            'head_of_department' => 'Dr. Budi Santoso',
            'is_active' => true,
        ]);

        $miDept = \App\Models\Department::create([
            'code' => 'MI',
            'name' => 'Manajemen Informatika',
            'head_of_department' => 'Dr. Siti Aminah',
            'is_active' => true,
        ]);

        $ppDept = \App\Models\Department::create([
            'code' => 'PP',
            'name' => 'Perdagangan dan Pemasaran',
            'head_of_department' => null,
            'is_active' => true,
        ]);

        // ─── Subjects ─────────────────────────────────────
        $pemweb = \App\Models\Subject::create([
            'department_id' => $tiDept->id,
            'code' => 'TI201',
            'name' => 'Pemrograman Web',
            'credits' => 3,
            'semester' => 3,
            'description' => 'Mata kuliah dasar pemrograman web menggunakan HTML, CSS, JavaScript, dan PHP.',
            'is_active' => true,
        ]);

        $basis = \App\Models\Subject::create([
            'department_id' => $tiDept->id,
            'code' => 'TI202',
            'name' => 'Basis Data',
            'credits' => 3,
            'semester' => 3,
            'description' => 'Konsep database relasional, SQL, normalisasi, dan perancangan ERD.',
            'is_active' => true,
        ]);

        $siMk = \App\Models\Subject::create([
            'department_id' => $miDept->id,
            'code' => 'MI101',
            'name' => 'Sistem Informasi Manajemen',
            'credits' => 3,
            'semester' => 2,
            'description' => 'Pengantar sistem informasi untuk manajemen organisasi.',
            'is_active' => true,
        ]);

        // ─── Courses ──────────────────────────────────────
        $course1 = \App\Models\Course::create([
            'subject_id' => $pemweb->id,
            'lecturer_id' => $dosen1->id,
            'name' => 'Pemrograman Web - Kelas A',
            'description' => 'Kelas pemrograman web semester ganjil 2026/2027.',
            'start_date' => '2026-09-01',
            'end_date' => '2027-01-31',
            'status' => 'active',
        ]);

        $course2 = \App\Models\Course::create([
            'subject_id' => $basis->id,
            'lecturer_id' => $dosen1->id,
            'name' => 'Basis Data - Kelas A',
            'description' => 'Kelas basis data semester ganjil 2026/2027.',
            'start_date' => '2026-09-01',
            'end_date' => '2027-01-31',
            'status' => 'active',
        ]);

        $course3 = \App\Models\Course::create([
            'subject_id' => $siMk->id,
            'lecturer_id' => $dosen2->id,
            'name' => 'SIM - Kelas A',
            'description' => 'Kelas Sistem Informasi Manajemen semester genap.',
            'start_date' => '2026-09-01',
            'end_date' => '2027-01-31',
            'status' => 'draft',
        ]);

        // ─── Students ─────────────────────────────────────
        $mhsUser1 = User::create([
            'name' => 'Ahmad Rizky',
            'email' => '2026001@student.politeknikapp.ac.id',
            'password' => Hash::make('2026001'),
            'role' => 'mahasiswa',
            'is_active' => true,
        ]);

        $mhs1 = \App\Models\Student::create([
            'user_id' => $mhsUser1->id,
            'department_id' => $tiDept->id,
            'nim' => '2026001',
            'full_name' => 'Ahmad Rizky',
            'email' => '2026001@student.politeknikapp.ac.id',
            'phone' => '081234567890',
            'enrollment_year' => 2026,
            'current_semester' => 1,
            'status' => 'active',
        ]);

        $mhsUser2 = User::create([
            'name' => 'Dewi Safitri',
            'email' => '2026002@student.politeknikapp.ac.id',
            'password' => Hash::make('2026002'),
            'role' => 'mahasiswa',
            'is_active' => true,
        ]);

        $mhs2 = \App\Models\Student::create([
            'user_id' => $mhsUser2->id,
            'department_id' => $tiDept->id,
            'nim' => '2026002',
            'full_name' => 'Dewi Safitri',
            'email' => '2026002@student.politeknikapp.ac.id',
            'phone' => '081234567891',
            'enrollment_year' => 2026,
            'current_semester' => 1,
            'status' => 'active',
        ]);

        // ─── Enrollments ──────────────────────────────────
        \App\Models\Enrollment::create([
            'course_id' => $course1->id,
            'student_id' => $mhs1->id,
            'progress' => 0,
            'enrolled_at' => now(),
        ]);

        \App\Models\Enrollment::create([
            'course_id' => $course1->id,
            'student_id' => $mhs2->id,
            'progress' => 0,
            'enrolled_at' => now(),
        ]);

        \App\Models\Enrollment::create([
            'course_id' => $course2->id,
            'student_id' => $mhs1->id,
            'progress' => 0,
            'enrolled_at' => now(),
        ]);

        // ─── Question Banks ──────────────────────────────
        \App\Models\QuestionBank::create([
            'subject_id' => $pemweb->id,
            'created_by' => $dosen1->id,
            'question' => 'Apa kepanjangan dari HTML?',
            'question_type' => 'multiple_choice',
            'options' => ['Hyper Text Markup Language', 'High Tech Modern Language', 'Hyper Transfer Markup Language', 'Home Tool Markup Language'],
            'answer_key' => 'Hyper Text Markup Language',
            'difficulty' => 'easy',
            'is_active' => true,
        ]);

        \App\Models\QuestionBank::create([
            'subject_id' => $pemweb->id,
            'created_by' => $dosen1->id,
            'question' => 'Jelaskan perbedaan antara CSS Flexbox dan CSS Grid!',
            'question_type' => 'essay',
            'options' => null,
            'answer_key' => 'Flexbox adalah layout satu dimensi (baris atau kolom), sedangkan Grid adalah layout dua dimensi (baris dan kolom sekaligus).',
            'difficulty' => 'medium',
            'is_active' => true,
        ]);

        \App\Models\QuestionBank::create([
            'subject_id' => $basis->id,
            'created_by' => $dosen1->id,
            'question' => 'SQL adalah bahasa pemrograman prosedural.',
            'question_type' => 'true_false',
            'options' => null,
            'answer_key' => 'Salah',
            'difficulty' => 'easy',
            'is_active' => true,
        ]);
    }
}
