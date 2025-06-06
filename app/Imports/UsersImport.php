<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;

class UsersImport implements ToCollection,WithHeadingRow,WithValidation
{
    use Importable;


    public function rules(): array
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'email' => 'Email is required',
        ];
    }


    public function collection(Collection $rows)
    {
        // dd($rows);

        foreach ($rows as $row) 
        {
            dd($row['name']);
            User::create([
                'name' => $row[0],
            ]);
        }
    }
}