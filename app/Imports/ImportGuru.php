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
use DB;

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
                'username' => $row['no_hp'],
                'password' => $password,
                'email' => $row['email'],
                'role_id' => 2,
                'nama' => $row['nama_guru'],
                'no_hp' => $row['no_hp'],
                'nuptk' => $row['nuptk'],
            ]);
                      $user = User::where('nuptk', $row['nuptk'])->first();
            $hari = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        for ($i=1; $i <= 6; $i++) { 
                DB::table('setting_absens')->insert([
                    'status' => 1,
                    'hari' => $hari[$i],
                    'jam' => '07:00:00',
                    'user_id' => $user->id
                ]);
            }
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
