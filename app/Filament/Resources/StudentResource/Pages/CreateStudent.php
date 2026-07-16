<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    /**
     * Automatically create a User account for the student.
     */
    protected function afterCreate(): void
    {
        $student = $this->record;

        $user = User::create([
            'name' => $student->full_name,
            'email' => $student->email ?? $student->nim . '@student.politeknikapp.ac.id',
            'password' => Hash::make($student->nim),
            'role' => 'mahasiswa',
            'is_active' => true,
        ]);

        $student->update(['user_id' => $user->id]);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
