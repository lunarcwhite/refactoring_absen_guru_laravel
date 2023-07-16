<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;

class ImportGuru implements WithHeadingRow, ToCollection, SkipsOnError, SkipsEmptyRows, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    use Importable;

    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row) {
            $password = bcrypt('gbghfd65#2w4512345sdghgh^$^');
            User::create([
                'username' => $row['nuptk'],
                'password' => $password,
                'email' => $row['email'],
                'role_id' => 2,
                'nama' => $row['nama_guru'],
                'no_hp' => $row['no_hp'],
                'nuptk' => $row['nuptk'],
            ]);
            // Siswa::create([
            //     'nama_siswa' => $row['nama_siswa'],
            //     'nisn' => $row['nisn'],
            //     'jurusan_id' => $jurusan->id,
            //     'tahun_ajaran_id' => $tahunAjaran->id,
            //     'user_id' => $id
            // ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
    }

    public function rules(): array
    {
        return [
            'nuptk' => 'required|unique:users,nuptk',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|unique:users,no_hp',
            'nama_guru' => 'required'
        ];
    }

}
