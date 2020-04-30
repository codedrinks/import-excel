<?php

namespace App\Imports;

use App\Alumno;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AlumnosImport implements ToModel, WithHeadingRow//, WithValidation
{
    private $numRows;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
            ++$this->numRows;
            return new Alumno([
                'nombre' => $row['nombre'],
                'paterno' => $row['paterno'],
                'materno' => $row['materno'],
                'fecha_nacimiento' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_nacimiento']),
                'email' => $row['email'],
                'telefono' => $row['telefono']
            ]);

    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|max:45',
            'paterno' => 'required|max:45',
            'materno' => 'required|max:45',
            'fecha_nacimiento' => 'required',
            'email' => 'required|email',
            'telefono' => 'nullable|max:15',
        ];
    }

    public function getRowCount(): int
    {
        return $this->numRows;
    }
}
